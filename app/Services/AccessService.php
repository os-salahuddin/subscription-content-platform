<?php
namespace App\Services;

use App\Models\AccessLog;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class AccessService 
{
    protected function subscriptionKey(User $user): string
    {
        return "user:{$user->id}:subscription";
    }

    public function canAccessArticle(User $user, int $articleId): bool
    {
        $subscription = Cache::remember($this->subscriptionKey($user), 3600, function () use ($user) {
            return $user->subscription()->with('plan')->first();
        });

        if (!$subscription || !$subscription->plan) return false;

        $key = $this->articleAccessSetKey($user);

        $accessedArticleIds = Cache::get($key, []);
        
        return in_array($articleId, $accessedArticleIds) &&
            count($accessedArticleIds) >= $subscription->plan->daily_limit;
    }

    public function recordAccess(User $user, int $articleId): void
    {
        $key = $this->articleAccessSetKey($user);

        $articles = Cache::get($key, []);
        if (!in_array($articleId, $articles)) {
            $articles[] = $articleId;
            Cache::put($key, $articles, now()->endOfDay());

            $this->storeAccessLog($articleId);
        }
    }

    protected function storeAccessLog(int $articleId)
    {
        AccessLog::create([
            'article_id' => $articleId,
            'user_id' => auth()->user()->id
        ]);
    }

    protected function articleAccessSetKey(User $user): string
    {
        return "user:{$user->id}:accessed_articles:" . now()->toDateString();
    }
}