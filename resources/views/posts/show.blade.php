@extends('layout')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-6">{{ $post->title }}</h1>
    <p>{{ $post->content }}</p>

    <!-- Category Assignment Form -->
    @can('assignCategory', $post)
    <div class="mt-6">
        <h2 class="text-2xl font-bold mb-4">Assign Category</h2>
        <form action="{{ route('posts.assignCategory', $post) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="category_id" class="block text-gray-700 text-sm font-bold mb-2">Category:</label>
                <select name="category_id" id="category_id"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ $post->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Assign Category
            </button>
        </form>
    </div>
    @endcan
</div>

@endsection