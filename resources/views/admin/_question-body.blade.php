<div class="accordion mt-3">
    <div class="accordion-item">
        <h2 class="accordion-header">
            {{-- Заголовок для вопроса --}}
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse{{$questionIndex}}" aria-expanded="false" aria-controls="panelsStayOpen-collapse{{$questionIndex}}">
                Question #{{$loop->iteration}}
            </button>
            {{-- --}}
        </h2>
        <div id="panelsStayOpen-collapse{{$questionIndex}}" class="accordion-collapse collapse @if($errors->has('questions.'.$questionIndex) || $errors->has('answers.'.$questionIndex) || $errors->has('answers.'.$questionIndex.'.*') || $errors->has('isCorrect.'.$questionIndex) || $errors->has('questionImage.'.$questionIndex) || $errors->has('questionValue.'.$questionIndex)) show @endif">
            <div class="accordion-body">
                @error('isCorrect.'.$questionIndex)
                    <div class="alert alert-danger mt-3">
                        <ul>
                            <li>{{ $message }}</li>
                        </ul>
                    </div>
                @enderror

                <label for="question-value-{{$questionIndex}}">Question Value: </label>
                <input type="number" name="questionValue[]" id="question-value-{{$questionIndex}}" min="1" step="1" value="{{is_object($question) ? intval($question->points) : old('questionValue.'.$questionIndex) }}" class="form-control @error('questionValue.'.$questionIndex) is-invalid @enderror">
                @error('questionValue.'.$questionIndex)
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror
                <br>
                
                <label for="question-image-{{$questionIndex}}">Choose Image for Question:</label>
                <input type="file" name="questionImage[{{$questionIndex}}]" id="question-image-{{$questionIndex}}" class="form-control @error('questionImage.'.$questionIndex) is-invalid @enderror">

                @error('questionImage.'.$questionIndex)
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror
                    <br>
                {{-- Блок с отображением вопросов --}}
                <label for="question-{{$questionIndex}}">Question Text:</label>
                <input id="question-{{$questionIndex}}" type="text" name="questions[]" class="form-control @error('questions.'.$questionIndex) is-invalid @enderror" value="{{is_object($question) ? $question->text : old('questions.'.$questionIndex)}}">
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
                    @elseif(is_object($question))
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