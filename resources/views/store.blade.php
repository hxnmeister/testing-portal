@foreach ($newQuestion as $item)
    <p>Question Title #{{$loop->iteration}}: {{$item}}</p>
@endforeach

<br>
<br>

{{dd($newAnswer)}}
@foreach ($newAnswer as $item)
    
@endforeach