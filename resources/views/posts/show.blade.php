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
    @foreach($post->comments as $comment)
    <div class="card mb-2">
        <div class="card-body">
            <p>{{ $comment->content }}</p>
            <small class="text-muted">By {{ $comment->user->name }} on {{ $comment->created_at->format('d M Y') }}</small>
        </div>
    </div>
    @endforeach
</div>

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
                const newComment = `
                    <div class="card mb-2">
                        <div class="card-body">
                            <p>${comment.content}</p>
                            <small class="text-muted">By ${comment.user.name} just now</small>
                        </div>
                    </div>`;
                $('#comments').append(newComment);
                $('#comment-content').val('');
            }
        });
    });
</script>
@endpush
