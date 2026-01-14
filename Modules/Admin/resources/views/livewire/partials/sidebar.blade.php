<aside class="bg-slate-900 text-white transition-all duration-300 flex-shrink-0 flex flex-col h-full"
       :class="sidebarOpen ? 'w-64' : 'w-20'">

    <div class="h-16 flex items-center justify-center bg-slate-800 shadow-md font-bold tracking-widest uppercase">
        <span x-show="sidebarOpen" class="transition-opacity duration-200">Admin</span>
        <span x-show="!sidebarOpen" class="text-xl">A</span>
    </div>

    <nav class="flex-1 px-2 space-y-2 overflow-y-auto py-4 custom-scrollbar">

        <a href="{{ route('admin.dashboard') }}"
           class="group flex items-center px-3 py-3 text-sm font-medium rounded-lg transition-colors
           {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">

            <svg class="flex-shrink-0 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>

            <span x-show="sidebarOpen" class="ml-3 truncate">Dashboard</span>
        </a>

        <a href="{{ route('admin.menus.index') }}"
           class="group flex items-center px-3 py-3 text-sm font-medium rounded-lg transition-colors mt-1
           {{ request()->routeIs('admin.menus.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">

            <svg class="flex-shrink-0 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
            </svg>

            <span x-show="sidebarOpen" class="ml-3 truncate">Cấu hình Menu</span>
        </a>


        @foreach($menuItems as $item)
            <div x-data="{ open: {{ request()->is(trim($item->url, '/') . '*') ? 'true' : 'false' }} }">

                @if($item->children->count() > 0)
                    <button @click="open = !open" x-show="sidebarOpen"
                            class="w-full group flex items-center justify-between px-3 py-3 text-sm font-medium rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition-colors">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-6 w-6">
                                @if($item->icon)
                                    {!! $item->icon !!}
                                @else
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                                @endif
                            </div>
                            <span class="ml-3 truncate">{{ $item->name }}</span>
                        </div>
                        <svg class="h-4 w-4 transform transition-transform duration-200" :class="open ? 'rotate-90' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>

                    <div x-show="!sidebarOpen" class="flex justify-center py-3 text-slate-300 hover:text-white cursor-pointer" title="{{ $item->name }}">
                         @if($item->icon) {!! $item->icon !!} @else <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg> @endif
                    </div>

                    <div x-show="open && sidebarOpen" x-collapse class="space-y-1 mt-1 pl-11">
                        @foreach($item->children as $child)
                            <a href="{{ $child->url }}"
                               class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors
                               {{ request()->fullUrlIs(url($child->url)) ? 'text-white bg-slate-700' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                                {{ $child->name }}
                            </a>
                        @endforeach
                    </div>

                @else
                    <a href="{{ $item->url }}"
                       class="group flex items-center px-3 py-3 text-sm font-medium rounded-lg transition-colors
                       {{ request()->fullUrlIs(url($item->url)) ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">

                        <div class="flex-shrink-0 h-6 w-6">
                            @if($item->icon)
                                {!! $item->icon !!}
                            @else
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                            @endif
                        </div>

                        <span x-show="sidebarOpen" class="ml-3 truncate">{{ $item->name }}</span>
                    </a>
                @endif

            </div>
        @endforeach

        <div class="pt-4 mt-4 border-t border-slate-700">
             <form method="POST" action="{{ route('website.logout') }}">
                @csrf
                <button type="submit" class="w-full group flex items-center px-3 py-3 text-sm font-medium rounded-lg text-red-400 hover:bg-slate-800 hover:text-red-300 transition-colors">
                    <svg class="flex-shrink-0 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    <span x-show="sidebarOpen" class="ml-3 truncate">Đăng xuất</span>
                </button>
            </form>
        </div>
    </nav>
</aside>
