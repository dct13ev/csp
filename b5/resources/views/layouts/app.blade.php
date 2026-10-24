<!DOCTYPE html>
<html lang="vi">
<head>
  <title>{{ $title ?? 'Mộc | Tạp chí của những điều giản dị' }}</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Mộc - những câu chuyện nhỏ về lối sống, sách và cảm hứng.">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
  @include('partials.header')
  @yield('content')
  @include('partials.footer')
</body>
</html>