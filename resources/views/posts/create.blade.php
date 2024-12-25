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
    <button type="submit" class="btn btn-primary">Create</button>
</form>
@endsection
