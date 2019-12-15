<?php

use GameserverApp\Models\User;

return [

    /*
    |--------------------------------------------------------------------------
    | Policies
    |--------------------------------------------------------------------------
    |
    | Here we specify the policy classes to use. Change these if you want to
    | extend the provided classes and use your own instead.
    |
    */

    'policies' => [
        'forum' => GameserverApp\Policies\Forum\ForumPolicy::class,
        'model' => [
            GameserverApp\Models\Forum\Category::class => GameserverApp\Policies\Forum\CategoryPolicy::class,
            GameserverApp\Models\Forum\Thread::class   => GameserverApp\Policies\Forum\ThreadPolicy::class,
            GameserverApp\Models\Forum\Post::class     => GameserverApp\Policies\Forum\PostPolicy::class
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Application user model
    |--------------------------------------------------------------------------
    |
    | Your application's user model.
    |
    */

    'user_model' => User::class,

    /*
    |--------------------------------------------------------------------------
    | Application user name
    |--------------------------------------------------------------------------
    |
    | The attribute to use for the username.
    |
    */

    'user_name' => 'name',

];
