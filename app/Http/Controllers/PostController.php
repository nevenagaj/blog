<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;
use App\Tag;
use App\Category;
use Session;
use Purifier;

class PostController extends Controller
{
    public function __construct() {
        $this->middleware('admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //ovo je u sustini index za backend stranu
        //create variable and store all blog post
        //$posts = Post::all(); //elokvent all pokazuje sve postove
        $posts = Post::orderBy('id', 'desc')->paginate(5); //pokazuje samo 5 postova
        //return a view and pass in the above variable
        return view('posts.index')->withPosts($posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('posts.create')->withCategories($categories)->withTags($tags);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate the data
        $this->validate($request, array(
            'title'=> 'required|max:255',
            'slug'  => 'required|alpha_dash|min:5|max:255|unique:posts,slug',
            'category_id' => 'required|integer',
            'body'=>'required'
        )); //zahteva 2 parametra
            //prvi je request
            //drugi je array sa pravilima za validaciju. postoje bilt in pravila, 
            //a mozes i sam da ih pravis

        //store in the database
        $post = new Post;

        $post->title = $request->title;
        $post->slug = $request->slug;
        $post->category_id = $request->category_id;
        $post->body = Purifier::clean($request->body);

        $post->save();
        $post->tags()->sync($request->tags, false);
        Session::flash('success', 'The blog post was saved!');

        //redirect to another page
        return redirect()->route('posts.show', $post->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id); //find item Post by its id
        //var_dump($post);
        //die();
        //dd($post);
        //print_r($post);
        //die();
        return view('posts.show')->withPost($post);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //show a form with a data filled in the form
        //change data
        //submit to db

        //find post in db and save as var
        $post = Post::find($id);
        $categories = Category::all();
        $cats = [];
        foreach($categories as $category){
            $cats[$category->id] = $category->name;
        }

        /*$tags = Tag::all();
        $tags2 = [];
        foreach($tags as $tag){
            $tags2[$tag->id] = $tag->name;
        }*/
        $tag= Tag::pluck('name','id')->all();

        //returna view and pass in the var we previeosly created
        return view('posts.edit')->withPost($post)->withCategory($cats)->withTag($tag);
        

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
        // Validate the data
        $post = Post::find($id);

        if ($request->input('slug') == $post->slug) {
            $this->validate($request, array(
                'title'         => 'required|max:255',
                'category_id'   => 'required|integer',
                'body'          => 'required'
            ));
        } else {
        $this->validate($request, array(
                'title'         => 'required|max:255',
                'slug'          => 'required|alpha_dash|min:5|max:255|unique:posts,slug',
                'category_id'   => 'required|integer',
                'body'          => 'required'
            ));
        }
        // Save the data to the database
        $post = Post::find($id);

        $post->title = $request->input('title');
        $post->slug = $request->input('slug');
        $post->category_id = $request->input('category_id');
        $post->body = Purifier::clean($request->input('body'));

        $post->save();

        if(isset($request->tags)){
            $post->tags()->sync($request->tags);
        }else{
            $post->tags()->sync(array());
        }

        

        // set flash data with success message
        Session::flash('success', 'This post was successfully saved.');

        // redirect with flash data to posts.show
        return redirect()->route('posts.show', $post->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //find post to delete
        $post = Post::find($id);

        //sklanja veyu iymedju posta i taga tako da post moye da se obrise bez probleme
        $post->tags()->detach();

        //eloquent metod for delete
        $post->delete();

        Session::flash('success','Post was succesfuly deleted');
        //redirect to posts page
        return redirect()->route('posts.index');
    }
}
