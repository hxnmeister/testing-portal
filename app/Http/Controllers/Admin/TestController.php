<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TestRequest;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Test;

class TestController extends Controller
{
    public function index()
    {
        $tests = Test::all();

        return view('admin.index', compact('tests'));
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(TestRequest $request)
    {
        $request->validate
        (
            [
                'testTitle' => 'required|string|min:10|max:255|unique:tests,title',
                'isCorrect' => 'required|array|min:'.count($request->questions),
            ]
        );

        //Зберігаю стару назву щоб показати користувачеві який тест було додано
        $testTitle = $request->testTitle;
        $newTest = Test::create(['title' => $testTitle]);
        
        $this->saveTest($request, $newTest);

        return redirect()->route('admin.home')->with('success', "Test \"$testTitle\" successfully added!");
    }

    public function show(Test $test)
    {
        
    }

    public function edit(Test $test)
    {
        return view('admin.edit', compact('test'));
    }

    public function update(TestRequest $request, Test $test)
    {
        $request->validate
        (
            [
                'testTitle' => 'required|string|min:10|max:255|unique:tests,title,'.$test->id,
                'isCorrect' => 'required|array|min:'.count($request->questions),
            ]
        );

        //Зберігаю стару назву тесту щоб показати який тест було змінено
        $oldName = $test->title;
        //Масив у якому буде зебережено усі шляхи до зображень які вже є в БД. Ці шляхи будуть використані для перезапису в БД
        $imagesPath = [];

        //Циклом перебираємо наявні питання
        foreach($test->questions as $qIndex => $question)
        {
            //Якщо питання має шлях до зображення то записуємо його до масиву
            if(isset($question->image)) $imagesPath[$qIndex] = $question->image;
        }

        $test->update(['title' => $request->testTitle]);
        $test->questions()->delete();
        
        //Потім передаємо масив для того щоб перезаписати шляхи до зображень
        $this->saveTest($request, $test, $imagesPath);

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

    private function saveTest(TestRequest $request, Test $test, array $imagesPath = null)
    {
        //Змінна $imagesPath використовується для перезапису шляхів до зображень
        
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
            elseif(isset($imagesPath[$qIndex]))
            {
                $newQuestion->image = $imagesPath[$qIndex];
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

    public function testPreview(Test $test)
    {
        return view('admin.test-preview', ['currentTest' => $test]);
    }
}
