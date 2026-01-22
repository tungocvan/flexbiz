<div class="w-full bg-white border-t border-gray-100 mt-10">
    <div class="container mx-auto px-4 py-12 md:py-16">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-y-10 gap-x-8">

            @foreach($badges as $badge)
                <div class="group flex items-center gap-5 transition-all duration-300 hover:translate-x-2">

                    {{-- Icon Container --}}
                    <div class="flex-shrink-0 w-16 h-16 flex items-center justify-center rounded-2xl bg-gray-50 text-gray-400 group-hover:bg-blue-50 group-hover:text-blue-600 transition-colors duration-300 shadow-sm group-hover:shadow">
                        {!! $badge['icon'] !!}
                    </div>

                    {{-- Text Content --}}
                    <div class="flex flex-col">
                        <h4 class="text-base font-bold text-gray-900 group-hover:text-blue-600 transition-colors">
                            {{ $badge['title'] }}
                        </h4>
                        <p class="text-sm text-gray-500 font-medium mt-1">
                            {{ $badge['desc'] }}
                        </p>
                    </div>
                </div>
            @endforeach

        </div>
    </div>

    {{-- Dòng kẻ trang trí mờ bên dưới để tách biệt hoàn toàn với Footer --}}
    <div class="h-px w-full bg-gradient-to-r from-transparent via-gray-200 to-transparent"></div>
</div>
