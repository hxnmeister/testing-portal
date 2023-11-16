@extends('admin.templates.index')
@section('title', 'Creating Test')
@section('content')
    <form action="{{route('test.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        @include('admin._test-form')
    </form>

    <script src="{{ asset('js/script.js') }}"></script>
@endsection