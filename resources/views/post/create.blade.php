@extends('partials.index')

@section('content')

        <form action="{{ route('post.store') }}" method="post" class="create-post" enctype="multipart/form-data">
            @csrf

            <label for="">Title</label>
            <input type="text" name="title" id="" class="create-post-inputs" value="{{ old('title') }}">

            @error('title')
                <p class="error">{{$message}}</p>
            @enderror

            <label for="">Description</label>
            <textarea name="description" cols="30" rows="10" class="create-post-description" value="{{ old('description') }}"></textarea>

            @error('description')
                <p class="error">{{$message}}</p>
            @enderror

            <select name="tag_id" class="create-post-inputs">
                <option value="1">Tech</option>
                <option value="2">Info</option>
            </select>

            @error('tag_id')
                <p class="error">{{$message}}</p>
            @enderror

            <label for="">Picture</label>
            <input type="file" name="picture" id="" class="create-post-inputs">

            @error('description')
               <p class="error">{{$message}}</p>
            @enderror


            <input type="submit" value="Create" class="create-post-submit">
        </form>

@endsection