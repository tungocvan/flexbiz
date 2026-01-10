<div>
    <ul class="navbar-nav mr-auto">
        {{-- Tất cả sản phẩm --}}
        @php
            $isAllActive = request()->routeIs('website.products.index');
        @endphp

        <li class="nav-item">
            <a href="{{ route('website.products.index') }}"
               class="dropdown-item nav-link {{ $isAllActive ? 'active' : '' }}">
                Chuyên mục
            </a>
        </li>

        {{-- Category tree --}}
        @foreach ($categories as $category)
            @include('Website::livewire.components.menu-item', ['category' => $category])
        @endforeach
    </ul>

    <style>
        /* ===============================
   CATEGORY MENU – GLOBAL EFFECT
================================ */

        /* Smooth transition */
        .navbar .nav-link,
        .dropdown-item {
            transition: all 0.2s ease-in-out;
        }

        /* ===============================
   CATEGORY MENU WRAPPER
================================ */

        .navbar-nav {
            border: 1px solid rgba(0, 123, 255, 0.25);
            border-radius: 8px;
            padding: 6px 10px;
            background-color: #fff;
            box-shadow: 0 1px 4px rgba(0,0,0,0.05);
        }

        .navbar-nav:hover {
            border-color: rgba(0, 123, 255, 0.45);

        }

        .navbar-nav .nav-item,
        .navbar-nav .nav-link {
            margin: 0 2px;
        }

        /* ===============================
   ACTIVE CATEGORY (BASE)
================================ */

        .navbar .nav-link.active,
        .dropdown-item.active {
            color: #007bff !important;
            background-color: #e9f2ff;
            border: 1.5px solid #007bff;
            border-radius: 6px;
            padding: 6px 12px;
            font-weight: 600;
        }

        /* ===============================
   ACTIVE PARENT (TREE)
================================ */

        .nav-item.dropdown.active>.nav-link {
            background-color: #e9f2ff;
            border: 2px solid #007bff;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 123, 255, 0.15);
        }

        /* ===============================
   ACTIVE CHILD (DROPDOWN)
================================ */

        .dropdown-item.active {
            background-color: #007bff;
            color: #fff !important;
        }

        /* ===============================
   HOVER EFFECT
================================ */

        .navbar .nav-link:hover,
        .dropdown-item:hover {
            background-color: rgb(230, 225, 225);
            border-radius: 6px;

        }

        /* ===============================
   DROPDOWN MENU
================================ */

        .dropdown-menu {
            margin-top: 6px;
            border-radius: 6px;
        }
    </style>
</div>
