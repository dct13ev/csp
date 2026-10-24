<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $baiVietNoiBat = [
        [
            'title' => 'Những ngày chậm rãi giữa lòng thành phố',
            'category' => 'Lối sống',
            'date' => '24 Tháng 10, 2026',
            'read_time' => '5 phút đọc',
            'image' => 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?auto=format&fit=crop&w=1400&q=85',
            'content' => 'Có những buổi sáng chỉ cần một tách cà phê, một trang sách và vài phút lặng yên là đủ để bắt đầu lại.'
        ],
        [
            'title' => 'Một góc nhỏ để nuôi dưỡng cảm hứng',
            'category' => 'Sáng tạo',
            'date' => '18 Tháng 10, 2026',
            'read_time' => '4 phút đọc',
            'image' => 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?auto=format&fit=crop&w=900&q=80',
            'content' => 'Ghi lại những ý tưởng vụn vặt mỗi ngày để biến chúng thành điều có ý nghĩa hơn.'
        ]
    ];

    $baiVietMoi = [
        [
            'title' => 'Đi tìm sự cân bằng trong một tuần bận rộn',
            'category' => 'Lối sống',
            'date' => '16 Tháng 10, 2026',
            'read_time' => '6 phút đọc',
            'image' => 'https://images.unsplash.com/photo-1499209974431-9dddcece7f88?auto=format&fit=crop&w=900&q=80',
            'content' => 'Một vài thói quen nhỏ giúp những ngày nhiều việc trở nên nhẹ nhàng hơn.'
        ],
        [
            'title' => 'Đọc gì khi cần một khoảng nghỉ?',
            'category' => 'Sách',
            'date' => '12 Tháng 10, 2026',
            'read_time' => '3 phút đọc',
            'image' => 'https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=crop&w=900&q=80',
            'content' => 'Ba cuốn sách mang đến cảm giác bình yên và một góc nhìn mới về cuộc sống.'
        ],
        [
            'title' => 'Bài học từ những chuyến đi không kế hoạch',
            'category' => 'Du ký',
            'date' => '08 Tháng 10, 2026',
            'read_time' => '7 phút đọc',
            'image' => 'https://images.unsplash.com/photo-1500534623283-312aade485b7?auto=format&fit=crop&w=900&q=80',
            'content' => 'Đôi khi hành trình đáng nhớ nhất lại bắt đầu từ một quyết định rất ngẫu hứng.'
        ]
    ];

    return view('home', compact('baiVietNoiBat', 'baiVietMoi'));
});