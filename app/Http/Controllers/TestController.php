<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Test;
use App\Rules\QuestionsAmount;
use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate
        (
            [
                'testTitle' => 'required|string|min:10|max:255',
                'questions' => 'required|array|min:2',
                'questions.*' => 'required|string|min:10',
                'answers' => 'required|array|min:2',
                'answers.*' => 'required|array|min:2',
                'answers.*.*' => 'required|string|min:10',
                'isCorrect.*' => 'required|array|min:2'
            ]
        );

        dd($request->isCorrect);

        // $testTitle = $request->testTitle;

        // foreach($request->questions as $qIndex => $question)
        // {
        //     $newQuestion = new Question();

        //     $newQuestion->text = $question;
        //     $newQuestion->save();

        //     foreach($request->answers[$qIndex] as $answer)
        //     {

        //     }
        // }

        // return to_route('home')->with('success', "Test \"$testTitle\" successfully added!");
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Test $test)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Test $test)
    {
        //
    }
}
