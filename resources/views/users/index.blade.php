@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Users') }}</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <h2>All users</h2>
                    <ul>
                        @foreach ($users as $user)
                            <li>
                                {{ $user->name }}
                                @if (auth()->user()->hasSentFriendRequestTo($user))
                                    <p>Friend request sent. Waiting for response...</p>
                                @elseif ($user->hasPendingFriendRequestFrom(auth()->user()))
                                    <form action="{{ route('friend-request.accept', $user) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Accept Friend Request</button>
                                    </form>
                                    <form action="{{ route('friend-request.reject', $user) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Reject Friend Request</button>
                                    </form>
                                @elseif (!$user->isFriend(auth()->user()))
                                    <form action="{{ route('friend-request.send', $user) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Send Friend Request</button>
                                    </form>
                                @else
                                    <p>You are friends with {{ $user->name }}</p>
                                @endif
                            </li>
                        @endforeach

                        <h2>Incoming Friend Requests</h2>
                        <ul>
                            @foreach (auth()->user()->friendRequests as $request)
                                <li>
                                    {{ $request->user->name }} wants to be your friend.
                                    <form action="{{ route('friend-request.accept', $request->user) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Accept</button>
                                    </form>
                                    <form action="{{ route('friend-request.reject', $request->user) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Reject</button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection