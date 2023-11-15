@extends('layouts.app')
@section('title', 'Home Page')
@section('leftNavBar')
    @auth
    <div class="dropdown">
        <button class="btn btn-info dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            Results
        </button>
        <ul class="dropdown-menu dropdown-menu-dark">
            @if (count(Auth::user()->results) > 0)
                @foreach (Auth::user()->results as $result)
                    <li><a href="#" class="dropdown-item">Test #{{$loop->iteration}}: {{$result->score}} pts</a></li>
                @endforeach
            @else
                <li><a href="#" class="dropdown-item">No completed tests yet!</a></li>
            @endif
        </ul>
    </div>
    @endauth
@endsection
@section('content')
    <div class="container mt-5">
        <h1>Available Tests</h1>

        @error('invalid_user')
            <div class="alert alert-danger">
                {{$message}}
            </div>
        @enderror
        @if (session('summary'))
            <div class="alert alert-success">
                {{ session('summary') }}
            </div>
        @endif

        <table class="table table-bordered">
            <thead>
                <th>#</th>
                <th>Title</th>
            </thead>
            <tbody>
                @foreach ($tests as $slug => $title)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td><a href="{{route('showTest', ['slug' => $slug])}}" class="link-body-emphasis link-offset-3 link-offset-1-hover link-underline link-underline-opacity-50 link-underline-opacity-100-hover">{{$title}}</a></td>
                        </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection