<div class="accordion mt-3">
    <div class="accordion-item">
        <h2 class="accordion-header">
            {{-- Заголовок для вопроса --}}
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse{{$questionIndex}}" aria-expanded="false" aria-controls="panelsStayOpen-collapse{{$questionIndex}}">
                Question #{{$loop->iteration}}
            </button>
            {{-- --}}
        </h2>
        <div id="panelsStayOpen-collapse{{$questionIndex}}" class="accordion-collapse collapse @if($errors->has('questions.'.$questionIndex) || $errors->has('answers.'.$questionIndex) || $errors->has('answers.'.$questionIndex.'.*') || $errors->has('isCorrect.'.$questionIndex)) show @endif">
            <div class="accordion-body">
                @error('isCorrect.'.$questionIndex)
                    <div class="alert alert-danger mt-3">
                        <ul>
                            <li>{{ $message }}</li>
                        </ul>
                    </div>
                @enderror
                
                {{-- Блок с отображением вопросов --}}
                <label for="question-{{$loop->iteration}}">Question Text:</label>
                <input id="question-{{$loop->iteration}}" type="text" name="questions[]" class="form-control @error('questions.'.$questionIndex) is-invalid @enderror" value="@if(old('questions.'.$questionIndex)) {{old('questions.'.$questionIndex)}} @elseif(isset($test) && is_object($question)) {{$question->text}} @endif">
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
                            @include('admin._answer-body')
                        @endforeach
                    @elseif(isset($test) && is_object($question))
                        @foreach ($question->answers as $answerIndex => $answer)
                            @include('admin._answer-body')
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