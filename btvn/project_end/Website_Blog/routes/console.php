<?php

use App\Models\Post;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    $published = Post::where('status', 'scheduled')
        ->where('published_at', '<=', now())
        ->update(['status' => 'published']);

    if ($published > 0) {
        Log::channel('blog')->info('Bài viết hẹn giờ đã được đăng tự động.', [
            'published_count' => $published,
        ]);
    }
})->everyMinute();
