@extends('layouts.app')

@section('content')
    <div class="text-center">
        <img class="w-50" src="https://laravelnews.imgix.net/images/laravel-featured.png">
        <h2>Featured Posts:</h2>
        @if(count($posts) > 0)
            @foreach($posts as $post)
                <div class="card text-center">
                    <div class="card-body">
                        <h4 class="card-title mb-3"><a href="/posts/{{$post->id}}">{{$post->title}}</a></h4>
                        <h6 class="card-text mb-3">Author: {{$post->user->name}}</h6>
                    </div>
                </div>
            @endforeach
        @endif        
    </div>
@endsection
