<?php

namespace App\Http\Controllers;

use App\Events\ArticlePublished;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::paginate(3);
        return view('articles.index', compact('articles'));
    }

    public function create()
    {
        return view('articles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $article = Article::create($request->only('title', 'content'));
        event(new ArticlePublished($article));

        return redirect()->route('article.index')->with('success', 'Article created successfully.');
    }

    public function show(Article $article)
    {
        $viewCacheKey = "article:{$article->id}:views";
        Cache::increment($viewCacheKey);
    
        $cachedArticle = Cache::remember(
            "article:{$article->id}",
            3600,
            fn() => $article->fresh()
        );
    
        return view('articles.show', [
            'article' => $cachedArticle,
            'viewCount' => Cache::get($viewCacheKey)
        ]);
    }

    public function edit(Article $article)
    {
        return view('articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $article->update($request->only('title', 'content'));

        $key = "article:{$article->id}:views";
        Cache::forget($key);

        return redirect()->route('article.index')->with('success', 'Article updated successfully.');
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('article.index')->with('success', 'Article deleted successfully.');
    }
}