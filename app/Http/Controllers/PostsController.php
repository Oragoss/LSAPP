<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use DB;

class PostsController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $exceptions = [
      'except' => [
        'index', 'show'
      ]
    ];
    $this->middleware('auth', $exceptions);
  }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      #This is equivilant to SELECT * FROM posts;
      // $posts = Post::all();

      #Use DB instead of Eloquent
      // $posts = DB::select("SELECT * FROM posts");

      #Show an individual row
      // $post = Post::where('title', 'Post Two')->get();

      #Limit number of rows returned
      // $posts = Post::orderBy('title', 'desc')->take(1)->get();

      #Grab all and order from oldest to newest
      // $posts = Post::orderBy('title', 'desc')->get();

      #Grab all and order from newest to oldest
      // $posts = Post::orderBy('title', 'desc')->get();

      #Pagination! This still does and orderBy, but after it hits the parameter, it will start to paginate the results!
      $posts = Post::orderBy('created_at', 'desc')->paginate(10); //Paginate by 1 (or whatever number is used as a parameter)
      return view('posts.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->validate($request, [
        'title' => 'required',
        'body' => 'required',
      ]);

      // Create Post
      $post = new Post;
      $post->title = $request->input('title');  //Insert the title into the db
      $post->body = $request->input('body');
      $post->user_id = auth()->user()->id;  //grab the user id from the user table
      $post->save();

      return redirect('/posts')->with('success', 'Post Created');
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
      return view('posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $post = Post::find($id);

      //Check for correct user
      if(auth()->user()->id !== $post->user_id) {
        return redirect('/posts')->with('error', 'Unauthorized Page');
      }

      return view('posts.edit')->with('post', $post);
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
      $this->validate($request, [
        'title' => 'required',
        'body' => 'required',
      ]);

      // Create Post
      $post = Post::find($id);

      //Check for correct user
      if(auth()->user()->id !== $post->user_id) {
        return redirect('/posts')->with('error', 'Unauthorized Page');
      }

      $post->title = $request->input('title');  //Insert the title into the db
      $post->body = $request->input('body');
      $post->save();

      return redirect('/posts')->with('success', 'Post Edited');
    }

    /**
     * Remove the specified resource from storage.
     * This should REALLY be an archive function....
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $post = Post::find($id);

      //Check for correct user
      if(auth()->user()->id !== $post->user_id) {
        return redirect('/posts')->with('error', 'Unauthorized Page');
      }

      $post->delete();
      return redirect('/posts')->with('success', 'Post Removed');
    }
}
