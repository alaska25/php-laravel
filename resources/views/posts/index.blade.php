@extends('layouts.app')

@section('content')
	{{-- check if there are any active posts --}}
	@if(count($posts) > 0)
		@foreach($posts as $post)
			<div class="card text-center">
				<div class="card-body">
					<h4 class="card-title mb-3"><a href="/posts/{{$post->id}}">{{$post->title}}</a></h4>
					<h6 class="card-text mb-3">Author: {{$post->user->name}}</h6>
					<p class="card-subtitle mb-3 text-muted">Created at: {{$post->created_at}}</p>
				</div>
				{{-- check if the current user is logged in --}}
				@if(Auth::user())
					{{-- check if the authenticated user is the owner of the post  --}}
					@if(Auth::user()->id == $post->user_id)
						<div class="card-footer">
							<form>
							<form method="POST" action="/posts/{{$post->id}}">
								@method('DELETE')
								@csrf
								<a href="/posts/{{$post->id}}/edit" class="btn btn-primary">Edit Post</a>
								<button type="submit" class="btn btn-danger">Delete Post</button>
							</form>			
