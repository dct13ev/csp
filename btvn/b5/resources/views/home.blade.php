@extends('layouts.app')

@section('content')
<div class="container" style="margin-top:30px; margin-bottom:30px">
  <div class="row">
    <div class="col-sm-4">
      <h2>Về tôi</h2>
      <h5>Ảnh đại diện:</h5>
      <div class="fakeimg">Demo</div>
      <h3>Danh mục</h3>
      <ul class="nav nav-pills flex-column">
        <li class="nav-item"><a class="nav-link active" href="#">Demo</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Demo</a></li>
      </ul>
      <hr class="d-sm-none">
    </div>

    <div class="col-sm-8">
      @if(!empty($posts))
          @foreach($posts as $post)
              <h2>{{ $post['title'] }}</h2>
              <h5>Ngày đăng: {{ $post['date'] }}</h5>
              <div class="fakeimg">Demo</div>
              <p class="mt-3">{{ $post['content'] }}</p>
              <br>
          @endforeach
      @else
          <p>Trang demo chưa có bài viết nào.</p>
      @endif
    </div>
  </div>
</div>
@endsection