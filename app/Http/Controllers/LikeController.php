<?php

namespace App\Http\Controllers;
use App\Models\Like;
use App\Models\Post;

use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Post $post)
    {
        $post->likes()->create([
            'user_id' => auth()->id(),
            'post_id' => $post->id,
        ]);

        return back()->with('message', 'いいねしました');
    }

    public function destroy(Post $post)
    {
        $like = Like::where('user_id', auth()->id())
                    ->where('post_id', $post->id)
                    ->first();

        if ($like) {
            $like->delete();
        }

        return back()->with('message', 'いいねを取り消しました');
    }
}
