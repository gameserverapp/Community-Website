<?php

namespace GameserverApp\Policies\Forum;

use GameserverApp\Models\User;

class ForumPolicy
{
    /**
     * Permission: Create categories.
     *
     * @param object $user
     *
     * @return bool
     */
    public function createCategories($user)
    {
        return $user instanceof User and
            $user->hasPermission('manage_forum');
    }

    /**
     * Permission: Manage category.
     *
     * @param object $user
     *
     * @return bool
     */
    public function manageCategories($user)
    {
        return $user instanceof User and
            $this->moveCategories($user) ||
            $this->renameCategories($user);
    }

    /**
     * Permission: Move categories.
     *
     * @param object $user
     *
     * @return bool
     */
    public function moveCategories($user)
    {
        return $user instanceof User and
            $user->hasPermission('manage_forum');
    }

    /**
     * Permission: Rename categories.
     *
     * @param object $user
     *
     * @return bool
     */
    public function renameCategories($user)
    {
        return $user instanceof User and
            $user->hasPermission('manage_forum');
    }

    /**
     * Permission: Mark new/updated threads as read.
     *
     * @param object $user
     *
     * @return bool
     */
    public function markNewThreadsAsRead($user)
    {
        return true;
    }

    /**
     * Permission: View trashed threads.
     *
     * @param object $user
     *
     * @return bool
     */
    public function viewTrashedThreads($user)
    {
        return $user instanceof User and
            $user->hasPermission('manage_forum');
    }

    /**
     * Permission: View trashed posts.
     *
     * @param object $user
     *
     * @return bool
     */
    public function viewTrashedPosts($user)
    {
        return $user instanceof User and
            $user->hasPermission('manage_forum');
    }
}
