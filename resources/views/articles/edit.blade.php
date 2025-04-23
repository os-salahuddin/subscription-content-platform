@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Article</h2>

    <form action="{{ route('article.update', $article) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Title</label>
            <input name="title" class="form-control" value="{{ old('title', $article->title) }}">
            @error('title') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label>Content</label>
            <textarea name="content" class="form-control">{{ old('content', $article->content) }}</textarea>
            @error('content') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <button class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
