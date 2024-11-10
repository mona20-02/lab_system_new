<?php

namespace App\Http\Controllers;

use App\Models\Post;
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

}
