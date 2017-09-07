<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostForm;
use Rimorsoft\Http\Requests\PostRequest;

use App\Post;

class PostController extends Controller
{
    //
    public function create()
	{
	return view("posts.create");
	}

/*
public function store3(PostForm $postForm)
{
	$post = new \App\Post;
 
	$post->title = \Request::input('title');
 
	$post->body = \Request::input('body');
 
	$post->save();
 
	return redirect('post/create')->with('message', 'Post saved');
}
*/
public function index()
    {
        //show data
        $posts =  post::all();
        return view('post.index',['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return IlluminateHttpResponse
     */
    public function store(Request $request)
    {
       // validation
      $this->validate($request,[
      'title'=> 'required',
      'text' => 'required',
    ]);
      // create new data
    $post = new post;
    $post->title = $request->title;
    $post->text = $request->text;
    $post->author_id=1;
    $post->save();
    //return view('post/',compact('post'));
    return redirect()->route('post.index')->with('alert-success','Data Hasbeen Saved!');
    //return redirect()->route('post.index');


    }
    public function listView(Request $request){
      $posts= Post::all();
      return view('post_list',['posts'=>$posts
        ]);
    }
     public function post_add(Request $request){
      $posts= Post::all();
      return view('post.post_add',['posts'=>$posts
        ]);
    }
    public function create

}
