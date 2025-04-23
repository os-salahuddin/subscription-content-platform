@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Articles</h2>
    <a href="{{ route('article.create') }}" class="btn btn-primary mb-3">Create New Article</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($articles as $article)
                <tr>
                    <td>{{ $article->title }}</td>
                    <td>
                        <a href="{{ route('article.show', $article) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('article.edit', $article) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('article.destroy', $article) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $articles->links() }}
</div>
@endsection
