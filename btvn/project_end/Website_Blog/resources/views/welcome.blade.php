<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Cộng Đồng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">Blog Cộng Đồng</a>
            <div class="d-flex text-white">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-light btn-sm">Vào Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm me-2">Đăng nhập</a>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Đăng ký</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container">
        <h2 class="mb-4">Bài viết mới nhất</h2>
        
        <div class="row">
            @foreach($posts as $post)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <span class="badge bg-secondary mb-2">{{ $post->category->name }}</span>
                            <h5 class="card-title text-truncate">{{ $post->title }}</h5>
                            <p class="card-text text-muted small">
                                Bởi <strong>{{ $post->user->name }}</strong> - {{ $post->created_at->format('d/m/Y') }}
                            </p>
                            <p class="card-text">{{ Str::limit($post->content, 100) }}</p>
                        </div>
                        <div class="card-footer bg-white border-top-0">
                            <a href="#" class="btn btn-primary btn-sm w-100">Đọc tiếp</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $posts->links('pagination::bootstrap-5') }}
        </div>
    </div>

</body>
</html>