<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\PostLike;
use App\Models\PostComment;

class PostController extends Controller
{
    //

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        //check if the user is logged in
        if(Auth::user()){
            //create a new Post object from the post model
            $post = new Post;

            //define the properties of the $post object using the received form data
            $post->title = $request->input('title');
            $post->content = $request->input('content');
            //get the id of the authenticated user and set it as the user_id foreign key
            $post->user_id = Auth::user()->id;
            //save the $post object to the database
            $post->save();

            return redirect('/posts');
        }else{
            //redirect the user to the login page if not logged in
            return redirect('/login');
        }
    }

    public function index()
    {
        //get all posts from the database
        $posts = Post::where('isActive', true)->get();
        return view('posts.index')->with('posts', $posts);
    }

    public function welcome()
    {
        $posts = Post::inRandomOrder()
                ->limit(3)
                ->get();
        return view('welcome')->with('posts', $posts); 
    }

    public function myPosts()
    {
        if(Auth::user()){
            $posts = Auth::user()->posts;

            return view('posts.index')->with('posts', $posts);
        }else{
            return redirect('/login');
        }       
    }

    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show')->with('post', $post);
    }

    public function edit($id)
    {
        if(Auth::user()){
            $post = Post::find($id);

            return view('posts.edit')->with('post', $post);
        }else{
            return redirect('/login');
        }          
    }

    public function update(Request $request, $id)
    {
        $post = Post::find($id);

        //check if the user who sent the request is the author of the post
        if(Auth::user()->id == $post->user_id){
            $post->title = $request->input('title');
            $post->content = $request->input('content');
            $post->save();
        }

        return redirect('/posts');
    }

    public function destroy($id)
    {
        $post = Post::find($id);

        if(Auth::user()->id == $post->user_id){
            $post->delete();
        }

        return redirect('/posts');
    }

    public function archive($id)
    {
        $post = Post::find($id);

        if(Auth::user()->id == $post->user_id){
            $post->isActive = false;
            $post->save();
        }

        return redirect('/posts');        
    }

    public function like($id)
    {
        $post = Post::find($id);
        $user_id = Auth::user()->id;

        //if authenticated user is not the post author
        if($post->user_id != $user_id){
            //check if a post like for this post has been made by this user before
            if($post->likes->contains("user_id", $user_id)){
                //delete the like made by this user to unlike this post
                PostLike::where('post_id', $post->id)->where('user_id', $user_id)->delete();
            }else{
                $postLike = new PostLike;

                $postLike->post_id = $post->id;
                $postLike->user_id = $user_id;

                $postLike->save();
            }
        }

        return redirect("/posts/$id");
    }

    public function comment(Request $request,$id)
    {
        $post = Post::find($id);
        $user = Auth::user();

        if($user){
            $postComment = new PostComment;
            $postComment->post_id = $post->id;
            $postComment->user_id = $user->id;
            $postComment->content = $request->input('content');
            $postComment->save();
        }

        return redirect("/posts/$id");
    }
}
