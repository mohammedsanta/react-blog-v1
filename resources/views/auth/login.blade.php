@extends('partials.index')


@section('content')

    <div class="box">

        <form action="{{ route('auth.login') }}" method="post">
            @csrf

            @if(session('success'))
                <h4>{{session('success')}}</h4>
            @endif

            <label for="">Name</label>
            <input type="text" name="name" id="">

            @error('name')
                {{$message}}
            @enderror

            <label for="">Password</label>
            <input type="password" name="password" id="">

            @error('password')
                {{$message}}
            @enderror

            <input type="submit" value="Login">
        </form>

    </div>

@endsection