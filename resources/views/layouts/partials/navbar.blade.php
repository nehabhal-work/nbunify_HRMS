<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
    id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <div class="navbar-nav align-items-center">
            <div class="nav-item dropdown-style-switcher dropdown me-2 me-xl-0">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <i class="bx bx-sm"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-start dropdown-styles">
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);" data-theme="light">
                            <span class="align-middle"><i class="bx bx-sun me-2"></i>Light</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);" data-theme="dark">
                            <span class="align-middle"><i class="bx bx-moon me-2"></i>Dark</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);" data-theme="system">
                            <span class="align-middle"><i class="bx bx-desktop me-2"></i>System</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <style>
            /* .navbar .dropdown-menu {
                overflow: visible !important;
            } */

            /* .submenu {
                display: none;
                position: absolute;
                top: 0;
                left: 100%;
                margin-left: 4px;
                z-index: 1050;
            } */

           /* .submenu .dropdown-item {
    font-size: 13px;
    padding-left: 2.2rem;
    opacity: 0.9;
} */

        </style>
        @php
            $name = Auth::user()->name ?? '';
            $words = explode(' ', $name);

            if (count($words) >= 2) {
                $initials = strtoupper(substr($words[0], 0, 2) . substr($words[1], 0, 1));
            } else {
                $initials = strtoupper(substr($words[0], 0, 2));
            }
        @endphp

        <ul class="navbar-nav flex-row align-items-center ms-auto">
            <!-- User -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online d-flex align-items-center justify-content-center
                        rounded-circle bg-primary text-white fw-bold"
                        style="width:40px;height:40px;">
                        {{ $initials }}
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="#">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online d-flex align-items-center justify-content-center
                        rounded-circle bg-primary text-white fw-bold"
                                        style="width:40px;height:40px;">
                                        {{ $initials }}
                                    </div>
                                </div>

                                <div class="flex-grow-1">
                                    <span class="fw-medium d-block">{{ Auth::user()->name }}</span>
                                    <small class="text-muted">Level {{ Auth::user()->level }}</small>
                                </div>
                            </div>
                        </a>

                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="bx bx-user me-2"></i>
                            <span class="align-middle">My Profile</span>
                        </a>
                    </li>
                    <li class="position-relative">
                        <a class="dropdown-item d-flex justify-content-between align-items-center" href="#"
                            data-bs-toggle="submenu">
                            <span>
                                <i class="bx bx-cog me-2"></i> Settings
                            </span>
                            <i class="bx bx-chevron-right"></i>
                        </a>

                        <ul class="dropdown-menu submenu">
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="bx bx-user me-2"></i> User
                                </a>
                            </li>
                        </ul>
                    </li>


                    <li>
                        <a class="dropdown-item" href="#">
                            <span class="d-flex align-items-center align-middle">
                                <i class="flex-shrink-0 bx bx-credit-card me-2"></i>
                                <span class="flex-grow-1 align-middle ms-1">Task List</span>
                                <span
                                    class="flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20">4</span>
                            </span>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            @method('POST')
                            <button type="submit" class="btn align-middle text-danger"><i
                                    class="bx bx-power-off me-2"></i> Log Out</button>

                        </form>
                        </a>
                    </li>
                </ul>
            </li>


        </ul>


    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('[data-bs-toggle="submenu"]').forEach(el => {
                el.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const submenu = this.nextElementSibling;

                    // close others
                    document.querySelectorAll('.submenu').forEach(sm => {
                        if (sm !== submenu) sm.style.display = 'none';
                    });

                    submenu.style.display =
                        submenu.style.display === 'block' ? 'none' : 'block';
                });
            });
        });
    </script>
</nav>
