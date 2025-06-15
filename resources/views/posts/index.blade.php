<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('All Posts') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 text-green-600 font-semibold">
                    {{ session('success') }}
                </div>
            @endif
            <a href="{{ route('posts.create') }}"
                class="inline-block px-4 py-2 mb-3 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                + Create Post
            </a>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($posts as $post)
                    <div
                        class="bg-white shadow-lg rounded-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        @if($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
                                class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500 text-lg">
                                No Image
                            </div>
                        @endif

                        <div class="p-4">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $post->title }}</h3>

                            <p class="text-sm text-gray-600 mb-2">
                                {{ Str::limit($post->content, 100) }}
                            </p>

                            <div class="text-sm text-blue-600 font-medium mb-2">
                                Category: {{ $post->category->name ?? 'Uncategorized' }}
                            </div>

                            <div class="flex flex-wrap gap-1 mb-3">
                                @foreach($post->tags as $tag)
                                    <span class="px-2 py-1 bg-blue-100 text-blue-600 text-xs font-semibold rounded-full">
                                        #{{ $tag->name }}
                                    </span>
                                @endforeach
                            </div>

                            <div class="flex justify-between items-center mt-4">
                                <a href="{{ route('posts.show', $post->id) }}"
                                    class="text-white bg-blue-600 px-3 py-1 rounded hover:bg-blue-700 text-sm">
                                    View
                                </a>
                                @can('update-post', $post)
                                <a href="{{ route('posts.edit', $post->id) }}"
                                    class="text-white bg-yellow-500 px-3 py-1 rounded hover:bg-yellow-600 text-sm">
                                    Edit
                                </a>
                                @endcan
                                @can('delete-post', $post)
                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-white bg-red-600 px-3 py-1 rounded hover:bg-red-700 text-sm">
                                        Delete
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </div>

                    </div>
                @empty
                    <p class="text-gray-500">No posts found.</p>
                @endforelse
            </div>
        </div>
        {{ $posts->links() }}
    </div>
</x-app-layout>
