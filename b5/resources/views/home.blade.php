@extends('layouts.app')

@section('content')
<main>
  <section class="hero container">
    <div class="hero-copy"><p class="eyebrow">TẠP CHÍ CỦA NHỮNG ĐIỀU GIẢN DỊ</p><h1>Ghi lại những điều <em>đáng nhớ.</em></h1><p class="hero-text">Mộc là nơi những câu chuyện về lối sống, sách và hành trình trưởng thành được kể bằng một giọng thật gần.</p><a class="text-link" href="#bai-viet">Đọc những câu chuyện mới <span>↗</span></a></div>
    <div class="hero-note"><span class="note-line"></span><p>“Cuộc sống không cần vội, chỉ cần đủ đầy.”</p><small>— MỘC JOURNAL</small></div>
  </section>

  <section class="featured container" id="bai-viet">
    <div class="section-heading"><div><p class="eyebrow">ĐÁNG ĐỌC NHẤT</p><h2>Câu chuyện nổi bật</h2></div><a class="text-link" href="#bai-viet">Xem tất cả <span>↗</span></a></div>
    <div class="featured-grid">
      @foreach($baiVietNoiBat as $index => $post)
        <article class="featured-card {{ $index === 0 ? 'featured-main' : 'featured-secondary' }}">
          <div class="post-image"><img src="{{ $post['image'] }}" alt="{{ $post['title'] }}"><span class="image-tag">{{ $post['category'] }}</span></div>
          <div class="post-body"><div class="post-meta"><span>{{ $post['date'] }}</span><span>{{ $post['read_time'] }}</span></div><h3><a href="#">{{ $post['title'] }}</a></h3><p>{{ $post['content'] }}</p><a class="arrow-link" href="#">Đọc tiếp <span>↗</span></a></div>
        </article>
      @endforeach
    </div>
  </section>

  <section class="latest container">
    <div class="latest-content"><div class="section-heading"><div><p class="eyebrow">MỚI NHẤT</p><h2>Từ trang nhật ký</h2></div></div>
      <div class="post-list">
        @foreach($baiVietMoi as $post)
          <article class="list-card"><div class="list-image"><img src="{{ $post['image'] }}" alt="{{ $post['title'] }}"></div><div class="post-body"><div class="post-meta"><span>{{ $post['category'] }}</span><span>{{ $post['date'] }}</span></div><h3><a href="#">{{ $post['title'] }}</a></h3><p>{{ $post['content'] }}</p><a class="arrow-link" href="#">Đọc bài viết <span>↗</span></a></div></article>
        @endforeach
      </div>
    </div>
    <aside class="about-card" id="gioi-thieu"><span class="about-icon">✦</span><p class="eyebrow">VỀ NGƯỜI VIẾT</p><h2>Xin chào, mình là An.</h2><p>Mình viết về những điều nhỏ bé giúp cuộc sống trở nên có ý nghĩa hơn: một cuốn sách hay, một chuyến đi xa, hay một buổi chiều thật yên.</p><a class="text-link" href="#">Tìm hiểu thêm <span>↗</span></a><div class="topics"><span>Lối sống</span><span>Sách</span><span>Du ký</span><span>Sáng tạo</span></div></aside>
  </section>
</main>
@endsection