@extends('templates.index')
@section('content')
    <div class="container">
        <div class="d-flex justify-content-end">
            <a href="{{route('test.create')}}" class="btn btn-outline-success mb-5 mt-3">Create Test</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success mt-5">
                {{session('success')}}
            </div>
        @endif
        <table class="table table-bordered">
            <thead>
                <th>#</th>
                <th>name</th>
            </thead>
        </table>
    </div>
@endsection