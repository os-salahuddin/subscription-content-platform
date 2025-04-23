<?php

namespace App\Providers;

use App\Events\ArticlePublished;
use App\Listeners\SendArticlePublishedNotification;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        ArticlePublished::class => [
            SendArticlePublishedNotification::class,
        ],
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
