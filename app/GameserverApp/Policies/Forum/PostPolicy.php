<?php
namespace GameserverApp\Policies\Forum;

use GameserverApp\Models\User;
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
        if(!$user instanceof User) {
            return false;
        }

        return $user->id === $post->author->id or $user->hasPermission('manage_forum');
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
        if(!$user instanceof User) {
            return false;
        }

        return Gate::forUser($user)->allows('deletePosts', $post->thread) || $user->id === $post->author->id;
    }
}
