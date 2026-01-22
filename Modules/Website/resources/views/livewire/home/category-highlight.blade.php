<div class="py-10 bg-white">
    {{-- Header Section --}}
    <div class="flex items-end justify-between mb-8 px-2">
        <div>
            <h3 class="text-2xl md:text-3xl font-bold text-gray-900 tracking-tight">
                Khám Phá Danh Mục
            </h3>
            <p class="text-gray-500 text-sm mt-1">Tìm kiếm xu hướng theo sở thích của bạn</p>
        </div>

        {{-- LINK 1: Xem tất cả (Không tham số) --}}
        <a href="{{ route('product.list') }}" class="group flex items-center gap-1 text-sm font-semibold text-gray-900 hover:text-green-600 transition">
            Xem tất cả
            <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
        </a>
    </div>

    {{-- Grid Layout --}}
    <div class="grid grid-cols-4 md:grid-cols-8 gap-y-8 gap-x-4">
        @foreach($categories as $category)
            {{-- LINK 2: Link động theo Slug (Tạo query param ?categorySlug=...) --}}
            <a href="{{ route('product.list', ['categorySlug' => $category->slug]) }}" class="group flex flex-col items-center cursor-pointer">

                {{-- Image Container --}}
                <div class="relative w-20 h-20 md:w-24 md:h-24 mb-3">
                    <div class="absolute inset-0 rounded-full border-[2px] border-dashed border-gray-300 group-hover:border-green-500 group-hover:rotate-180 transition duration-700 ease-in-out"></div>

                    <div class="absolute inset-1 rounded-full overflow-hidden border-2 border-white shadow-md group-hover:shadow-lg transition bg-gray-50">
                        @if($category->image)
                            <img src="{{ asset($category->image) }}"
                                 alt="{{ $category->name }}"
                                 class="w-full h-full object-cover transform transition duration-500 group-hover:scale-110">
                        @elseif($category->icon)
                            <div class="w-full h-full flex items-center justify-center text-gray-400 bg-gray-100 group-hover:text-green-600 transition">
                                {!! $category->icon !!}
                            </div>
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-100 text-xl font-bold text-gray-400 group-hover:text-green-600">
                                {{ substr($category->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Tên danh mục --}}
                <span class="text-xs md:text-sm font-semibold text-gray-700 text-center group-hover:text-green-700 transition px-1 line-clamp-2">
                    {{ $category->name }}
                </span>
            </a>
        @endforeach
    </div>
</div>
