<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\PostLike;

class PostController extends Controller
{
    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        if(Auth::user()){
            $post = new Post;
            $post->title = $request->input('title');
            $post->content = $request->input('content');
            $post->user_id = Auth::user()->id;
            $post->save();

            return redirect('/posts');
        }else{
            return redirect('/login');
        }
    }

    public function index()
    {
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
        if($post->user_id != $user_id){
            if($post->likes->contains("user_id", $user_id)){
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
}
