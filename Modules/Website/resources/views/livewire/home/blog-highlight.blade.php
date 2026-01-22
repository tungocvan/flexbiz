<div class="mb-24 container mx-auto px-4">
    {{-- Header --}}
    <div class="flex items-end justify-between mb-8 pb-4 border-b border-gray-100">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Tạp Chí & Tin Tức</h2>
            <p class="text-gray-500 text-sm mt-1">Cập nhật xu hướng và kiến thức mới nhất</p>
        </div>
        <a href="/blog" class="group flex items-center gap-1 text-sm font-semibold text-gray-900 hover:text-green-600 transition">
            Xem tất cả bài viết
            <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
        </a>
    </div>

    @if($posts->isNotEmpty())
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

            {{-- 1. HERO POST (Bài mới nhất - Hiển thị lớn bên trái) --}}
            @php $heroPost = $posts->first(); @endphp
            <article class="group relative flex flex-col h-full">
                <a href="{{ route('blog.detail', $heroPost->slug) }}" class="block relative w-full aspect-video md:aspect-[4/3] lg:aspect-auto lg:h-[400px] rounded-2xl overflow-hidden mb-5">
                    <img src="{{ $heroPost->thumbnail }}"
                         alt="{{ $heroPost->name }}"
                         class="w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-105">

                    {{-- Category Tag --}}
                    <span class="absolute top-4 left-4 bg-white/90 backdrop-blur text-gray-900 text-xs font-bold px-3 py-1.5 rounded-full uppercase tracking-wider shadow-sm">
                        {{ $heroPost->categories->first()->name ?? 'Blog' }}
                    </span>
                </a>

                <div class="flex-1 flex flex-col">
                    <div class="flex items-center gap-3 text-xs text-gray-500 mb-3">
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            {{ $heroPost->published_at ? \Carbon\Carbon::parse($heroPost->published_at)->format('d/m/Y') : 'Vừa xong' }}
                        </span>
                        <span>•</span>
                        <span>5 phút đọc</span>
                    </div>

                    <h3 class="text-2xl font-bold text-gray-900 mb-3 leading-tight group-hover:text-green-600 transition-colors">
                        <a href="{{ route('blog.detail', $heroPost->slug) }}">
                            {{ $heroPost->title }}
                        </a>
                    </h3>

                    <p class="text-gray-600 line-clamp-3 mb-4 flex-1">
                        {{ $heroPost->summary }}
                    </p>

                    <a href="{{ route('blog.detail', $heroPost->slug) }}" class="inline-flex items-center text-sm font-bold text-gray-900 underline decoration-2 decoration-gray-300 underline-offset-4 hover:decoration-green-600 hover:text-green-600 transition-all">
                        Đọc tiếp
                    </a>
                </div>
            </article>

            {{-- 2. LIST POSTS (3 bài tiếp theo - Bên phải) --}}
            <div class="flex flex-col gap-8 lg:border-l lg:border-gray-100 lg:pl-10">
                @foreach($posts->skip(1) as $post)
                    <article class="group flex gap-5 items-start">
                        {{-- Ảnh nhỏ --}}
                        <a href="{{ route('blog.detail', $post->slug) }}" class="flex-shrink-0 w-32 h-24 md:w-40 md:h-28 rounded-xl overflow-hidden bg-gray-100">
                            <img src="{{ $post->thumbnail }}"
                                 alt="{{ $post->name }}"
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        </a>

                        {{-- Nội dung --}}
                        <div class="flex-1 min-w-0">
                            <div class="text-[10px] uppercase font-bold text-green-600 mb-1.5 tracking-wide">
                                {{ $post->categories->first()->name ?? 'Tin tức' }}
                            </div>

                            <h4 class="text-base md:text-lg font-bold text-gray-900 leading-snug mb-2 group-hover:text-green-600 transition-colors line-clamp-2">
                                <a href="{{ route('blog.detail', $post->slug) }}">
                                    {{ $post->name }}
                                </a>
                            </h4>

                            <div class="text-xs text-gray-400">
                                {{ $post->published_at ? \Carbon\Carbon::parse($post->published_at)->format('d M, Y') : '' }}
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

        </div>
    @else
        <div class="text-center py-10 text-gray-400">Đang cập nhật bài viết...</div>
    @endif
</div>
