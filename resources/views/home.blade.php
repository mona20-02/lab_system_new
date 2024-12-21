@extends('layouts.app')

@section('content')

<div class="container">
 
    <div class="row ">

        <div class="col col-4">

            <div class="card mb-3 p-3 border rounded shadow-sm bg-white">
                <form action="{{ route('posts.create') }}" method="POST">
                    @method('POST')
                    @csrf

                    <div class="form-floating">
                            <textarea name="content" class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"></textarea>
                            <label for="floatingTextarea2">What's on you mind?</label>
                    </div>

                    <div class="mx-2 my-1">
                        <button type="submit" class="btn btn-sm btn-primary">Post</button>
                    </div>
                </form>

            </div>

        </div>
        <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-secondary ms-2">See all users</a>
        <div class="col">
            @foreach ($posts as $post)
            <div class="card mb-3 border rounded shadow-sm bg-white">
                <div class="card-body ">

                    <div class="row">
                        <div class="col">
                            <div >
                                {{ $post->user->name }}
                            </div>

                            <hr>
                        </div>

                        <div class="col ">

                            <div class="row">


                                <div class="text-end d-flex justify-end">
                                    <!-- This is the time slot of the post -->
                                    <div class="col">
                                        <div class="text-end">
                                            {{ $post->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                    <!-- This is the END of time slot of the post -->


                                    <!-- This is the time slot of the dropdown button -->
                                    <div class="col">

                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-secondary dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                Options
                                            </a>

                                            <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="{{ route('posts.edit', $post) }}" role="button">Edit</a></li>

                                                @can('delete', $post)
                                                    <form action="{{ route('posts.delete', $post) }}" method="POST">
                                                        @method('DELETE')
                                                        @csrf

                                                        <li><button class="dropdown-item" type="submit"><span class="text-danger">Delete</span></button></li>

                                                    </form>
                                                @endcan


                                            </ul>
                                        </div>
                                    </div>
                                    <!-- This is the time END slot of the dropdown button -->
                                </div>


                            </div>

                        </div>
                    </div>

                    {{ $post->content }}

                </div>

                <div class="mx-2 my-1">
                    <form action="{{ route('posts.toggleLike', $post) }}">
                        @csrf
                        @method('POST')
                        <button type="submit" class="btn btn-sm btn-outline-primary">
                            <span>
                                {{ $post->post_likes->contains('user_id', auth()->user()->id) ? 'Unlike' : 'Like' }}
                            </span>
                            <span class="ms-1 badge text-bg-secondary">{{ $post->post_likes->count() }}</span>
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>

@endsection
