<?php

namespace App\Http\Controllers;

use App\Mail\ExampleMail;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        foreach ($posts as $post) {
            $post->body = substr($post->body, 0, 100) . '...';
        }
        return view('posts', compact('posts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:5|max:255|string',
            'body' => 'required|min:10|max:5000|string',
        ]);

        $post = new Post();
        $post->title = $request->title;
        $post->body = $request->body;
        $post->user_id = $request->user_id;
        $post->user()->associate(Auth::user());
        $post->save();

        $mailData = $request->only('title', 'body');

        Mail::to(Auth::user()->email)->send(new ExampleMail($mailData));

        return redirect('createpost')->with('status', 'Post successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('post', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        $post->delete();

        $mailData = [
            'title' => "Post #". $id ." has been deleted",
            'body' => "Dear User ".Auth::user()->name. "
            Post #". $id ." has been deleted"
        ];
        
        Mail::to(Auth::user()->email)->send(new ExampleMail($mailData));
        return redirect('myposts')->with('status', 'Post deleted sucessfuly');
    }

    public function myposts()
    {
        $posts = Post::where('user_id', Auth::user()->id)->get();
        foreach ($posts as $post) {
            $post->body = substr($post->body, 0, 100) . '...';
        }
        return view('myposts', compact('posts'));
    }
}
