@extends('layouts.app')

@section('content')
<h1>Create New Post</h1>
<form action="{{ route('posts.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" id="title" name="title" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="content" class="form-label">Content</label>
        <textarea id="content" name="content" rows="5" class="form-control" required></textarea>
    </div>
    <div class="mb-3">
        <label for="category" class="form-label">Category</label>
        <select id="category" name="category_id" class="form-control">
            <option value="">Select a category</option>
            @foreach ($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Create</button>
</form>
@endsection
