@extends('layout')

@section('content')
<div class="container mx-auto p-4">
    <div class="bg-white shadow-md rounded-lg p-6 mb-4">
        <h1 class="text-3xl font-bold mb-4">{{ $post->title }}</h1>
        <p class="text-gray-700 mb-4">{{ $post->content }}</p>
        <p class="text-gray-600 mb-2">Category: <span class="font-medium">{{ $post->category->name }}</span></p>
        <p class="text-gray-600 mb-4">Status: <span class="font-medium">{{ $post->status }}</span></p>
        <div class="flex space-x-4">
            @can('edit posts')
            <a href="{{ route('posts.edit', $post) }}" class="text-blue-500 hover:text-blue-700">Edit</a>
            @endcan
            @can('delete posts')
            <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
            </form>
            @endcan
        </div>
    </div>
</div>
@endsection