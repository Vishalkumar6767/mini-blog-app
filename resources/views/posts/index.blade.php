@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h1>Blog Posts</h1>
    @auth
    <a href="{{ route('posts.create') }}" class="btn btn-success">Create New Post</a>
    @endauth
</div>

<div class="mb-3">
    <input type="text" id="search" class="form-control" placeholder="Search posts by title...">
</div>

<div id="posts-list">
    @include('posts.partials.list', ['posts' => $posts])
</div>
@endsection

@push('scripts')
<script>
    $('#search').on('keyup', function() {
        const query = $(this).val();
        $.ajax({
            url: "{{ route('posts.search') }}",
            type: "GET",
            data: { query: query },
            success: function(posts) {
                let html = '';
                posts.forEach(post => {
                    html += `
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">${post.title}</h5>
                                <p class="card-text">${post.content.substring(0, 100)}...</p>
                                <a href="/posts/${post.id}" class="btn btn-primary">Read More</a>
                            </div>
                        </div>`;
                });
                $('#posts-list').html(html);
            }
        });
    });
</script>
@endpush
