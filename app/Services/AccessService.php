<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Cache;

class AccessService 
{
    protected function accessCountKey(User $user): string
    {
        return "user:{$user->id}:access_count:" . now()->toDateString();
    }

    protected function subscriptionKey(User $user): string
    {
        return "user:{$user->id}:subscription";
    }

    public function canAccessArticle(User $user): bool
    {
        $cacheKey = $this->accessCountKey($user);

        $subscription = Cache::remember($this->subscriptionKey($user), 3600, function () use ($user) {
            return $user->subscription()->with('plan')->first();
        });

        if (!$subscription || !$subscription->plan) return false;

        $accessCount = Cache::get($cacheKey, 0);     

        return $accessCount < $subscription->plan->daily_limit;
    }

    public function recordAccess(User $user): void
    {
        $cacheKey = $this->accessCountKey($user);

        if (!Cache::has($cacheKey)) {
            Cache::put($cacheKey, 1, now()->endOfDay());
        } else {
            Cache::increment($cacheKey);
        }
    }
}