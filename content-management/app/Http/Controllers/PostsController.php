<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\Posts\CreatePostRequest;
use App\Http\Requests\Posts\UpdatePostRequest;
use App\Post;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){

        $this->middleware('verifyCategoriesCount')
            ->only(['create','store']);

    }

    public function index()
    {
        //

        return view('posts.index')->with('posts',Post::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        return view('posts.create')
            ->with('categories',Category::all())->with('tags',Tag::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostRequest $request)
    {

        //upload image
        $image=$request->image->store('posts');
        //create post

       $post = Post::create([
            'title'=>$request->title,
            'description'=>$request->description,
            'content'=>$request->content,
            'image'=>$image,
            'published_at'=>$request->published_at,
            'category_id'=>$request->category
        ]);

       if($request->tags){
           $post->tags()->attach($request->tags);
       }

        //flash message

        session()->flash('success','Post created successfully');

        //redirect
        return redirect(route('posts.index'));


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
        return view('posts.create')
            ->with('post',$post)
            ->with('categories',Category::all())
            ->with('tags',Tag::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request,Post $post)
    {


        $data=$request->only(['title','descripton','published_at','content']);

        //check for new image
        if($request->hasFile('image')) {
            //update image
            $image= $request->image->store('posts');
            //delete old image

            $post->deleteImage();

            $data['image']=$image;
        }

        //check if tags are attached to the post, if there are
        //any that are not, it will attach them

        if($request->tags){
            $post->tags()->sync($request->tags);
        }
        //update attributes
        $post->category_id=$request->category;
        $post->update($data);


        //flash message

        session()->flash('success','Post Update Successfully');

        //redirect
        return redirect(route('posts.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $post=Post::withTrashed()->where('id',$id)->firstOrFail();

        if($post->trashed()){
            $post->forceDelete();

            $post->deleteImage();

            session()->flash('success','Post Deleted Successfully');
        }else{
            $post->delete();
            session()->flash('success','Post Trashed Successfully');
        }


        return redirect(route('posts.index'));

    }
    //Display a list of all trashed posts
    public function trashed(){

        $trashed=Post::onlyTrashed()->get();

        return view('posts.index')->withPosts($trashed);
    }

    //restore post

    public function restore($id){

        $post=Post::withTrashed()->where('id',$id)->firstOrFail();

        $post->restore();

        session()->flash('success','Post Restored Successfully');

        return redirect()->back();
    }
}
