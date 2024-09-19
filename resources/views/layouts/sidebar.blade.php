 <!-- Sidebar Start -->
 <aside class="left-sidebar">
     <!-- Sidebar scroll-->
     <div>
         <div class="brand-logo d-flex align-items-center justify-content-between">
             <a class="text-nowrap logo-img">
                 <img src="{{ asset('../assets/images/kyoraku-baru.png') }}" width="180" alt="" />
             </a>
             <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                 <i class="ti ti-x fs-8"></i>
             </div>
         </div>
         <!-- Sidebar navigation-->
         <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
             <ul id="sidebarnav">
                 @if (Auth::check() && Auth::user()->role == 'admin')
                     <li class="nav-small-cap">
                         <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                         <span class="hide-menu">Home</span>
                     </li>
                     <li class="sidebar-item">
                         <a class="sidebar-link" href="{{ route('dashboard') }}" aria-expanded="false">
                             <span>
                                 <i class="ti ti-layout-dashboard"></i>
                             </span>
                             <span class="hide-menu">Dashboard</span>
                         </a>
                     </li>
                     <li class="nav-small-cap">
                         <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                         <span class="hide-menu">Master Table</span>
                     </li>
                     <li class="sidebar-item">
                         <a class="sidebar-link" href="{{ route('admin.stock.index') }}" aria-expanded="false">
                             <span>
                                 <i class="bi bi-clipboard-data-fill"></i>
                             </span>
                             <span class="hide-menu">Manajemen Stock</span>
                         </a>
                     </li>
                     <li class="nav-small-cap">
                         <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                         <span class="hide-menu">Master</span>
                     </li>
                     <li class="sidebar-item">
                         <a class="sidebar-link" href="{{ route('product.index') }}" aria-expanded="false">
                             <span>
                                 <i class="bi bi-box-seam-fill"></i>
                             </span>
                             <span class="hide-menu">Produksi</span>
                         </a>
                     </li>
                     <li class="sidebar-item">
                         <a class="sidebar-link" href="{{ route('delivery.index') }}" aria-expanded="false">
                             <span>
                                 <i class="bi bi-truck"></i>
                             </span>
                             <span class="hide-menu">Delivery</span>
                         </a>
                     </li>
                     <li class="nav-small-cap">
                         <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                         <span class="hide-menu">AUTH</span>
                     </li>
                     <li class="sidebar-item">
                         <a href="javascript:void(0)" class="sidebar-link" id="logoutButton">
                             <span>
                                 <i class="bi bi-box-arrow-left"></i>
                             </span>
                             <span class="hide-menu">Logout</span>
                         </a>
                     </li>
                 @endif

                 @if (Auth::check() && Auth::user()->role == 'user')
                     <li class="nav-small-cap">
                         <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                         <span class="hide-menu">Master Table</span>
                     </li>
                     <li class="sidebar-item">
                         <a class="sidebar-link" href="{{ route('user.stock.index') }}" aria-expanded="false">
                             <span>
                                 <i class="bi bi-clipboard-data-fill"></i>
                             </span>
                             <span class="hide-menu">Manajemen Stock</span>
                         </a>
                     </li>
                     <li class="nav-small-cap">
                         <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                         <span class="hide-menu">Master</span>
                     </li>
                     <li class="sidebar-item">
                         <a class="sidebar-link" href="{{ route('user.planning.index') }}" aria-expanded="false">
                             <span>
                                 <i class="bi bi-bar-chart-line-fill"></i>
                             </span>
                             <span class="hide-menu">Planning</span>
                         </a>
                     </li>
                     <li class="nav-small-cap">
                         <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                         <span class="hide-menu">AUTH</span>
                     </li>
                     <li class="sidebar-item">
                         <a href="javascript:void(0)" class="sidebar-link" id="logoutButton">
                             <span>
                                 <i class="bi bi-box-arrow-left"></i>
                             </span>
                             <span class="hide-menu">Logout</span>
                         </a>
                     </li>
                 @endif
             </ul>
         </nav>
         <!-- End Sidebar navigation -->
     </div>
     <!-- End Sidebar scroll-->
 </aside>

 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <script>
     document.getElementById('logoutButton').addEventListener('click', function(e) {
         e.preventDefault();
         Swal.fire({
             title: 'Apakah Anda yakin ingin logout?',
             text: "Anda akan keluar dari sesi saat ini.",
             icon: 'warning',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Ya, logout!',
             cancelButtonText: 'Batal'
         }).then((result) => {
             if (result.isConfirmed) {
                 window.location.href = "{{ route('logout') }}"; // Logout action
             }
         });
     });
 </script>
