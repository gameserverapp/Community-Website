<?php

namespace GameserverApp\Policies\Forum;

use GameserverApp\Models\User;
use Illuminate\Support\Facades\Gate;
use GameserverApp\Models\Forum\Thread;

class ThreadPolicy
{
    /**
     * Permission: Delete posts in thread.
     *
     * @param object $user
     * @param Thread $thread
     *
     * @return bool
     */
    public function deletePosts($user, Thread $thread)
    {
        return $user instanceof User and
            $user->hasPermission('manage_forum');
    }

    /**
     * Permission: Rename thread.
     *
     * @param object $user
     * @param Thread $thread
     *
     * @return bool
     */
    public function rename($user, Thread $thread)
    {
        if(!$user instanceof User) {
            return false;
        }

        return $user->id === $thread->firstPost->author->id or $user->hasPermission('manage_forum');
    }

    /**
     * Permission: Reply to thread.
     *
     * @param object $user
     * @param Thread $thread
     *
     * @return bool
     */
    public function reply($user, Thread $thread)
    {
        if(!$user instanceof User) {
            return false;
        }

        return ! $thread->locked or $user->hasPermission('manage_forum');
    }

    /**
     * Permission: Delete thread.
     *
     * @param object $user
     * @param Thread $thread
     *
     * @return bool
     */
    public function delete($user, Thread $thread)
    {
        if(!$user instanceof User) {
            return false;
        }

        return Gate::allows('deleteThreads', $thread->category) || $user->id === $thread->author->id;
    }
}
