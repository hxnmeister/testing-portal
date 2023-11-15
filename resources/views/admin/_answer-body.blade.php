<div class="answer mt-2">
    <label>Answer #{{$loop->iteration}}</label>
    <input type="text" name="answers[{{$questionIndex}}][]" class="form-control @error('answers.'.$questionIndex.'.'.$answerIndex) is-invalid @enderror" value="@if(old('answers.'.$questionIndex.'.'.$answerIndex)) {{old('answers.'.$questionIndex.'.'.$answerIndex)}} @elseif(isset($test) && is_object($answer)) {{$answer->text}} @endif">

    {{-- @dd($answer) --}}
    <input type="checkbox" name="isCorrect[{{$questionIndex}}][]" value="{{$answerIndex}}" @if(old('isCorrect.'.$questionIndex) && in_array($answerIndex, old('isCorrect.'.$questionIndex)) || isset($test) && is_object($answer) && $answer->is_correct == true) checked @endif>
    <label>Is Correct?</label>

    @error('answers.'.$questionIndex.'.'.$answerIndex)
        <div class="invalid-feedback">
            {{$message}}
        </div>
    @enderror
</div>