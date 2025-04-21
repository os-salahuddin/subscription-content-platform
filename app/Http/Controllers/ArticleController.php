<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::all();
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

        Article::create($request->only('title', 'content'));

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

        return redirect()->route('article.index')->with('success', 'Article updated successfully.');
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('article.index')->with('success', 'Article deleted successfully.');
    }
}