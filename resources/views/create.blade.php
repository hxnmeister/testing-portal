@extends('templates.index')
@section('title', 'Creating Test')
@section('content')
    <form action="{{route('test.store')}}" method="post">
        @csrf
        
        <div class="container" id="test-info">
            <label for="test-title">Test Title:</label>
            <input type="text" name="testTitle" id="test-title" class="form-control" value="{{old('test-title')}}">

            {{-- {{dd($errors)}} --}}
            <div id="questions-container">

                @if ($errors->has('questions') || $errors->has('answers'))
                    <div class="alert alert-danger mb-3">
                        <ul>
                            @error('questions') <li>{{ $message }}</li> @enderror
                            @error('answers') <li>{{ $message }}</li> @enderror
                        </ul>
                    </div>
                @endif

                @if (old('questions'))
                    @foreach (old('questions') as $questionIndex => $question)
                        <div class="accordion mt-3">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    {{-- Заголовок для вопроса --}}
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse{{$questionIndex}}" aria-expanded="false" aria-controls="panelsStayOpen-collapse{{$questionIndex}}">
                                        Question #{{$loop->iteration}}
                                    </button>
                                    {{-- --}}
                                </h2>
                                <div id="panelsStayOpen-collapse{{$questionIndex}}" class="accordion-collapse collapse @if($errors->has('questions.'.$questionIndex) || $errors->has('answers.'.$questionIndex) || $errors->has('answers.'.$questionIndex.'.*')) show @endif">
                                    <div class="accordion-body">
                                        {{-- Блок с отображением вопросов --}}
                                        <label for="question-{{$loop->iteration}}">Question Text:</label>
                                        <input id="question-{{$loop->iteration}}" type="text" name="questions[]" class="form-control @error('questions.'.$questionIndex) is-invalid @enderror" value="{{old('questions.'.$questionIndex)}}">
                                        @error('questions.'.$questionIndex)
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                        {{-- --}}

                                        <div class="container answers-container">

                                            @error('answers.'.$questionIndex)
                                                <div class="alert alert-danger mt-3">
                                                    {{ $message }}
                                                </div>
                                            @enderror

                                            {{-- Блок с отображением ответов --}}
                                            @if (old('answers.'.$questionIndex))
                                                @foreach (old('answers.'.$questionIndex) as $answerIndex => $answer)
                                                    <div class="answer mt-2">
                                                        <label>Answer #{{$loop->iteration}}</label>
                                                        <input type="text" name="answers[{{$questionIndex}}][]" class="form-control @error('answers.'.$questionIndex.'.'.$answerIndex) is-invalid @enderror" value="{{old('answers.'.$questionIndex.'.'.$answerIndex)}}"">

                                                        <input type="checkbox" name="isCorrect[{{$questionIndex}}][]" value="{{$answerIndex}}" @if(old('isCorrect.'.$questionIndex) && in_array($answerIndex, old('isCorrect.'.$questionIndex))) checked @endif>
                                                        <label>Is Correct?</label>

                                                        @error('answers.'.$questionIndex.'.'.$answerIndex)
                                                            <div class="invalid-feedback">
                                                                {{$message}}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                @endforeach
                                            @endif
                                            {{-- --}}

                                            <div class="mt-2 control-buttons">
                                                <button data-add-question-id="{{$questionIndex}}" type="button" class="btn btn-outline-info btn-sm add-answer">Add Answer</button>
                                                <button data-delete-question-id="{{$questionIndex}}" type="button" class="btn btn-outline-danger btn-sm delete-answer">Delete Answer</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="mt-3 d-flex justify-content-between">
                <div>
                    <button id="add-question" type="button" class="btn btn-outline-info btn-sm">Add Question</button>
                    <button id="delete-question" type="button" class="btn btn-outline-danger btn-sm">Delete Question</button>
                </div>
                
                <button id="test-submit" type="submit" class="btn btn-outline-success btn-sm">Save Test</button>
            </div>
        </div>
    </form>

    <script src="{{ asset('js/script.js') }}"></script>
@endsection