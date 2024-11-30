<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Post $post)
    {
        // 投稿の所有者だけが更新できる
        return $user->id === $post->user_id;
    }

    public function delete(User $user, Post $post)
    {
        // 投稿の所有者だけが削除できる
        return $user->id === $post->user_id;
    }
}
