@extends('admin.templates.index')
@section('title', 'Creating Test')
@section('content')
    <form action="{{route('test.update', ['test' => $test->id])}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')
        
        @include('admin._test-form')
    </form>

    <script src="{{ asset('js/script.js') }}"></script>
@endsection