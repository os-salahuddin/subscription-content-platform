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
            if (!app(AccessService::class)->canAccessArticle($user)) {
                abort(403, 'Access limit reached');
            }

            app(AccessService::class)->recordAccess($user);
        }

        return $next($request);
    }
}
