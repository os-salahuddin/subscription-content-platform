<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ProfileController;
use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $today = now()->format('Y-m-d');

    // Access Count Per User
    $accessData = User::all()->map(function ($user) use ($today) {
        $count = Cache::tags(['access'])->get("access_count:{$user->id}:{$today}", 0);
        return [
            'name' => $user->name,
            'count' => $count,
        ];
    });

    // Top Viewed Articles Leaderboard
    $topArticles = Cache::tags(['metrics', 'article_views'])->remember('leaderboard:articles', now()->addMinutes(10), function () {
        return Article::all()->map(function ($article) {
            $views = Cache::tags(['article_views'])->get("article_views:{$article->id}", 0);
            return [
                'title' => $article->title,
                'views' => $views,
            ];
        })->sortByDesc('views')->take(10)->values();
    });
    $users = User::select(DB::raw("COUNT(*) as count"))
                    ->whereYear('created_at', date('Y'))
                    ->groupBy(DB::raw("Month(created_at)"))
                    ->pluck('count');

    return view('dashboard', [
        'accessData' => $accessData,
        'topArticles' => $topArticles
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('article', ArticleController::class);

    Route::get('/article/{article}', [ArticleController::class, 'show'])
        ->middleware('ensure.article.access')
        ->name('article.show');
        
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
