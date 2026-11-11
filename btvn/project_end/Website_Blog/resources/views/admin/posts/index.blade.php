<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Quản lý Bài viết') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-900">Danh sách bài viết</h3>
                    <a href="{{ route('admin.posts.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-medium">
                        + Thêm bài viết mới
                    </a>
                </div>
                
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 border">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                            <tr>
                                <th class="px-4 py-3 border-r">ID</th>
                                <th class="px-4 py-3 border-r w-1/3">Tiêu đề</th>
                                <th class="px-4 py-3 border-r">Danh mục</th>
                                <th class="px-4 py-3 border-r">Tác giả</th>
                                <th class="px-4 py-3 border-r text-center">Trạng thái</th>
                                <th class="px-4 py-3 text-center">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($posts as $post)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-4 py-3 border-r">{{ $post->id }}</td>
                                <td class="px-4 py-3 border-r font-medium text-gray-900">{{ $post->title }}</td>
                                <td class="px-4 py-3 border-r">{{ $post->category->name }}</td>
                                <td class="px-4 py-3 border-r">{{ $post->user->name }}</td>
                                <td class="px-4 py-3 border-r text-center">
                                    <span class="px-2 py-1 text-xs rounded-full {{ $post->status == 'published' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ ['published' => 'Đã đăng', 'draft' => 'Bản nháp', 'scheduled' => 'Hẹn giờ'][$post->status] ?? $post->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center space-x-2">
                                    @can('update', $post)
                                        <a href="{{ route('admin.posts.edit', $post->id) }}" class="text-blue-600 hover:underline">Sửa</a>
                                    @endcan

                                    @can('delete', $post)
                                        <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Bạn có chắc chắn muốn xóa bài viết này không?')">
                                                Xóa
                                            </button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4">
                    {{ $posts->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>