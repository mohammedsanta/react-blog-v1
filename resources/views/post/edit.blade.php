@extends('partials.index')

@section('content')

        <form action="{{ route('post.update',$post->id) }}" method="post" class="create-post" enctype="multipart/form-data">
            @method('PATCH')
            @csrf

            <label for="">Title</label>
            <input type="text" name="title" id="" class="create-post-inputs" value="{{ $post->title }}">

            @error('title')
                <p class="error">{{$message}}</p>
            @enderror

            <label for="">Description</label>
            <textarea name="description" cols="30" rows="10" class="create-post-description">{{ $post->description }}</textarea>

            @error('description')
                <p class="error">{{$message}}</p>
            @enderror

            <select name="tag" class="create-post-inputs">
                <option value="tech">Tech</option>
                <option value="info">Info</option>
            </select>

            @error('tag')
                <p class="error">{{$message}}</p>
            @enderror

            <img src="{{ Storage::Url($post->picture) }}" width="100px">

            <label for="">Picture</label>
            <input type="file" name="picture" id="" class="create-post-inputs">

            @error('description')
               <p class="error">{{$message}}</p>
            @enderror


            <input type="submit" value="Update" class="create-post-submit">
        </form>

@endsection