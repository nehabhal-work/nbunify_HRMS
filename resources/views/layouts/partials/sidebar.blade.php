 <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme"
     style="background-color: rgb(229, 206, 242)!important;">
     <div class="app-brand demo" style="height: 100px;">
         <a href="index.html" class="app-brand-link">
             <span class="app-brand-logo demo">
                 <img src="{{ asset('assets/img/branding/logo.png') }}" alt="" width="200">
         </a>

         <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
             <i class="bx bx-chevron-left bx-sm align-middle"></i>
         </a>
     </div>

     <div class="menu-inner-shadow"></div>

     <ul class="menu-inner py-1">
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

                 <li class="menu-item {{ request()->routeIs('master.branches.*') ? 'active' : '' }}">
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



                 {{-- <li class="menu-item {{ request()->routeIs('master.employees.*') ? 'active' : '' }}">
                     <a href="{{ route('master.employees.index') }}" class="menu-link">
                         <i class="menu-icon bx bx-group"></i>
                         <div class="text-truncate">Employees</div>
                     </a>
                 </li> --}}

                 {{--  <li class="menu-item {{ request()->routeIs('master.cp.*') ? 'active' : '' }}">
                     <a href="{{ route('master.cp.index') }}" class="menu-link">
                         <i class="menu-icon bx bx-id-card"></i>
                         <div class="text-truncate">CP</div>
                     </a>
                 </li>

                 <li class="menu-item {{ request()->routeIs('master.customers.*') ? 'active' : '' }}">
                     <a href="{{ route('master.customers.index') }}" class="menu-link">
                         <i class="menu-icon bx bx-user"></i>
                         <div class="text-truncate">Customers</div>
                     </a>
                 </li>

                

                 

                 <li class="menu-item {{ request()->routeIs('master.references.*') ? 'active' : '' }}">
                     <a href="{{ route('master.references.index') }}" class="menu-link">
                         <i class="menu-icon bx bx-bookmark"></i>
                         <div class="text-truncate">References</div>
                     </a>
                 </li> --}}

             </ul>
         </li>
     </ul>
     <ul class="menu-inner py-1">
         {{-- <li class="menu-item {{ request()->routeIs('content.master.employees.*') ? 'active' : '' }}">
             <a href="{{ route('content.master.employees.index') }}" class="menu-link">
                 <i class="menu-icon bx bx-group"></i>
                 <div class="text-truncate">Employees</div>
             </a>
         </li> --}}
         <li class="menu-item {{ request()->routeIs('master.content.employees.*') ? 'active' : '' }}">
             <a href="{{ route('content.master.employees.index') }}" class="menu-link">
                 <div>Employee Module</div>
             </a>
         </li>


     </ul>


 </aside>
