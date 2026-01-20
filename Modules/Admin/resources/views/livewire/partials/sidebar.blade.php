@php
    use Modules\Website\Models\Category;

    // Lấy menu cấp 1, kèm theo con cái, sắp xếp
    $menus = Category::menu()
        ->active()
        ->whereNull('parent_id')
        ->with('children') // Eager load children
        ->sorted()
        ->get();
@endphp

<aside class="h-full flex flex-col bg-gray-900 text-white  transition-all duration-300"
    :class="sidebarOpen ? 'w-64' : 'w-20'">

    <div class="flex items-center justify-center h-16 bg-gray-900 border-b border-gray-800 shadow-sm">
        <span class="text-xl font-bold tracking-wider uppercase text-indigo-500">Master<span
                class="text-white">Admin</span></span>
    </div>

    <div class="flex-1 overflow-y-auto py-4 custom-scrollbar">
        <nav class="space-y-1 px-2">

            @foreach ($menus as $menu)
                {{-- Check quyền cấp cha --}}
                @if ($menu->can && !auth()->user()->can($menu->can))
                    @continue
                @endif

                {{-- 1. SECTION HEADER (Logic: Không URL, Không Parent, Không Children trong ngữ cảnh này coi là Header) --}}
                {{-- Hoặc đơn giản: Nếu URL null và KHÔNG có children (như trong JSON seeding) --}}
                @if (empty($menu->url) && $menu->children->isEmpty())
                    <div class="mt-6 mb-2 px-3 text-xs font-bold text-gray-500 uppercase tracking-widest">
                        {{ $menu->name }}
                    </div>
                    @continue
                @endif

                @php
                    $hasChildren = $menu->children->isNotEmpty();
                    // Check Active: URL hiện tại bắt đầu bằng URL menu HOẶC con của nó active
                    $isActive =
                        ($menu->url && request()->is(ltrim($menu->url, '/') . '*')) ||
                        ($hasChildren &&
                            $menu->children->contains(fn($c) => $c->url && request()->is(ltrim($c->url, '/') . '*')));
                @endphp

                {{-- 2. DROPDOWN MENU --}}
                @if ($hasChildren)
                    <div x-data="{ open: {{ $isActive ? 'true' : 'false' }} }" class="space-y-1">
                        <button @click="open = !open" type="button"
                            class="group w-full flex items-center pl-2 pr-2 py-2 text-sm font-medium rounded-lg transition-all duration-200 focus:outline-none 
                               {{ $isActive ? 'bg-gray-800 text-white shadow-inner' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">

                            {{-- Icon --}}
                            @if ($menu->icon)
                                <x-icon name="{{ $menu->icon }}"
                                    class="mr-3 flex-shrink-0 h-5 w-5 {{ $isActive ? 'text-indigo-400' : 'text-gray-500 group-hover:text-gray-300' }}" />
                            @endif

                            <span class="flex-1 text-left tracking-wide">{{ $menu->name }}</span>

                            {{-- Arrow --}}
                            <svg :class="open ? 'text-gray-400 rotate-90' : 'text-gray-600'"
                                class="ml-2 flex-shrink-0 h-4 w-4 transform transition-colors duration-200 ease-in-out group-hover:text-gray-400"
                                viewBox="0 0 20 20" aria-hidden="true">
                                <path d="M6 6L14 10L6 14V6Z" fill="currentColor" />
                            </svg>
                        </button>

                        {{-- Submenu --}}
                        <div x-show="open" x-collapse class="space-y-1 pl-10 pt-1" style="display: none;">
                            @foreach ($menu->children as $child)
                                @if ($child->can && !auth()->user()->can($child->can))
                                    @continue
                                @endif

                                <a href="{{ url($child->url) }}"
                                    class="group flex items-center px-2 py-1.5 text-sm font-medium rounded-md transition-colors duration-150
                                      {{ request()->is(ltrim($child->url, '/') . '*') ? 'text-white bg-indigo-600 shadow-sm' : 'text-gray-400 hover:text-white hover:bg-gray-700' }}">
                                    {{ $child->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    {{-- 3. SINGLE MENU --}}
                @else
                    <a href="{{ url($menu->url) }}"
                        class="group flex items-center px-2 py-2 text-sm font-medium rounded-lg transition-all duration-200 
                          {{ $isActive ? 'bg-gray-800 text-white shadow-inner' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">

                        @if ($menu->icon)
                            <x-icon name="{{ $menu->icon }}"
                                class="mr-3 flex-shrink-0 h-5 w-5 {{ $isActive ? 'text-indigo-400' : 'text-gray-500 group-hover:text-gray-300' }}" />
                        @endif

                        <span class="tracking-wide">{{ $menu->name }}</span>
                    </a>
                @endif
            @endforeach

        </nav>
    </div>

    <div class="border-t border-gray-800 p-4">
        <div class="flex items-center">
            <div class="ml-3">
                <p class="text-sm font-medium text-white">{{ auth()->user()->name }}</p>
                <p class="text-xs text-gray-500">View Profile</p>
            </div>
        </div>
    </div>
</aside>
