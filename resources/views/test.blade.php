@extends('layouts.app')
@section('title', $currentTest->title)

@section('content')
    <form action="{{route('result', ['test' => $currentTest->slug])}}" method="post">
        @csrf

        <div class="container mt-5">
            @error('userAnswers')
                <div class="alert alert-danger">
                    {{$message}}
                </div>
            @enderror

            <h3>You will receive 1 point per each correct answer!</h3>
            @foreach ($currentTest->questions as $qIndex => $question)
                <label for="question-{{$qIndex}}">{{$question->text}}</label>
                @error('userAnswers.'.$qIndex) <div class="alert alert-danger">{{$message}}</div> @enderror
                <div id="question-{{$qIndex}}" class="container">
                    @foreach ($question->answers as $aIndex => $answer)
                        <input type="checkbox" name="userAnswers[{{$qIndex}}][{{$aIndex}}]" id="answer-{{$qIndex}}{{$aIndex}}" @if(old('userAnswers.'.$qIndex.'.'.$aIndex) != null) checked @endif>
                        <label for="answer-{{$qIndex}}{{$aIndex}}">{{$answer->text}}</label>
                        <br>
                    @endforeach
                </div>
                <br>
            @endforeach
            
            <button type="submit" class="btn btn-outline-success">Send Answers</button>
        </div>
    </form>
@endsection