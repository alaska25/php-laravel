@extends('layouts.app')
@section('content')
	<div class="card">
		<div class="card-body">
			<h2 class="card-title">{{$post->title}}</h2>
			<p class="card-text text-muted">Author: {{$post->user->name}}</p>
			<p class="card-text text-muted">Likes: {{$post->likes}}</p>
			<p class="card-subtitle text-muted mb-3">Created at: {{$post->created_at}}</p>
			<p class="card-text">{{$post->content}}</p>
			@if(Auth::user())
				@if(Auth::user()->id != $post->user_id)
					<form class="d-inline" method="POST" action="/posts/{{$post->id}}/like">
						@method('PUT')
						@csrf
						@if($post->likes->contains("user_id", Auth::user()->id))
							<button type="submit" class="btn btn-danger">Unlike</button>
						@else
							<button type="submit" class="btn btn-success">Like</button>
						@endif
					</form>
				@endif
			@endif
			<div class="mt-3">
				<a href="/posts" class="card-link">View all posts</a>
			</div>
		</div>
	</div>
@endsection
