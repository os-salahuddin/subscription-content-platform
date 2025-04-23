<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\AccessService;

class EnsureArticleAccess
{
    public function handle(Request $request, Closure $next)
    {
        $article = $request->route('article');

        if ($article->is_premium) {
            $user = auth()->user();
            $accessService = app(AccessService::class);

            if (!$accessService->canAccessArticle($user, $article->id)) {
                abort(403, 'Access limit reached');
            }

            $accessService->recordAccess($user, $article->id);
        }

        return $next($request);
    }
}
