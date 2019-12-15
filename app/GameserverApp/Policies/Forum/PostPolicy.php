<?php
namespace GameserverApp\Policies\Forum;

use Illuminate\Support\Facades\Gate;
use GameserverApp\Models\Forum\Post;

class PostPolicy
{
    /**
     * Permission: Edit post.
     *
     * @param  object  $user
     * @param  Post  $post
     * @return bool
     */
    public function edit($user, Post $post)
    {
        return $user->id === $post->author->id or $user->role('Admin');
    }

    /**
     * Permission: Delete post.
     *
     * @param  object  $user
     * @param  Post  $post
     * @return bool
     */
    public function delete($user, Post $post)
    {
        return Gate::forUser($user)->allows('deletePosts', $post->thread) || $user->id === $post->author->id;
    }
}
