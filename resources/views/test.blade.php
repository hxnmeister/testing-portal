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

            @foreach ($currentTest->questions as $qIndex => $question)
                <label for="question-{{$qIndex}}">{{$question->text}} ({{$question->points}} points)</label>
                <br>
                
                @if ($question->image) <img src="{{asset('storage/'.$question->image)}}" alt="No-Image!" style="width: 10vw; height: 10vw"> @endif
                @error('userAnswers.'.$qIndex) <div class="alert alert-danger">{{$message}}</div> @enderror
                <div id="question-{{$qIndex}}" class="container">
                    @foreach ($question->answers as $aIndex => $answer)
                        <input type="checkbox" name="userAnswers[{{$qIndex}}][{{$aIndex}}]" value="{{$aIndex}}" id="answer-{{$qIndex}}{{$aIndex}}" @if(old('userAnswers.'.$qIndex.'.'.$aIndex) != null) checked @endif>
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