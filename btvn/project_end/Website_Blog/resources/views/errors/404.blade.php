<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Không tìm thấy trang</title>
    <style>
        body { margin: 0; background: #f3f4f6; color: #1f2937; font-family: Arial, sans-serif; }
        main { min-height: 100vh; display: grid; place-items: center; padding: 1.5rem; text-align: center; }
        .card { max-width: 32rem; padding: 2.5rem; background: #fff; border-radius: .75rem; box-shadow: 0 4px 12px rgb(0 0 0 / 8%); }
        h1 { margin: 0; color: #2563eb; font-size: 4rem; }
        a { display: inline-block; margin-top: 1.5rem; padding: .75rem 1.25rem; color: #fff; background: #2563eb; border-radius: .375rem; text-decoration: none; }
    </style>
</head>
<body>
    <main>
        <section class="card">
            <h1>404</h1>
            <h2>Không tìm thấy trang</h2>
            <p>Trang bạn đang tìm kiếm không tồn tại hoặc đã được di chuyển.</p>
            <a href="{{ url('/') }}">Về trang chủ</a>
        </section>
    </main>
</body>
</html>
