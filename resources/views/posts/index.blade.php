@extends('layout')

@section('content')

@include('partials._search')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-6">Posts</h1>

    @can('create', App\Models\Post::class)
    <div class="mb-4">
        <a href="{{ route('posts.create') }}"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Create Post</a>
    </div>
    @endcan

    @foreach ($posts as $post)
    <div class="bg-white shadow-md rounded-lg p-6 mb-4">
        <h2 class="text-2xl font-semibold mb-2">
            <a href="{{ route('posts.show', $post) }}" class="text-blue-500 hover:text-blue-700">{{ $post->title }}</a>
        </h2>
        <p class="text-gray-700 mb-4">{{ $post->content }}</p>
        <p class="text-gray-600 mb-2">Category: <span class="font-medium">{{ $post->category->name }}</span></p>
        <p class="text-gray-600 mb-2">Author: <span class="font-medium">{{ $post->user->name }}</span></p>
        <p class="text-gray-600 mb-4">Status: <span class="font-medium">{{ $post->status }}</span></p>
        <div class="flex space-x-4">
            @can('update', $post)
            <a href="{{ route('posts.edit', $post) }}" class="text-blue-500 hover:text-blue-700">Edit</a>
            @endcan
            @can('delete', $post)
            <form action="{{ route('posts.deleteRequest', $post) }}" method="POST" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
            </form>
            @endcan
        </div>
    </div>
    @endforeach
</div>
@endsection