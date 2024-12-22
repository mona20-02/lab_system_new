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
        $user = auth()->user();
        $posts = Post::with('post_likes')
            ->get()
            ->filter(function ($post) use ($user) {
                return $post->isVisibleToUser($user);
            })
            ->sortByDesc('created_at');

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
