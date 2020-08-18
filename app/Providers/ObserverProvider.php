<?php

namespace App\Providers;

use App\Models\Articles\Article;
use App\Models\Categories\Category;
use App\Models\Comments\Comment;
use App\Observer\Articles\ArticleObserver;
use App\Observer\Categories\CategoryObserver;
use App\Observer\Comments\CommentsObserve;
use App\Observer\Users\UsersObserver;
use App\User;
use Illuminate\Support\ServiceProvider;

class ObserverProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Article::observe(ArticleObserver::class);
        Comment::observe(CommentsObserve::class);
        User::observe(UsersObserver::class);
        Category::observe(CategoryObserver::class);
    }
}
