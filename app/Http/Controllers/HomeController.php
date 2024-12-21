<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostLike;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = Post::with('post_likes')
            // ->whereHas('friends', callback: fn($query) => $query->where
            ->orderBy('created_at', 'desc')
            ->get();

        return view('home', compact('posts'));
    }
    public function toggleLike(Request $request, Post $post)
    {
        if ($post->isVisibleToUser(auth()->user())) {
            $post_like = PostLike::where('post_id', $post->id)
                ->where('user_id', auth()->user()->id)
                ->first();

            if ($post_like) {
                $post_like->delete();
            } else {
                PostLike::create([
                    'user_id' => auth()->user()->id,
                    'post_id' => $post->id,
                ]);
            }
        }

        return redirect()->back();
    }
}
