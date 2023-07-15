<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use App\Http\helpers;
use App\Models\post_tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\EditPostRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CreatePostRequest;

class BlogController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();

        $posts3 = Post::all()->take(3);
        $posts4 = Post::all()->take(4);

        return view('home',[
            'posts' => $posts,
            'posts3' => $posts3,
            'posts4' => $posts4,
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function categories()
    {
        $post5 = Post::all()->take(5);

        return view('post.categories',[
            'post5' => $post5
        ]);
    }

    /**
     * Display a Contact
     */
    public function contact()
    {
        return view('contact');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create',Post::class);

        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePostRequest $request)
    {
        if(count(Tag::all()) == 0){
            return to_route('index')->with(['error' => 'Add Tag to Your Database']);
        }

        $data = $request->except(['_token']);
        
        $data['picture'] = request()->file('picture')->store('pictures');

        $post = Post::Create($data);

        DB::table('post_tag')->insert(['post_id' => $post->id,'tag_id' => $request->tag_id]);
        
        return to_route('index')->with(['success' => 'Post has been Created']);
    }

    public function yourPosts()
    {
        $posts = Post::where('user_id', Auth::user()->id)->get();

        return view('post.your-posts',[
            'posts' => $posts
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::findOrFail($id);
        $countComment = count(DB::table('comments')->where('commentable_id',$post->id)->get());

        return view('post.show',[
            'post' => $post,
            'countComment' => $countComment
        ]);
    }

    public function comment(Request $request)
    {
        $commet = $request->validate([
            'comment' => ['required']
        ]);
        $commet['user_id'] = Auth::user()->id;

        $post = Post::find($request->post_id)->comments()->create($commet);
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::find($id);
        $this->authorize('view',$post);

        return view('post.edit',[
            'post' => $post
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditPostRequest $request, string $id)
    {
        $post = Post::find($id);
        $this->authorize('update',$post);
        $data = $request->validated();

        if($request->has('picture')) {
            if(Storage::has($post->picture)){
                Storage::delete($post->picture);
            }
            $data['picture'] = request()->file('picture')->store('pictures');
        }else {
            unset($data['picture']);
        }

        $post->update($data);
        return to_route('post.show',$id)->with(['success' => 'Post has been Updated']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);
        $this->authorize('delete',$post);
        DB::table('post_tag')->where('post_id',$id)->delete();
        $post->delete();

        return back()->with(['success' => 'Your Post has been Deleted']);
    }
}
