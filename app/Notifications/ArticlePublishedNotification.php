<?php

namespace App\Notifications;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ArticlePublishedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    public function via($notifiable)
    {
        return ['database']; // or add 'mail' or others
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => $this->article->title,
            'url' => route('articles.show', $this->article->id),
        ];
    }
}
