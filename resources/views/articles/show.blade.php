@extends('layouts.app')

@section('content')
<div class="container">
    <p>View count: {{ $viewCount }}</p>
    <h2>{{ $article->title }}</h2>
    <p>{{ $article->content }}</p>
    <a href="{{ route('article.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection
