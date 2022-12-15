@extends('layouts.app')

@section('content')
	<div class="card">
		<div class="card-body">
			<h2 class="card-title">{{$post->title}}</h2>
			<p class="card-text text-muted">Author: {{$post->user->name}}</p>
			<p class="card-text text-muted">Likes: {{count($post->likes)}}</p>
			<p class="card-subtitle text-muted mb-3">Created at: {{$post->created_at}}</p>
			<p class="card-text">{{$post->content}}</p>
			{{-- Check if the user is logged in --}}
			@if(Auth::user())
				{{-- Check if the post author is NOT the current user --}}
				@if(Auth::user()->id != $post->user_id)
					<form class="d-inline" method="POST" action="/posts/{{$post->id}}/like">
						@method('PUT')
						@csrf
						{{-- Check if the user has already liked the post --}}
						@if($post->likes->contains("user_id", Auth::user()->id))
							<button type="submit" class="btn btn-danger">Unlike</button>
						@else
							<button type="submit" class="btn btn-success">Like</button>
						@endif
					</form>
				@endif
				{{-- Modal Button --}}
				<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#commentModal">Post Comment</button>
			@endif

			<div class="mt-3">
				<a href="/posts" class="card-link">View all posts</a>
			</div>
		</div>
	</div>

	{{-- Comment section --}}
	@if(count($post->comments) > 0)
		<h4 class="mt-5">Comments:</h4>
		<div class="card">
			<ul class="list-group list-group-flush">
				@foreach($post->comments as $comment)
					<li class="list-group-item">
						<p class="text-center">{{$comment->content}}</p>
						<p class="text-end text-muted">posted by: {{$comment->user->name}}</p>
						<p class="text-end text-muted">posted on: {{$comment->created_at}}</p>
					</li>
				@endforeach
			</ul>
		</div>
	@endif

	<!-- Comment modal -->
	<div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="commentModalLabel">Post a Comment</h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">
	        <form method="POST" action="/posts/{{$post->id}}/comment">
	        	@csrf
	        	<div class="form-group">
	        		<label for="content">Content:</label>
	        		<textarea class="form-control" id="content" name="content" rows="3" required></textarea>
	        	</div>
	        	<div class="modal-footer">
	        		<button type="submit" class="btn btn-primary">Post Comment</button>	
	        	</div>
	        </form>
	      </div>
	    </div>
	  </div>
	</div>
@endsection
