@extends('layout')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-6">Role Upgrade Requests</h1>

    @if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">User</th>
                <th class="py-2 px-4 border-b">Requested Role</th>
                <th class="py-2 px-4 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($roleRequests as $roleRequest)
            <tr>
                <td class="py-2 px-4 border-b">{{ $roleRequest->user->name }}</td>
                <td class="py-2 px-4 border-b">{{ ucfirst($roleRequest->requested_role) }}</td>
                <td class="py-2 px-4 border-b">
                    <form action="{{ route('roleRequests.approve', $roleRequest) }}" method="POST" class="inline-block">
                        @csrf
                        <button type="submit"
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Approve</button>
                    </form>
                    <form action="{{ route('roleRequests.reject', $roleRequest) }}" method="POST" class="inline-block">
                        @csrf
                        <button type="submit"
                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Reject</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table
>
</div>
@endsection