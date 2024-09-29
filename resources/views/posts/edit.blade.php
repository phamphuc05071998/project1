@extends('layout')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-6">Edit Post</h1>

    @if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('posts.update', $post) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="title" class="block text-gray-700 font-bold mb-2">Title:</label>
            <input type="text" name="title" id="title"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                value="{{ old('title', $post->title) }}">
        </div>
        <div class="mb-4">
            <label for="content" class="block text-gray-700 font-bold mb-2">Content:</label>
            <textarea name="content" id="content" rows="5"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('content', $post->content) }}</textarea>
        </div>
        <div class="flex items-center justify-between">
            <button type="submit"
           
     class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Submit
                for Approval</button>
        </div>
    </form>
</div>
@endsection