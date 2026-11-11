<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bảng điều khiển Quản trị') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 text-lg">
                    Xin chào <strong>{{ Auth::user()->name }}</strong>! 
                    Bạn đang đăng nhập với quyền: 
                    <span class="uppercase font-bold {{ Auth::user()->role === 'admin' ? 'text-red-600' : 'text-blue-600' }}">
                        {{ Auth::user()->role }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="{{ route('admin.posts.index') }}" class="block p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-50 transition">
                    <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900">Quản lý Bài viết</h5>
                    <p class="font-normal text-gray-600">Thêm, sửa, xóa, khôi phục và kiểm duyệt trạng thái bài viết.</p>
                </a>

                <a href="{{ route('admin.categories.index') }}" class="block p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-50 transition">
                    <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900">Quản lý Danh mục</h5>
                    <p class="font-normal text-gray-600">Thêm, sửa, xóa các chuyên mục của Blog.</p>
                </a>

                @if(Auth::user()->role === 'admin')
                <a href="{{ route('admin.users.index') }}" class="block p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-50 transition">
                    <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900">Quản lý Người dùng</h5>
                    <p class="font-normal text-gray-600">Quản lý danh sách tài khoản và phân quyền.</p>
                </a>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

