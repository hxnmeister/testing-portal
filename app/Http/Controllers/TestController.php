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
                'isCorrect' => 'required|array|min:'.count($request->questions)
            ]
        );

        $testTitle = $request->testTitle;
        $newTest = Test::create
        (
            [
                'title' => $testTitle,
            ]
        );

        foreach($request->questions as $qIndex => $question)
        {
            $newQuestion = Question::create
            (
                [
                    'text' => $question,
                    'test_id' => $newTest->id
                ]
            );

            foreach($request->answers[$qIndex] as $aIndex => $answer)
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
                'isCorrect' => 'required|array|min:'.count($request->questions)
            ]
        );
        // dd($test->questions[0]->answers);
        $oldQuestions = $test->questions;
        $newQuestions = $request->questions; 
        $oldName = $test->title;
        $test->update(['title' => $request->testTitle]);

        if(count($newQuestions) === count($oldQuestions))
        {
            foreach ($newQuestions as $qIndex => $question) 
            {
                $oldQuestions[$qIndex]->update(['text' => $question]);
            }
        }
        else
        {
            $test->questions()->delete();
            
            foreach ($newQuestions as $qIndex => $question) 
            {
                $test->questions()->create
                (
                    ['text' => $question]
                );
            }
        }

        foreach ($request->answers as $qIndex => $question) 
        {
            if(count($question) === count($test->questions[$qIndex]->answers))
            {
                foreach ($question as $aIndex => $answer) 
                {
                    $test->questions[$qIndex]->answers[$aIndex]->update
                    (
                        [
                            'text' => $answer,
                            'is_correct' => in_array($aIndex, $request->isCorrect[$qIndex])
                        ]
                    );
                }
            }
            else
            {
                $test->questions[$qIndex]->answers()->delete();

                foreach ($question as $aIndex => $answer) 
                {
                    $test->questions[$qIndex]->answers()->create
                    (
                        [
                            'text' => $answer,
                            'is_correct' => in_array($aIndex, $request->isCorrect[$qIndex])
                        ]
                    );
                }
            }
        }

        return redirect()->route('admin.home')->with('success', 'Test '.$oldName.' has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Test $test)
    {
        //
    }
}
