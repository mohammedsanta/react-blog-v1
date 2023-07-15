@extends('partials.index');


@section('content')

    <div class="box">

        <form action="{{ route('auth.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <label for="">Name</label>
            <input type="text" name="name" id="">

            @error('name')
                {{$message}}
            @enderror

            <label for="">Email</label>
            <input type="text" name="email" id="">

            @error('email')
                {{$message}}
            @enderror

            <label for="">Password</label>
            <input type="password" name="password" id="">

            @error('password')
                {{$message}}
            @enderror

            <label for="">Picture</label>
            <input type="file" name="picture" id="">

            @error('picture')
                {{$message}}
            @enderror

            <input type="submit" value="Login">
        </form>

    </div>

@endsection