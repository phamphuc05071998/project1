@extends('layout')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-6">Approve Posts</h1>

    @if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    <table class="table-auto w-full">
        <thead>
            <tr>
                <th class="px-4 py-2">Title</th>
                <th class="px-4 py-2">Author</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($posts as $post)
            <tr>
                <td class="border px-4 py-2">{{ $post->title }}</td>
                <td class="border px-4 py-2">{{ $post->user->name }}</td>
                <td class="border px-4 py-2">
                    <form action="{{ route('posts.approve', $post) }}" method="POST" class="inline-block">
                        @csrf
                        <button type="submit"
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Approve</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h2 class="text-2xl font-bold mt-8 mb-4">Approve Post Updates</h2>

    <table class="table-auto w-full">
        <thead>
            <tr>
                <th class="px-4 py-2">Title</th>
                <th class="px-4 py-2">Author</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tempPosts as $tempPost)
            <tr>
                <td class="border px-4 py-2">{{ $tempPost->title }}</td>
                <td class="border px-4 py-2">{{ $tempPost->user->name }}</td>
                <td class="border px-4 py-2">
                    <form action="{{ route('posts.approveTempPost', $tempPost) }}" method="POST" class="inline-block">
                        @csrf
                        <button type="submit"
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Approve</button>
                    </form>
                    <form action="{{ route('posts.rejectTempPost', $tempPost) }}" method="POST" class="inline-block">
                        @csrf
                        <button type="submit"
                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Reject</button>
                    </form>
                </td>
            </tr>
            @endforeach
            </t body>
    </table>

    <h2 class="text-2xl font-bold mt-8 mb-4">Approve Post Delete</h2>

    <table class="table-auto w-full">
        <thead>
            <tr>
                <th class="px-4 py-2">Title</th>
                <th class="px-4 py-2">Author</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tempDeletePosts as $tempDeletePost)
            <tr>
                <td class="border px-4 py-2">{{ $tempDeletePost->title }}</td>
                <td class="border px-4 py-2">{{ $tempDeletePost->user->name }}</td>
                <td class="border px-4 py-2">
                    <form action="{{ route('posts.confirmDelete', $tempPost=$tempDeletePost) }}" method="POST"
                        class="inline-block">
                        @csrf
                        <button type="submit"
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Approve</button>
                    </form>
                    <form action="{{ route('posts.rejectDelete', $tempPost=$tempDeletePost) }}" method="POST"
                        class="inline-block">
                        @csrf
                        <button type="submit"
                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Reject</button>
                    </form>
                </td>
            </tr>
            @endforeach
            </t body>
    </table>
</div>

@endsection