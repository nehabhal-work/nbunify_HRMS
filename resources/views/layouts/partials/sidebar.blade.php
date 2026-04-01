<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo" style="height: 100px;">
        <a href="index.html" class="app-brand-link">
            <span class="app-brand-logo demo">
                NBUnify -HRMS
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>
    
    <ul class="menu-inner py-1">
        <li class="menu-item {{ request()->routeIs('dashboard.*') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon bx bx-home"></i>
                <div class="text-truncate">Dashboard</div>
            </a>
        </li>
        <li class="menu-item {{ request()->is('master/*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div class="text-truncate" data-i18n="Master">Master</div>
            </a>
            <ul class="menu-sub">

                <li class="menu-item {{ request()->routeIs('master.companies.*') ? 'active' : '' }}">
                    <a href="{{ route('master.companies.index') }}" class="menu-link">
                        <i class="menu-icon bx bx-buildings"></i>
                        <div class="text-truncate">Companies</div>
                    </a>
                </li>

                {{-- <li class="menu-item {{ request()->routeIs('master.branches.*') ? 'active' : '' }}">
                    <a href="{{ route('master.branches.index') }}" class="menu-link">
                        <i class="menu-icon bx bx-git-branch"></i>
                        <div class="text-truncate">Branches</div>
                    </a>
                </li>

                <li class="menu-item {{ request()->routeIs('master.head-offices.*') ? 'active' : '' }}">
                    <a href="{{ route('master.head-offices.index') }}" class="menu-link">
                        <i class="menu-icon bx bx-building-house"></i>
                        <div class="text-truncate">Head Offices</div>
                    </a>
                </li>

                <li class="menu-item {{ request()->routeIs('master.departments.*') ? 'active' : '' }}">
                    <a href="{{ route('master.departments.index') }}" class="menu-link">
                        <i class="menu-icon bx bx-network-chart"></i>
                        <div class="text-truncate">Departments</div>
                    </a>
                </li>

                <li class="menu-item {{ request()->routeIs('master.designations.*') ? 'active' : '' }}">
                    <a href="{{ route('master.designations.index') }}" class="menu-link">
                        <i class="menu-icon bx bx-id-card"></i>
                        <div class="text-truncate">Designations</div>
                    </a>
                </li>

                <li class="menu-item {{ request()->routeIs('master.employees.*') ? 'active' : '' }}">
                    <a href="{{ route('master.employees.index') }}" class="menu-link">
                        <i class="menu-icon bx bx-group"></i>
                        <div class="text-truncate">Employees</div>
                    </a>
                </li> --}}

            </ul>
        </li>
    </ul>

    {{-- ── User Profile Block at Bottom ── --}}

    @php
        $name = Auth::user()->name ?? '';
        $words = explode(' ', $name);
        if (count($words) >= 2) {
            $initials = strtoupper(substr($words[0], 0, 2) . substr($words[1], 0, 1));
        } else {
            $initials = strtoupper(substr($words[0], 0, 2));
        }
    @endphp

    <div class="sidebar-user-profile" id="sidebarUserTrigger">
        <div class="sidebar-user-avatar">{{ $initials }}</div>
        <div class="sidebar-user-info">
            <span class="sidebar-user-name">{{ Auth::user()->name }}</span>
            <span class="sidebar-user-level">Level {{ Auth::user()->level }}</span>
        </div>
        <i class="bx bx-dots-vertical-rounded sidebar-user-dots"></i>
    </div>

    {{-- ── Sidebar User Popup ── --}}
    <div class="sidebar-user-popup" id="sidebarUserPopup">
        {{-- Header --}}
        <div class="sup-header">
            <div class="sup-avatar">{{ $initials }}</div>
            <div class="sup-info">
                <span class="sup-name">{{ Auth::user()->name }}</span>
                <span class="sup-level">Level {{ Auth::user()->level }}</span>
            </div>
        </div>

        <div class="sup-divider"></div>

        {{-- My Profile --}}
        <a href="#" class="sup-item">
            <i class="bx bx-user"></i>
            <span>My Profile</span>
        </a>

        {{-- Settings with submenu --}}
        <div class="sup-item sup-has-sub" id="supSettingsTrigger">
            <i class="bx bx-cog"></i>
            <span>Settings</span>
            <i class="bx bx-chevron-right sup-chevron ms-auto"></i>
        </div>
        <div class="sup-submenu" id="supSettingsSub">
            <a href="{{ route('settings.users.index') }}" class="sup-subitem">
                <i class="bx bx-group"></i> Users
            </a>
            <a href="{{ route('settings.roles-permissions') }}" class="sup-subitem">
                <i class="bx bx-key"></i> Roles & Permissions
            </a>
        </div>

        {{-- Task List --}}
        <a href="#" class="sup-item">
            <i class="bx bx-credit-card"></i>
            <span>Task List</span>
            <span class="sup-badge ms-auto">4</span>
        </a>

        <div class="sup-divider"></div>

        {{-- Logout --}}
        <form action="{{ route('logout') }}" method="post">
            @csrf
            @method('POST')
            <button type="submit" class="sup-item sup-logout w-100">
                <i class="bx bx-power-off"></i>
                <span>Log Out</span>
            </button>
        </form>
    </div>

    <script>
        (function() {
            const trigger = document.getElementById('sidebarUserTrigger');
            const popup = document.getElementById('sidebarUserPopup');
            const settingsTrigger = document.getElementById('supSettingsTrigger');
            const settingsSub = document.getElementById('supSettingsSub');

            trigger.addEventListener('click', function(e) {
                e.stopPropagation();
                popup.classList.toggle('show');
            });

            settingsTrigger.addEventListener('click', function(e) {
                e.stopPropagation();
                settingsSub.classList.toggle('open');
                this.querySelector('.sup-chevron').style.transform =
                    settingsSub.classList.contains('open') ? 'rotate(90deg)' : 'rotate(0deg)';
            });

            document.addEventListener('click', function() {
                popup.classList.remove('show');
                settingsSub.classList.remove('open');
                if (settingsTrigger.querySelector('.sup-chevron'))
                    settingsTrigger.querySelector('.sup-chevron').style.transform = 'rotate(0deg)';
            });

            popup.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        })();
    </script>
</aside>
