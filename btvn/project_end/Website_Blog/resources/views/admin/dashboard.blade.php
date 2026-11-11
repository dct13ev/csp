<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bảng điều khiển Quản trị') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm font-medium text-gray-500">Người dùng</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $stats['users'] }}</p>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm font-medium text-gray-500">Bài viết</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $stats['posts'] }}</p>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm font-medium text-gray-500">Bình luận</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $stats['comments'] }}</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-6">Bài viết có nhiều bình luận nhất</h3>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 border">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                            <tr>
                                <th class="px-4 py-3 border-r">ID</th>
                                <th class="px-4 py-3 border-r">Tiêu đề</th>
                                <th class="px-4 py-3 text-center">Số bình luận</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topPosts as $post)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-4 py-3 border-r">{{ $post->id }}</td>
                                    <td class="px-4 py-3 border-r font-medium text-gray-900">
                                        {{ $post->title }}
                                    </td>
                                    <td class="px-4 py-3 text-center">{{ $post->comments_count }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-6 text-center text-gray-500">
                                        Chưa có bài viết nào.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
