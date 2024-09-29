@extends('layout')
@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-6">My Posts</h1>

    @if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    <table class="table-auto w-full">
        <thead>
            <tr>
                <th class="px-4 py-2">Title</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($posts as $post)
            <tr>
                <td class="border px-4 py-2">{{ $post->title }}</td>
                <td class="border px-4 py-2">{{ $post->status }}</td>
                <td class="border px-4 py-2">
                    <a href="{{ route('posts.edit', $post) }}"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</a>
                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
