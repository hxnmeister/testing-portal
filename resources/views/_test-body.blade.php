@foreach ($currentTest->questions as $qIndex => $question)
    <label for="question-{{$qIndex}}">{{$question->text}} ({{$question->points}} points)</label>
    <br>
    @if ($question->answers->where('is_correct', true)->count() > 1) 
        <b><u>Question with few answers</u></b>
        <br>
    @endif
                
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