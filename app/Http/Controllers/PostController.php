<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:author')->only(['create', 'store']);
        $this->middleware('role:editor|admin')->only(['approve', 'changeStatus', 'changeCategory']);
    }

    public function index()
    {
        $posts = Post::where('status', 'approved')->get();
        return view('posts.index', compact('posts'));
    }

    public function approved()
    {
        $posts = Post::where('status', 'approved')->get();
        return view('posts.approved', compact('posts'));
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post = new Post();
        $post->title = $request->title;
        $post->content = $request->content;
        $post->category_id = 1; // Default category
        $post->status = 'draft'; // Default status
        $post->user_id = auth()->id();
        $post->save();

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    public function approve(Post $post)
    {
        $post->status = 'approved';
        $post->save();

        return redirect()->route('posts.index')->with('success', 'Post approved successfully.');
    }

    public function changeStatus(Request $request, Post $post)
    {
        $request->validate([
            'status' => 'required|in:draft,published,approved',
        ]);

        $post->status = $request->status;
        $post->save();

        return redirect()->route('posts.index')->with('success', 'Post status updated successfully.');
    }

    public function changeCategory(Request $request, Post $post)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
        ]);

        $post->category_id = $request->category_id;
        $post->save();

        return redirect()->route('posts.index')->with('success', 'Post category updated successfully.');
    }
}