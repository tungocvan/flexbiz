<nav class="app-header navbar navbar-expand bg-body">
    <div class="container-fluid">

        {{-- Sidebar Toggle --}}
        {{-- <button class="btn btn-link px-2" data-lte-toggle="sidebar-collapse">
            <i class="fas fa-bars fs-4"></i>
        </button> --}}
        <button class="btn btn-sm btn-primary" id="sidebarToggle" style="border-radius: 6px;">
            <i class="fas fa-bars fs-4"></i>
        </button>

        {{-- Right Menu --}}
        <ul class="navbar-nav ms-auto me-3">
            <li class="nav-item dropdown">
                <a class="nav-link" data-bs-toggle="dropdown" href="#">
                    <i class="fas fa-user-circle fs-4"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li class="dropdown-header">
                        {{ auth()->user()->name }}
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a href="{{ route('logout') }}" class="dropdown-item">Đăng xuất</a></li>
                </ul>
            </li>
        </ul>

    </div>
</nav>

<!-- CUSTOM SIDEBAR JS -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const sidebar = document.getElementById("sidebar");
        const toggleBtn = document.getElementById("sidebarToggle");

        toggleBtn.addEventListener("click", function () {
            sidebar.classList.toggle("collapsed");

        });
    });
</script>
<!-- SIDEBAR CSS -->
<style>
    /* ---------------- DEFAULT SIDEBAR ---------------- */
    :root {
        --lte-sidebar-width: 250px; /* sidebar mở */
    }
    #sidebar {
            width: var(--lte-sidebar-width)!important;
            transition: width 0.5s ease-in-out ; /* hiệu ứng mượt */
            overflow: hidden;
        }
    /* ---------------- COLLAPSED ---------------- */
    #sidebar.collapsed {

        transition: width 3.45s ease;
        --lte-sidebar-width:0px;
    }


</style>
