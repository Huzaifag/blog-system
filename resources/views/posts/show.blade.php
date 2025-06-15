<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $post->title }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                @if($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-32 object-cover">
                @else
                    <div class="w-full h-64 bg-gray-200 flex items-center justify-center text-gray-500 text-lg">
                        No Image
                    </div>
                @endif

                <div class="p-6">
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $post->title }}</h1>

                    <div class="mb-2 text-sm text-gray-600">
                        Posted {{ $post->created_at->diffForHumans() }} by <span class="font-medium text-blue-600">{{ $post->user->name ?? 'Unknown' }}</span>
                    </div>

                    <div class="mb-4 text-sm text-blue-700 font-semibold">
                        Category: {{ $post->category->name ?? 'Uncategorized' }}
                    </div>

                    <div class="mb-4 flex flex-wrap gap-2">
                        @foreach($post->tags as $tag)
                            <span class="bg-blue-100 text-blue-700 text-xs px-3 py-1 rounded-full font-semibold">
                                #{{ $tag->name }}
                            </span>
                        @endforeach
                    </div>

                    <div class="text-gray-800 leading-relaxed">
                        {!! nl2br(e($post->content)) !!}
                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        @can('update-post', $post)
                        <a href="{{ route('posts.edit', $post->id) }}"
                            class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 text-sm">
                            Edit
                        </a>
                        @endcan
                        @can('delete-post', $post)
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this post?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 text-sm">
                                Delete
                            </button>
                        </form>
                        @endcan
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <a href="{{ route('posts.index') }}"
                    class="text-blue-600 hover:underline text-sm">
                    ← Back to all posts
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
