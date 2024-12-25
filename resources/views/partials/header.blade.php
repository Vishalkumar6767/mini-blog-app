<nav class="navbar navbar-expand-lg navbar-light bg-secondary bg-opacity-50">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('posts.index') }}">Mini Blog</a>
        <div class="d-flex">
            @guest
                <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Login</a>
                <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
            @else
                <span class="navbar-text me-3">Hello, {{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger">Logout</button>
                </form>
            @endguest
        </div>
    </div>
</nav>