<?php

namespace App\Providers;

use App\Models\Articles\Article;
use App\Models\Articles\ImagesArticle;
use App\Models\Articles\RatingArticle;
use App\Policies\Articles\ArticlePolicy;
use App\Policies\Articles\ImagesArticlePolicy;
use App\Policies\Articles\RatingArticlePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
