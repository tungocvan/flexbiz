@php
    $menus = config('admin_menu', []);
    $user = auth()->user();
@endphp

<aside class="app-sidebar bg-dark text-white shadow-lg" data-bs-theme="dark" id="sidebar">

    <!-- LOGO + SIDEBAR TOGGLE -->
    <div class="sidebar-header d-flex align-items-center justify-content-between px-3 py-2 border-bottom border-secondary">
        <span class="brand-text fw-bold fs-5 menu-text">FlexBiz Admin</span>

        <!-- Toggle Button -->
        {{-- <button class="btn btn-sm btn-outline-light" id="sidebarToggle" style="border-radius: 6px;">
            <i class="fas fa-bars"></i>
        </button> --}}
    </div>

    <!-- MENU -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" id="sidebarMenu">

            @foreach ($menus as $menu)
                @if($user && ($user->hasRole('admin') || $user->can($menu['permission'])))
                    <li class="nav-item">

                        <a href="{{ route($menu['route']) }}"
                           class="nav-link d-flex align-items-center
                           {{ request()->routeIs($menu['route']) ? 'active' : 'text-white' }}"
                           style="padding: 10px 18px;"
                        >
                            <i class="nav-icon {{ $menu['icon'] }} me-2" style="font-size: 16px; width:24px; text-align:center;"></i>

                            <span class="menu-text">{{ $menu['label'] }}</span>
                        </a>
                    </li>
                @endif
            @endforeach

        </ul>
    </nav>

</aside>



<!-- SIDEBAR CSS -->
<style>
    /* ---------------- DEFAULT SIDEBAR ---------------- */
    #sidebar {
        transition: width 0.25s ease;
        overflow: hidden;
        min-height: 100vh;

    }

    /* Ẩn chữ khi collapse */
    #sidebar.collapsed .menu-text {
        display: none !important;
    }

    /* Menu hover */
    #sidebar .nav-link:hover {
        background: rgba(255, 255, 255, 0.1) !important;
        border-radius: 8px;
    }

    /* Active menu */
    #sidebar .nav-link.active {
        background: #0d6efd !important;
        color: #fff !important;
        border-radius: 8px;
        font-weight: 600;
    }
</style>
