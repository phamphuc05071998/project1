<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\TempPost;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    public function index(Request $request)
    {
        // Apply filters if any
        $posts = Post::filter($request->all())->where('status', 'approved')->latest()->get();

        return view('posts.index', compact('posts'));
    }

    public function authorPosts()
    {
        $tempPosts = TempPost::all();
        $posts = Post::where('user_id', auth()->id())->get();
        return view('posts.author', compact('posts', 'tempPosts'));
    }

    public function approveRequest()
    {
        $this->authorize('approve', Post::class);

        $posts = Post::where('status', 'pending')->get();
        $tempPosts = TempPost::where('status', 'waiting_for_approval')->get();
        $tempDeletePosts = TempPost::where('status', 'waiting_for_deletion')->get();
        return view('posts.approveRequest', compact('posts', 'tempPosts', 'tempDeletePosts'));
    }

    public function show(Post $post)
    {
        $categories = Category::all();
        return view('posts.show', compact('post', 'categories'));
    }

    public function create()
    {
        $this->authorize('create', Post::class);

        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Post::class);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post = new Post();
        $post->title = $request->title;
        $post->content = $request->content;
        $post->category_id = 1; // Default category
        $post->status = 'pending'; // Default status
        $post->user_id = auth()->id();
        $post->save();

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $tempPost = new TempPost();
        $tempPost->post_id = $post->id;
        $tempPost->title = $request->title;
        $tempPost->content = $request->content;
        $tempPost->category_id = $post->category_id;
        $tempPost->user_id = auth()->id();
        $tempPost->status = 'waiting_for_approval';
        $tempPost->save();

        return redirect()->route('posts.index')->with('success', 'Post update submitted for approval.');
    }

    public function approve(Post $post)
    {
        $this->authorize('approve', Post::class);

        $post->status = 'approved';
        $post->save();

        return redirect()->route('posts.index')->with('success', 'Post approved successfully.');
    }

    public function assignCategory(Request $request, Post $post)
    {
        $this->authorize('assignCategory', Post::class);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
        ]);

        $post->category_id = $request->category_id;
        $post->save();

        return redirect()->route('posts.index')->with('success', 'Post category updated successfully.');
    }

    public function changeStatus(Request $request, Post $post)
    {
        $this->authorize('changeStatus', Post::class);

        $request->validate([
            'status' => 'required|in:pending,approved',
        ]);

        $post->status = $request->status;
        $post->save();

        return redirect()->route('posts.index')->with('success', 'Post status updated successfully.');
    }

    public function changeCategory(Request $request, Post $post)
    {
        $this->authorize('assignCategory', Post::class);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
        ]);

        $post->category_id = $request->category_id;
        $post->save();

        return redirect()->route('posts.index')->with('success', 'Post category updated successfully.');
    }

    public function approveTempPost(TempPost $tempPost)
    {
        $this->authorize('approve', Post::class);

        $post = $tempPost->post;
        $post->title = $tempPost->title;
        $post->content = $tempPost->content;
        $post->category_id = $tempPost->category_id;
        $post->save();

        $tempPost->delete();

        return redirect()->route('posts.approveRequest')->with('success', 'Post update approved successfully.');
    }

    public function deleteRequest(Post $post)
    {
        $this->authorize('delete', $post);

        $tempPost = new TempPost();
        $tempPost->post_id = $post->id;
        $tempPost->title = $post->title;
        $tempPost->content = $post->content;
        $tempPost->category_id = $post->category_id;
        $tempPost->user_id = auth()->id();
        $tempPost->status = 'waiting_for_deletion';
        $tempPost->save();

        return redirect()->route('posts.index')->with('success', 'Post delete request submitted for approval.');
    }

    public function confirmDelete(TempPost $tempPost)
    {
        $this->authorize('approve', Post::class);

        $post = $tempPost->post;
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }

    public function rejectDelete(TempPost $tempPost)
    {
        $this->authorize('approve', Post::class);

        $tempPost->delete();

        return redirect()->route('posts.index')->with('success', 'Post delete request rejected.');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }

    public function rejectTempPost(TempPost $tempPost)
    {
        $this->authorize('approve', Post::class);

        $tempPost->delete();

        return redirect()->route('posts.approveRequest')->with('success', 'Post update rejected successfully.');
    }
}