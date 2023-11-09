@extends('templates.index')
@section('title', 'Creating Test')
@section('content')
    <div class="container mt-3">
        <form action="{{ route('test.store') }}" method="post">
            @csrf

            <label for="test-title" class="mt-3">Test Title:</label>
            <input type="text" name="test" id="test-title" value="{{ old('test') }}" class="form-control @error('test') is-invalid @enderror">
            @error('test')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

            @error('questions')
                <div class="alert alert-danger mt-5">
                    {{ $message }}
                </div>
            @enderror
            <label for="question-text" class="mt-3">Question #1:</label>
            <textarea name="questions[]" id="question-text" cols="10" rows="3"class="form-control @error('question') is-invalid @enderror">{{ old('question') }}</textarea>

            @error('answers')
                <div class="alert alert-danger mt-5">
                    {{ $message }}
                </div>
            @enderror

            <div class="accordion mt-3">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="false" aria-controls="panelsStayOpen-collapseOne">
                            Answers To Question #1
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse @error('answers.*') show @enderror">
                        <div class="accordion-body">
                            <div class="answers-container">
                                @if (old('answers'))
                                    @foreach (old('answers') as $answer)
                                        <div class="answer-field">
                                            <label for="answer-{{ $loop->iteration }}" class="mt-3">Answer{{ $loop->iteration }}:</label>
                                            <input type="text" id="answer-{{ $loop->iteration }}" value="{{ $answer }}" name="answers[]" class="form-control mb-1 @error('answers.' . $loop->iteration - 1) is-invalid @enderror')">

                                            @error('answers.' . $loop->iteration - 1)
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    @endforeach
                                @else
                                    <div class="answer-field">
                                        <label for="answer-1" class="mt-3">Answer 1:</label>
                                        <input type="text" id="answer-1" name="answers[]" class="form-control mb-1">
                                    </div>
                                @endif
                            </div>
                            <div class="mt-2">
                                <button type="button" class="btn btn-outline-info add-answer">Add Answer</button>
                                <button type="button" class="btn btn-outline-danger delete-answer">Delete Answer</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <div class="mt-2">
                    <button id="add-question" type="button" class="btn btn-outline-infor">Add Question</button>
                    <button id="delete-question" type="button" class="btn btn-outline-danger">Delete Question</button>
                </div>
                <button type="submit" class="btn btn-outline-success">Save Test</button>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            const numberToString = ['Zero', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight'];
            const maxAnswers = 8;

            let answersContainer = $(this).find('.answers-container');
            let answerCount = answersContainer.find('input[name^="answers[]"]').length;

            $(document).on('click', '.delete-answer', () => {
                if (answerCount > 1) {
                    answersContainer.find('.answer-field').last().remove();
                    --answerCount;
                } else {
                    alert('Cannot remove last question!');
                }
            });

            $(document).on('click', '.add-answer', () => {
                if (answerCount <= maxAnswers) {
                    ++answerCount;

                    let newAnswerField =
                        `
                    <div class="answer-field">
                        <label for="answer-${answerCount}" class="mt-3">Answer ${answerCount}:</label>
                        <input type="text" id="answer-${answerCount}" name="answers[]" class="form-control mb-1">
                    </div>
                    `;

                    answersContainer.append(newAnswerField);
                } else {
                    alert('Maximum 8 answers per one question!');
                }
            });
        });
    </script>
@endsection
