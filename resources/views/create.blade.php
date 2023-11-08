@extends('templates.index')
@section('title', 'Creating Test')
@section('content')
    <div class="container mt-3">
        <form action="{{route('test.store')}}" method="post">
            @csrf

            <label for="test-title" class="mt-3">Test Title:</label>
            <input type="text" name="test" id="test-title" value="{{old('test')}}" class="form-control @error('test') is-invalid @enderror">
            @error('test')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
            @enderror

            <label for="question-text" class="mt-3">Question Text:</label>
            <textarea name="question" id="question-text" cols="10" rows="3" class="form-control @error('question') is-invalid @enderror">{{old('question')}}</textarea>
            @error('question')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
            @enderror

                @error('answers')
                    <div class="alert alert-danger mt-5">
                        {{$message}}
                    </div>
                @enderror

                <div class="accordion mt-3" id="accordionPanelsStayOpenExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="false" aria-controls="panelsStayOpen-collapseOne">
                                Answers To Question #1
                            </button>
                        </h2>
                        <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse @error('answers.*') show @enderror">
                            <div class="accordion-body">
                                <div id="answers-container">
                                    @if(old('answers'))
                                        @foreach (old('answers') as $answer)
                                            <label for="answer-{{$loop->iteration}}" class="mt-3">Answer {{$loop->iteration}}:</label>
                                            <input type="text" id="answer-{{$loop->iteration}}" value="{{$answer}}" name="answers[]" class="form-control mb-1 @error('answers.'.$loop->iteration - 1) is-invalid @enderror')">
                                            @error('answers.'.$loop->iteration - 1)
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        @endforeach
                                    @else
                                        <label for="answer-1" class="mt-3">Answer 1:</label>
                                        <input type="text" id="answer-1" name="answers[]" class="form-control mb-1">
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                

            <div class="d-flex justify-content-between mt-4">
                <button id="add-answer" type="button" class="btn btn-outline-info">Add answer</button>
                
                <button type="submit" class="btn btn-outline-success">Save</button>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() 
        {
            let answerIndex = $('input[name^="answers[]"]').length + 1;
            const maxAnswers = 8;
        
            $('#add-answer').click(function() 
            {
                if(answerIndex <= maxAnswers)
                {
                    const newAnswerField = 
                    `
                        <label for="answer-${answerIndex}" class="mt-3">Answer ${answerIndex}:</label>
                        <input type="text" id="answer-${answerIndex}" name="answers[]" class="form-control mb-1">
                    `;
                    $(`#answers-container`).append(newAnswerField);

                    ++answerIndex;
                }
                else
                {
                    alert('Maximum 8 answers per one question!');
                }
            });
        });
    </script>
@endsection