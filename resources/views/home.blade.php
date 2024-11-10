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
                            <div class="text-end">
                                {{ $post->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>

                    {{ $post->content }}

                </div>

                <div class="mx-2 my-1">
                    <button type="button" class="btn btn-sm btn-outline-primary">Like</button>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>

@endsection
