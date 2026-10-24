@extends('layouts.app')

@section('content')
<div class="container" style="margin-top:30px; margin-bottom:30px">
  <div class="row">
    <!-- Cột Sidebar -->
    <div class="col-sm-4">
      <h2>Về tôi</h2>
      <h5>Ảnh đại diện:</h5>
      <div class="fakeimg">Demo</div>
      <p>Xin chào.</p>
      <h3>Danh mục</h3>
      <ul class="nav nav-pills flex-column">
        <li class="nav-item"><a class="nav-link active" href="#">Công nghệ</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Du lịch</a></li>
      </ul>
      <hr class="d-sm-none">
    </div>

    <!-- Cột Bài viết -->
    <div class="col-sm-8">
      @if(!empty($posts))
          @foreach($posts as $post)
              <h2>{{ $post['title'] }}</h2>
              <h5>Ngày đăng: {{ $post['date'] }}</h5>
              <div class="fakeimg">Ảnh bìa bài viết</div>
              <p class="mt-3">{{ $post['content'] }}</p>
              <br>
          @endforeach
      @else
          <p>Chưa có bài viết nào được đăng.</p>
      @endif
    </div>
  </div>
</div>
@endsection