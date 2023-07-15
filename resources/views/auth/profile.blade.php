@extends('partials.index')


@section('content')

    @if(session('success'))
        <h4>{{ session('success') }}</h4>
    @endif

    <h1 class="profile-h1">Your Profile</h1>

    <div class="profile-data">

        <p class="profile-data-title">Name</p>
        <p class="profile-data-data">{{ Auth::user()->name }}</p>
        <p class="profile-data-title">Email</p>
        <p class="profile-data-data">{{ Auth::user()->email }}</p>
        <p class="profile-data-title">Created: </p>
        <p class="profile-data-data">{{ Auth::user()->created_at }}</p>

    </div>

    <form action="{{ route('auth.changePassword') }}" method="POST" class="profile-change-password">

        @csrf

        <label for="">Old</label>
        <input type="password" name="old">

        @error('old')
            <p class="error">{{ $message }}</p>
        @enderror

        <label for="">New Password</label>
        <input type="password" name="password">

        @error('password')
            <p class="error">{{ $message }}</p>
        @enderror

        <label for="">Password Confirmation</label>
        <input type="password" name="password_confirmation">

        @error('password_confirmation')
            <p class="error">{{ $message }}</p>
        @enderror

        <input type="submit" value="Change">

    </form>

    <div class="profile-picture">

        <img src="{{ Storage::Url( Auth::user()->picture ) }}" class="profile-picture-img">

        <form action="{{ route('auth.picture') }}" method="post" class="profile-picture-form" enctype="multipart/form-data">
            @csrf

            <label>Change Picture</label>

            @error('picture')
                <p class="error">{{ $message }}</p>
            @enderror

            <input type="file" name="picture">
            <input type="submit" value="Change" class="profile-picture-form-submit">

        </form>

    </div>


@endsection