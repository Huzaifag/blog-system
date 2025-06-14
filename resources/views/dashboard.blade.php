<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Welcome to your Blog Dashboard!</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="bg-blue-100 p-4 rounded shadow">
                            <div class="text-2xl font-semibold">{{ $postsCount ?? 0 }}</div>
                            <div class="text-gray-700">Posts</div>
                        </div>
                        <div class="bg-green-100 p-4 rounded shadow">
                            <div class="text-2xl font-semibold">{{ $categoriesCount ?? 0 }}</div>
                            <div class="text-gray-700">Categories</div>
                        </div>
                        <div class="bg-yellow-100 p-4 rounded shadow">
                            <div class="text-2xl font-semibold">{{ $commentsCount ?? 0 }}</div>
                            <div class="text-gray-700">Comments</div>
                        </div>
                    </div>
                    <a href="{{route('posts.create')}}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                        Create New Post
                    </a>
                    <div class="mt-8">
                        <h4 class="font-semibold mb-2">Recent Posts</h4>
                        <ul>
                            @forelse($recentPosts ?? [] as $post)
                                <li class="mb-2">
                                    <a href="{{ route('posts.show', $post->id) }}" class="text-blue-500 hover:underline">
                                        {{ $post->title }}
                                    </a>
                                    <span class="text-sm text-gray-500">({{ $post->created_at->diffForHumans() }})</span>
                                </li>
                            @empty
                                <li class="text-gray-500">No recent posts.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
