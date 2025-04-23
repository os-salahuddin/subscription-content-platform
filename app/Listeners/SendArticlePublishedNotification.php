<?php

namespace App\Listeners;

use App\Events\ArticlePublished;
use App\Models\User;
use App\Notifications\ArticlePublishedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendArticlePublishedNotification
{
    /**
     * Create the event listener.
     */
    public function __construct(ArticlePublished $event)
    {
        // You can filter users if needed
        $users = User::all();

        foreach ($users as $user) {
            $user->notify(new ArticlePublishedNotification($event->article));
        }
    }

    /**
     * Handle the event.
     */
    public function handle(ArticlePublished $event): void
    {
        //
    }
}
