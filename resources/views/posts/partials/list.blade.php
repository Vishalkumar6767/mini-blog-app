@foreach($posts as $post)
<div class="card mb-3">
    <div class="card-body">
        <h5 class="card-title">{{ $post->title }}</h5>
        <p class="card-text">{{ Str::limit($post->content, 100) }}</p>
        <a href="{{ route('posts.show', $post) }}" class="btn btn-primary">Read More</a>

        @if(Auth::check() && Auth::id() === $post->user_id)
        <a href="{{ route('posts.edit', $post) }}" class="btn btn-warning">Edit</a>
        <form action="{{ route('posts.destroy', $post) }}" method="POST" style="display: inline-block;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
        </form>
        @endif
    </div>
</div>
@endforeach
{{ $posts->links() }}
