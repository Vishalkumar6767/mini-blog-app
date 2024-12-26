<nav class="navbar navbar-expand-lg navbar-light bg-success bg-opacity-50">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('posts.index') }}">Mini Blog</a>
        
        <!-- Add hamburger menu button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Wrap content in collapsible div -->
        <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
            <div class="d-lg-flex">
                @guest
                    <a href="{{ route('login') }}" class="btn btn-outline-primary me-2 mb-2 mb-lg-0">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                @else
                    <span class="navbar-text me-3 d-block mb-2 mb-lg-0">Hello, {{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger">Logout</button>
                    </form>
                @endguest
            </div>
        </div>
    </div>
</nav>