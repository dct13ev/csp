@extends('layouts.app')

@section('content')
<div class="container mt-5" style="margin-bottom:30px">
  <div class="row">
    
    <div class="col-sm-8">
      <h4 class="text-danger font-weight-bold border-bottom pb-2 mb-4">BÀI VIẾT MỚI</h4>
      
      @if(!empty($posts))
          @foreach($posts as $post)
              <div class="media mb-4 border-bottom pb-3">
                  <img src="{{ asset('pictures/images.jpg') }}" class="mr-3 img-fluid" style="width: 160px; height: 100px; object-fit: cover;" alt="Ảnh bài viết">
                  <div class="media-body">
                      <h5 class="mt-0 font-weight-bold text-dark">{{ $post['title'] }}</h5>
                      <small class="text-muted">Ngày đăng: {{ $post['date'] }}</small>
                      <p class="mb-0 mt-2">{{ $post['content'] }}</p>
                  </div>
              </div>
          @endforeach
      @else
          <p>Trang demo chưa có bài viết nào.</p>
      @endif
    </div>
    <div class="col-sm-4">
      <h2>Về tôi</h2>
      <h5>Ảnh đại diện:</h5>
      <img src="{{ asset('pictures/meme-meo-cuoi-chi-tay-dep-nhat.jpg') }}" class="img-fluid mb-4" alt="Ảnh đại diện">
      <p>Tận hưởng cuộc sống tuyệt vời!</p>
      <h5 class="font-weight-bold border-bottom pb-2 mb-3">Bài viết nổi bật</h5>
      <ul class="list-unstyled">
        <li class="mb-3"><a href="#" class="text-dark font-weight-bold">Bài viết số 1...</a></li>
        <li class="mb-3"><a href="#" class="text-dark font-weight-bold">Bài viết số 2...</a></li>
        <li class="mb-3"><a href="#" class="text-dark font-weight-bold">Bài viết số 3...</a></li>
      </ul>
    </div>

  </div>
</div>
@endsection