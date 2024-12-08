<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostLike;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Create the user post
     *
     */
    public function store(Request $request) {

        $this->validate($request, [
            'content' => ['required', 'string', 'max:10000'],
        ]);

        $user = auth()->user();

        $user->posts()->create([
            'content' => $request->content,
        ]);

        return redirect()->back();
    }

    /**
     * Toggle like for post
     */
    public function toggleLike(Request $request, Post $post) {

        $post_like = PostLike::where('post_id', $post->id)
            ->where('user_id', auth()->user()->id)
            ->first();

        if(PostLike::where('post_id', $post->id)
            ->where('user_id', auth()->user()->id)
            ->exists())
        {

           $post_like->delete();

        } else {

            PostLike::create([
                'user_id' => auth()->user()->id,
                'post_id' => $post->id,
            ]);

        }

        return redirect()->back();
    }


    public function delete(Request $request, Post $post) {

        $this->authorize('delete', $post);

        $post->delete();

        return redirect()->back();
    }

    public function edit(Request $request, Post $post) {


        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post) {

        $validated = $this->validate($request, [
            'content' => ['required', 'string', 'max:255']
        ]);

        $post->update($validated);

        return redirect()->back();

    }
}
