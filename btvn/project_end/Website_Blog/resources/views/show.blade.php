<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->title }} | My Blog</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased">
    
    <nav class="bg-white shadow-sm py-4 border-b border-gray-100">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-xl font-black text-blue-600 tracking-tight">&larr; Về Trang chủ</a>
        </div>
    </nav>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-8 lg:p-12">
                
                <div class="text-sm font-bold text-blue-600 uppercase tracking-wider mb-4">
                    {{ $post->category->name ?? 'Không phân loại' }}
                </div>

                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-6 leading-tight">
                    {{ $post->title }}
                </h1>

                <div class="flex items-center text-gray-500 text-sm mb-10 pb-6 border-b border-gray-100">
                    <span class="font-medium text-gray-700 mr-2">Đăng bởi: {{ $post->user->name ?? 'Ẩn danh' }}</span>
                    <span>&bull;</span>
                    <span class="ml-2">Ngày đăng: {{ $post->created_at->format('d/m/Y H:i') }}</span>
                </div>

                <div class="prose max-w-none text-gray-800 leading-relaxed space-y-4">
                    {!! nl2br(e($post->content)) !!}
                </div>
                
                @if ($post->tags->count() > 0)
                    <div class="mt-8 pt-4 border-t border-gray-100">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="text-sm font-bold text-gray-700">Tags:</span>
                            @foreach ($post->tags as $tag)
                                <a href="{{ route('tag.show', $tag->slug) }}" class="inline-block bg-gray-100 hover:bg-blue-100 text-gray-600 hover:text-blue-700 text-xs font-semibold px-3 py-1 rounded-full transition cursor-pointer">
                                    #{{ $tag->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="mt-12 pt-8 border-t border-gray-200">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Bình luận ({{ $post->comments->count() }})</h3>
                    
                    @if (session('success'))
                        <div class="p-3 mb-4 text-sm text-green-800 bg-green-50 rounded-lg">{{ session('success') }}</div>
                    @endif

                    @auth
                        <form action="{{ route('comments.store', $post->id) }}" method="POST" class="mb-8">
                            @csrf
                            <textarea name="content" rows="3" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3" placeholder="Viết bình luận của bạn..." required></textarea>
                            <button type="submit" class="mt-3 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-md transition">Gửi bình luận</button>
                        </form>
                    @else
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-8 text-center">
                            <p class="text-gray-600">Vui lòng <a href="{{ route('login') }}" class="text-blue-600 font-bold hover:underline">đăng nhập</a> để lại bình luận.</p>
                        </div>
                    @endauth

                    <div class="space-y-6">
                        @forelse ($post->comments->sortByDesc('created_at') as $comment)
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-bold text-gray-800">{{ $comment->user->name ?? 'Người dùng ẩn danh' }}</span>
                                    <span class="text-xs text-gray-500">{{ $comment->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                @can('delete', $comment)
                                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Xóa bình luận này?');">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 text-xs hover:underline">Xóa</button>
                                    </form>
                                    @endcan
                                <p class="text-gray-700 text-sm">{{ $comment->content }}</p>
                            </div>
                        @empty
                            <p class="text-gray-500 italic text-sm">Chưa có bình luận nào. Hãy là người đầu tiên!</p>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
</html>