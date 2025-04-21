@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create Article</h2>

    <form action="{{ route('article.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Title</label>
            <input name="title" class="form-control" value="{{ old('title') }}">
            @error('title') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label>Content</label>
            <textarea name="content" class="form-control">{{ old('content') }}</textarea>
            @error('content') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <button class="btn btn-success">Save</button>
    </form>
</div>
@endsection
