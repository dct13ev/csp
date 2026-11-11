<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Blog</title>
    <!-- Load Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased">
    
    <nav class="bg-white shadow-md py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-2xl font-black text-blue-600 tracking-tight">
                My Blog
            </a>
            <div>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-gray-700 hover:text-blue-600 font-medium transition">Quản trị</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 font-medium mr-6 transition">Đăng nhập</a>
                        <a href="{{ route('register') }}" class="bg-blue-600 text-white px-5 py-2 rounded-md hover:bg-blue-700 font-medium transition shadow-sm">Đăng ký</a>
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 flex flex-wrap lg:flex-nowrap gap-8">
        
        <div class="w-full lg:w-3/4">
            
            <div class="mb-8 p-4 bg-white rounded-lg shadow-sm border border-gray-100">
                <form action="{{ url('/') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
                    
                    <div class="flex-1">
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Nhập từ khóa tìm kiếm..." 
                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div class="w-full sm:w-1/4">
                        <select name="category" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">-- Tất cả danh mục --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-md transition duration-200">
                        Tìm kiếm
                    </button>
                    
                    @if(request('search') || request('category'))
                        <a href="{{ url('/') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded-md transition duration-200 text-center">
                            Xóa lọc
                        </a>
                    @endif
                </form>
            </div>

            <h2 class="text-3xl font-bold mb-8 text-gray-800 border-l-4 border-blue-600 pl-3">
                @if(isset($currentCategory))
                    Danh mục: {{ $currentCategory->name }}
                @elseif(isset($currentTag))
                    Tag: #{{ $currentTag->name }}
                @else
                    Bài viết mới nhất
                @endif
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach ($posts as $post)
                    <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden border border-gray-100">
                        <div class="p-6">

                            <div class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-2">
                                {{ $post->category->name ?? 'Không phân loại' }}
                            </div>
                            
                            <h3 class="text-xl font-bold mb-3 line-clamp-2 leading-tight">
                                <a href="{{ route('post.show', $post->slug) }}" class="text-gray-900 hover:text-blue-600 transition">{{ $post->title }}</a>
                            </h3>
                            
                            <p class="text-gray-600 mb-4 line-clamp-3 text-sm">
                                {{ \Illuminate\Support\Str::limit(strip_tags($post->content), 120) }}
                            </p>
                            
                            <div class="flex justify-between items-center text-xs text-gray-500 mt-4 pt-4 border-t border-gray-100">
                                <span>Đăng ngày: {{ $post->created_at->format('d/m/Y') }}</span>
                                <a href="{{ route('post.show', $post->slug) }}" class="text-blue-600 font-semibold hover:underline">Đọc tiếp &rarr;</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-10">
                {{ $posts->links() }}
            </div>
        </div>

        <div class="w-full lg:w-1/4">
            <div class="bg-white rounded-xl shadow-sm p-6 mb-6 border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-b border-gray-100 pb-3">Chuyên mục</h3>
                <ul class="space-y-3">
                    @foreach ($categories as $category)
                        <li>
                            <a href="{{ route('category.show', $category->id) }}" class="text-gray-600 hover:text-blue-600 font-medium flex items-center transition">
                                <span class="w-2 h-2 rounded-full bg-gray-300 mr-3"></span>
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            
            <div class="bg-blue-50 rounded-xl shadow-sm p-6 border border-blue-100">
                <h3 class="text-lg font-bold text-blue-800 mb-2">Về chúng tôi</h3>
                <p class="text-sm text-blue-900 leading-relaxed">Đây là không gian chia sẻ kiến thức và thảo luận dành cho cộng đồng. Tham gia ngay để cùng đóng góp nhé!</p>
            </div>
        </div>

    </div>
</body>
</html>