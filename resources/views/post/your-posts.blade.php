@extends('partials.index')


@section('content')

<h1 class="your-posts-h1">Yout Posts</h1>

@if(session('success'))
        <h4>{{session('success')}}</h4>
@endif

<table id="customers">
  <tr>
    <th>Title</th>
    <th>Tags</th>
    <th>Action</th>
  </tr>
  @foreach($posts as $post)
    <tr>
          
          <td>{{ $post->title }}</td>
          <td>{{ $post->tag()->get()[0]->tag }}</td>
          <td>
              <a href="{{ route('post.show',$post->id) }}">View</a>
              <a href="{{ route('post.edit',$post->id) }}">Edit</a>
              <form action="{{ route('post.destroy',$post->id) }}" method="post">
                  @csrf
                  @method('DELETE')
                  <input type="submit" value="Delete">
              </form>
          </td>

    </tr>
  @endforeach

</table>

@endsection