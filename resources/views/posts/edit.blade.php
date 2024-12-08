@extends('layouts.app')

@section('content')

<div class="container">
    <form action="{{ route('posts.update', $post)}}" method="POST">
        @csrf
        @method('PUT')
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

                <textarea class="form-control @error('content') border border-danger @enderror" name="content" id="" cols="30" rows="10">{{$post->content}}</textarea>
                @error('content')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mx-4 my-2">

                <button type="submit" class="btn btn-outline-primary">
                    <span>
                        Update
                    </span>
                </button>
            </div>
        </div>
    </form>

</div>



@endsection
