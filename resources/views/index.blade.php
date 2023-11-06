@extends('templates.index')
@section('content')
    <div class="container">
        <div class="d-flex justify-content-end">
            <a href="{{route('test.create')}}" class="btn btn-outline-success mb-5 mt-3">Create Test</a>
        </div>

        <table class="table table-bordered">
            <thead>
                <th>#</th>
                <th>name</th>
            </thead>
        </table>
    </div>
@endsection