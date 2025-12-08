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
                 <li class="menu-item {{ request()->routeIs('master.employees.*') ? 'active' : '' }}">
                     <a href="{{ route('master.employees.index') }}" class="menu-link">
                         <i class="menu-icon bx bx-group"></i>
                         <div class="text-truncate">Employees</div>
                     </a>
                 </li>





             </ul>
         </li>

         <li class="menu-item {{ request()->routeIs('client*') ? 'active' : '' }}">
             <a href="{{ route('master.clients.index') }}" class="menu-link">
                 <i class="menu-icon bx bx-id-card"></i>
                 <div class="text-truncate">Client</div>
             </a>
         </li>
       <li class="menu-item {{ request()->routeIs('birthday-client') ? 'active' : '' }}">
    <a href="{{ route('birthday-client') }}" class="menu-link">
        <i class="menu-icon bx bx-id-card"></i>
        <div class="text-truncate">B'day List</div>
    </a>
</li>


         {{-- accounts --}}
         <li class="menu-item {{ request()->is('accounts/*') ? 'active open' : '' }}">
             <a href="javascript:void(0);" class="menu-link menu-toggle">
                 <i class="menu-icon tf-icons bx bx-wallet"></i>
                 <div class="text-truncate" data-i18n="Account">Account</div>
             </a>

             <ul class="menu-sub">
                 <!-- Vendors -->
                 <li class="menu-item {{ request()->routeIs('accounts.vendors.*') ? 'active' : '' }}">
                     <a href="{{ route('accounts.vendors.index') }}" class="menu-link">
                         <i class="menu-icon bx bx-store-alt"></i>
                         <div class="text-truncate">Vendors</div>
                     </a>
                 </li>

                 <!-- Purchase -->
                 <li class="menu-item {{ request()->routeIs('accounts.purchases.*') ? 'active' : '' }}">
                     <a href="{{ route('accounts.purchases.index') }}" class="menu-link">
                         <i class="menu-icon bx bx-cart"></i>
                         <div class="text-truncate">Purchase</div>
                     </a>
                 </li>

                 <!-- Sales -->
                 <li class="menu-item {{ request()->routeIs('accounts.sales.*') ? 'active' : '' }}">
                     <a href="{{ route('accounts.sales.index') }}" class="menu-link">
                         <i class="menu-icon bx bx-trending-up"></i>
                         <div class="text-truncate">Sales</div>
                     </a>
                 </li>

                 <!-- Purchase Order -->
                 <li class="menu-item {{ request()->routeIs('accounts.purchase-orders.*') ? 'active' : '' }}">
                     <a href="{{ route('accounts.purchase-orders.index') }}" class="menu-link">
                         <i class="menu-icon bx bx-receipt"></i>
                         <div class="text-truncate">Purchase Order</div>
                     </a>
                 </li>

                 <!-- Expense Voucher -->
                 <li class="menu-item {{ request()->routeIs('accounts.expenses.*') ? 'active' : '' }}">
                     <a href="{{ route('accounts.expenses.index') }}" class="menu-link">
                         <i class="menu-icon bx bx-money"></i>
                         <div class="text-truncate">Expense Voucher</div>
                     </a>
                 </li>

                 <!-- Ledger -->
                 <li class="menu-item {{ request()->routeIs('accounts.ledger.*') ? 'active' : '' }}">
                     <a href="{{ route('accounts.ledger.index') }}" class="menu-link">
                         <i class="menu-icon bx bx-book-content"></i>
                         <div class="text-truncate">Ledger</div>
                     </a>
                 </li>
             </ul>
         </li>


         {{-- Investment --}}
         <li class="menu-item {{ request()->is('investment/*') ? 'active open' : '' }}">
             <a href="javascript:void(0);" class="menu-link menu-toggle">
                 <i class="menu-icon tf-icons bx bx-line-chart"></i>
                 <div class="text-truncate" data-i18n="Investment">Investment</div>
             </a>

             <ul class="menu-sub">
                 <!-- Master-Scheme -->
                 <li class="menu-item {{ request()->routeIs('investment.scheme.*') ? 'active' : '' }}">
                     <a href="{{ route('investment.scheme.index') }}" class="menu-link">
                         <i class="menu-icon bx bx-layer"></i>
                         <div class="text-truncate">Master-Scheme</div>
                     </a>
                 </li>

                 <!-- ELS Investment -->
                 <li class="menu-item {{ request()->routeIs('investment.els.*') ? 'active' : '' }}">
                     <a href="{{ route('investment.els.index') }}" class="menu-link">
                         <i class="menu-icon bx bx-wallet"></i>
                         <div class="text-truncate">ELS Investment</div>
                     </a>
                 </li>

                 <!-- Sales -->
                 {{-- <li class="menu-item {{ request()->routeIs('accounts.sales.*') ? 'active' : '' }}">
                     <a href="{{ route('accounts.sales.index') }}" class="menu-link">
                         <i class="menu-icon bx bx-trending-up"></i>
                         <div class="text-truncate">ELS Payout</div>
                     </a>
                 </li> --}}

                 <!-- Purchase Order -->
                 {{-- <li class="menu-item {{ request()->routeIs('accounts.purchase-orders.*') ? 'active' : '' }}">
                     <a href="{{ route('accounts.purchase-orders.index') }}" class="menu-link">
                         <i class="menu-icon bx bx-receipt"></i>
                         <div class="text-truncate">Payout dues</div>
                     </a>
                 </li> --}}



                 <!-- Ledger -->
                 {{-- <li class="menu-item {{ request()->routeIs('accounts.ledger.*') ? 'active' : '' }}">
                     <a href="{{ route('accounts.ledger.index') }}" class="menu-link">
                         <i class="menu-icon bx bx-book-content"></i>
                         <div class="text-truncate">Ledger Report</div>
                     </a>
                 </li> --}}
             </ul>
         </li>



     </ul>



 </aside>
