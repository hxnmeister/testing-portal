@extends('templates.index')
@section('title', 'Creating Test')
@section('content')
    <form action="{{route('test.store')}}" method="post">
        @csrf
        
        <div class="container" id="test-info">
            <label for="test-title">Test Title:</label>
            <input type="text" name="title" id="test-title" class="form-control">

            <div id="questions-container">
                @error('questions')
                    <div class="alert alert-danger mt-5">
                        {{$message}}
                    </div>
                @enderror

                @if (old('questions'))
                    @foreach (old('questions') as $question)
                        <div class="accordion mt-3">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse{{$loop->iteration}}" aria-expanded="false" aria-controls="panelsStayOpen-collapse{{$loop->iteration}}">
                                        Question #{{$loop->iteration}}
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapse{{$loop->iteration}}" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                    <input type="text" name="questions[]" class="form-control">
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