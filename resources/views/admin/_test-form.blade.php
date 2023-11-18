<div class="container" id="test-info">
    <label for="test-title">Test Title:</label>
    <input type="text" name="testTitle" id="test-title" class="form-control @error('testTitle') is-invalid @enderror" value="{{ isset($test) ? $test->title : old('testTitle') }}">
    @error('testTitle')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
    <br>
    
    <div id="questions-container">
        @if ($errors->has('questions') || $errors->has('answers') || $errors->has('isCorrect'))
            <div class="alert alert-danger mb-3">
                <ul>
                    @error('questions') <li>{{ $message }}</li> @enderror
                    @error('answers') <li>{{ $message }}</li> @enderror
                    @error('isCorrect') <li>{{ $message }}</li> @enderror
                </ul>
            </div>
        @endif

        @if (old('questions'))
            @foreach (old('questions') as $questionIndex => $question)
                @include('admin._question-body')
            @endforeach
        @elseif(isset($test))
            @foreach ($test->questions as $questionIndex => $question)
                @include('admin._question-body')
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