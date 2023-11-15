<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Result;
use App\Models\Test;
use App\Rules\CompareSize;
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

        return view('test', compact('currentTest'));
    }

    public function getResult(Request $request, Test $test)
    {
        $request->validate
        (
            [
                'userAnswers' => ['required', 'array', new CompareSize(count($test->questions))],
            ]
        );

        $userAnswers = $request->userAnswers;
        $errors = [];

        foreach($test->questions as $qIndex => $question)
        {
            if(count($question->answers->where('is_correct', true)) < count($userAnswers[$qIndex]))
            {
                $errors['userAnswers.'.$qIndex] = 'You selected too many answers.';
            }
        }

        if(!empty($errors)) return redirect()->back()->withErrors($errors)->withInput();

        $summary = 0;
        $correctAnswers = 0;

        foreach ($test->questions as $qIndex => $question) 
        {
            foreach($question->answers as $aIndex => $answer)
            {
                if (isset($userAnswers[$qIndex][$aIndex]) && $answer->is_correct == true) 
                {
                    ++$summary;
                }
            }

            $correctAnswers += count($question->answers->where('is_correct', true));
        }

        Result::create
        (
            [
                'score' => $summary,
                'user_id' => Auth::user()->id,
                'test_id' => $test->id
            ]
        );

        return redirect()->route('mainPage')->with('summary', 'Final result: '.$summary.'/'.$correctAnswers.' points');
    }
}
