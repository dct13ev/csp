<div class="jumbotron text-center" style="margin-bottom:0">
  <h1>My Blog</h1>
</div>

<nav class="navbar navbar-expand-lg navbar-dark bg-danger">
  <div class="container">
    <a class="navbar-brand font-weight-bold" href="#">Weblog</a>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item"><a class="nav-link active" href="{{ route('home') }}">Trang chủ</a></li>
      <li class="nav-item"><a class="nav-link" href="#">Bài viết</a></li>
      <li class="nav-item"><a class="nav-link" href="#">Liên hệ</a></li>
      @auth
        <li class="nav-item"><span class="nav-link">Xin chào, {{ auth()->user()->name }}</span></li>
        <li class="nav-item">
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-link nav-link">Đăng xuất</button>
          </form>
        </li>
      @else
        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Đăng nhập</a></li>
      @endauth
    </ul>
  </div>  
</nav>