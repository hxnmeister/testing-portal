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

            @include('_test-body')
            
            <button type="submit" class="btn btn-outline-success">Send Answers</button>
        </div>
    </form>
@endsection