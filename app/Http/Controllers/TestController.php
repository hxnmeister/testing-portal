<?php

namespace App\Http\Controllers;

use App\Http\Requests\TestRequest;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Test;
use App\Rules\CompareSize;
use App\Rules\QuestionsAmount;
use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tests = Test::all();

        return view('admin.index', compact('tests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TestRequest $request)
    {
        $request->validate
        (
            [
                'testTitle' => 'required|string|min:10|max:255|unique:tests,title',
                'isCorrect' => 'required|array|min:'.count($request->questions),
            ]
        );

        $testTitle = $request->testTitle;
        $newTest = Test::create(['title' => $testTitle]);

        $this->saveTest($request, $newTest);

        return redirect()->route('admin.home')->with('success', "Test \"$testTitle\" successfully added!");
    }

    /**
     * Display the specified resource.
     */
    public function show(Test $test)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Test $test)
    {
        return view('admin.edit', compact('test'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TestRequest $request, Test $test)
    {
        $request->validate
        (
            [
                'testTitle' => 'required|string|min:10|max:255|unique:tests,title,'.$test->id,
                'isCorrect' => 'required|array|min:'.count($request->questions),
            ]
        );

        $oldName = $test->title;

        $test->update(['title' => $request->testTitle]);
        $test->questions()->delete();
        $this->saveTest($request, $test);

        return redirect()->route('admin.home')->with('success', 'Test '.$oldName.' has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Test $test)
    {
        $testName = $test->title;
        $test->delete();

        return redirect()->route('admin.home')->with('success', 'Test '.$testName.' was successfully deleted!');
    }

    private function saveTest(TestRequest $request, Test $test)
    {
        foreach ($request->questions as $qIndex => $question) 
        {
            $newQuestion = Question::create
            (
                [
                    'text' => $question,
                    'test_id' => $test->id,
                    'points' => intval($request->questionValue[$qIndex])
                ]
            );

            if(isset($request->questionImage[$qIndex]))
            {
                $newQuestion->image = $request->file('questionImage')[$qIndex]->store('uploads', 'public');
                $newQuestion->save();
            }

            foreach ($request->answers[$qIndex] as $aIndex => $answer) 
            {
                Answer::create
                (
                    [
                        'text' => $answer,
                        'question_id' => $newQuestion->id,
                        'is_correct' => in_array($aIndex, $request->isCorrect[$qIndex])
                    ]
                );
            }
        }
    }
}
