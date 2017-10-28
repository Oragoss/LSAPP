@extends('layouts.app')

@section('content')
  <h1>Posts
    @if (!Auth::guest())
      <span style="margin-bottom: 2.5%; float:right;">
        <a class="btn btn-info" href="/posts/create">Create new post >></a>
      </span>
    @endif

  </h1>

  @if(count($posts) > 0)
    @foreach ($posts as $post)
      <div class="well">
        <h3><a href="/posts/{{$post->id}}">{{$post->title}}</a></h3>
        <small>Written on {{$post->created_at}} by {{$post->user->name}}</small>
      </div>
    @endforeach
    {{-- PAGINATION! --}}
    {{$posts->links()}}
  @else
    <p>No posts found</p>
  @endif
@endsection
