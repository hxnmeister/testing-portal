@extends('admin.templates.index')
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
                <th>Test Title</th>
                <th style="width: 8vw">Controlls</th>
            </thead>
            <tbody>
                @foreach ($tests as $test)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td><a href="#">{{$test->title}}</a></td>
                        <td class="d-flex justify-content-between">
                            <a href="{{route('test.edit', ['test' => $test->id])}}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('test.destroy', $test->id) }}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection