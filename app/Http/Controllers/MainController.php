<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function main()
    {
        $tests = Test::pluck('title', 'slug');

        return view('index', compact('tests'));
    }

    public function showTest($slug)
    {
        $currentTest = Test::where('slug', $slug)->first();
        $maxAttempts = 3;
        
        //Дана перевірка дозволяє перевірити кількість проходжень одного конкретного тесту, якщо спроб більше $maxAttempts то учасник не має права пройти тест ще раз
        return (Auth::user()->results()->where('test_id', $currentTest->id)->count() === $maxAttempts) ? redirect()->route('mainPage')->with('toManyAttempts', 'To Many Attempts!') : view('test', compact('currentTest'));
    }

    public function getResult(Request $request, Test $test)
    {
        $request->validate
        (
            [
                'userAnswers' => 'required|array|min:'.count($test->questions),
            ]
        );

        $userAnswers = $request->userAnswers;
        //Массив $errors створений для ручного збору помилок
        $errors = [];

        foreach($test->questions as $qIndex => $question)
        {
            //У даному циклі ми перевіряємо кількість відповідей для кожного питання
            if(count($question->answers->where('is_correct', true)) < count($userAnswers[$qIndex]))
            {
                $errors['userAnswers.'.$qIndex] = 'You selected too many answers.';
            }
        }
        
        if(!empty($errors)) return redirect()->back()->withErrors($errors)->withInput();

        //Змінна $summary аккумулює в собі значення фінального результату
        $summary = 0;
        //Змінна $pointsAmount отримує скалярне значення з максимальною кількісттю балів за один конкретний тест
        $pointsAmount = $test->questions()->sum('points');
        //Змінна $answerIsCorrect виступає у якості прапорцю який показує чи правильна була дана відповідь, потрібна для того щоб перевіряти відповіді з декількома варіантами
        $answerIsCorrect = false;

        foreach ($test->questions as $qIndex => $question) 
        {
            $correctAnswers = $question->answers->where('is_correct', true)->toArray();

            foreach($userAnswers[$qIndex] as $answerId)
            {
                if(count($correctAnswers) === count($userAnswers[$qIndex]) && $question->answers[$answerId]->is_correct == true)
                {
                    $answerIsCorrect = true;
                }
                else
                {
                    $answerIsCorrect = false;
                    break;
                }
            }

            if($answerIsCorrect) 
            {
                $summary += $question->points;
            }
        }

        Result::create
        (
            [
                'score' => $summary,
                'user_id' => Auth::user()->id,
                'test_id' => $test->id
            ]
        );

        return redirect()->route('mainPage')->with('summary', 'Final result: '.$summary.'/'.$pointsAmount.' points');
    }
}
