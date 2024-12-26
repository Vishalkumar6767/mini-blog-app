@extends('layouts.app')

@section('content')
<div class="card mb-3">
    <div class="card-body">
        <h1 class="card-title">{{ $post->title }}</h1>
        <p class="card-text">{{ $post->content }}</p>
        <p class="text-muted">By {{ $post->user->name }} on {{ $post->created_at->format('d M Y') }}</p>
    </div>
</div>

<h3>Comments</h3>
<div id="comments">
    @foreach($post->comments->take(2) as $comment)
    <div class="card mb-2">
        <div class="card-body">
            <p>{{ $comment->content }}</p>
            <small class="text-muted ">By {{ $comment->user->name }} on {{ $comment->created_at ? $comment->created_at->format('d M Y') : 'N/A' }}</small>
        </div>
    </div>
    @endforeach
</div>
@if($post->comments->count() > 2)
<div class="text-center mb-3">
    <button id="load-more" class="btn btn-outline-primary" data-page="1">
        Show More Comments
    </button>
    <div id="comments-loader" class="d-none">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</div>
@endif

@auth
<form id="comment-form">
    @csrf
    <div class="mb-3">
        <textarea id="comment-content" class="form-control" placeholder="Add a comment..." required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endauth
@endsection

@push('scripts')
<script>
    $('#comment-form').on('submit', function(e) {
        e.preventDefault();
        const content = $('#comment-content').val();
        const postId = {{ $post->id }};
        $.ajax({
            url: `/posts/${postId}/comments`,
            type: 'POST',
            data: { content: content, _token: "{{ csrf_token() }}" },
            success: function(comment) {
                const date = new Date(comment.created_at);
                const formattedDate = date.toLocaleDateString('en-GB', {
                    day: 'numeric',
                    month: 'short',
                    year: 'numeric'
                });
                
                const newComment = `
                    <div class="card mb-2">
                        <div class="card-body">
                            <p>${comment.content}</p>
                            <small class="text-muted">By ${comment.user.name} on ${formattedDate}</small>
                        </div>
                    </div>`;
                $('#comments').append(newComment);
                $('#comment-content').val('');
            }
        });
    });

    $('#load-more').on('click', function() {
        const button = $(this);
        const loader = $('#comments-loader');
        const page = parseInt(button.data('page'));
        const postId = {{ $post->id }};

        button.hide();
        loader.removeClass('d-none');

        $.ajax({
            url: `/posts/${postId}/comments`,
            type: 'GET',
            data: { page: page },
            success: function(response) {
                loader.addClass('d-none');
                
                response.comments.forEach(comment => {
                    const date = new Date(comment.created_at);
                    const formattedDate = date.toLocaleDateString('en-GB', {
                        day: 'numeric',
                        month: 'short',
                        year: 'numeric'
                    });
                    
                    const newComment = `
                        <div class="card mb-2">
                            <div class="card-body">
                                <p>${comment.content}</p>
                                <small class="text-muted">By ${comment.user.name} on ${formattedDate}</small>
                            </div>
                        </div>`;
                    $('#comments').append(newComment);
                });

                if (response.has_more) {
                    button.data('page', page + 1).show();
                }
            },
            error: function() {
                loader.addClass('d-none');
                button.show();
                alert('Error loading comments');
            }
        });
    });
</script>
@endpush
