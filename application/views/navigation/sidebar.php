   <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
     <!--begin::Sidebar Brand-->
     <div class="sidebar-brand">
       <!--begin::Brand Link-->
       <a href="<?= site_url('dashboard'); ?>" class="brand-link">
         <!--begin::Brand Image-->
         <img src="<?= base_url('assets/images/logo.png'); ?>" alt="AdminLTE Logo" class="brand-image opacity-75 shadow" />

         <!--end::Brand Image-->
         <!--begin::Brand Text-->
         <span class="brand-text fw-light">AdminLTE 4</span>
         <!--end::Brand Text-->
       </a>
       <!--end::Brand Link-->
     </div>
     <!--end::Sidebar Brand-->
     <!--begin::Sidebar Wrapper-->
     <div class="sidebar-wrapper">
       <nav class="mt-2">
         <!--begin::Sidebar Menu-->
         <ul
           class="nav sidebar-menu flex-column"
           data-lte-toggle="treeview"
           role="navigation"
           aria-label="Main navigation"
           data-accordion="false"
           id="navigation">
           <li class="nav-item menu-open">
             <a href="#" class="nav-link active">
               <i class="nav-icon bi bi-speedometer"></i>
               <p>
                 Dashboard
                 <i class="nav-arrow bi bi-chevron-right"></i>
               </p>
             </a>
             <ul class="nav nav-treeview">
               <li class="nav-item">
                 <a href="<?= site_url('dashboard_v1'); ?>" class="nav-link active">
                   <i class="nav-icon bi bi-circle"></i>
                   <p>Dashboard v1</p>
                 </a>
               </li>
             </ul>
           </li>
           <li class="nav-item">
             <a href="#" class="nav-link">
               <i class="nav-icon bi bi-table"></i>
               <p>
                 Tables
                 <i class="nav-arrow bi bi-chevron-right"></i>
               </p>
             </a>
             <ul class="nav nav-treeview">
               <li class="nav-item">
                 <a href="<?= site_url('tabels'); ?>" class="nav-link active">
                   <i class="nav-icon bi bi-circle"></i>
                   <p>Users Tables</p>
                 </a>
               </li>
               <li class="nav-item">
                 <a href="<?= site_url('api_user'); ?>" class="nav-link active">
                   <i class="nav-icon bi bi-circle"></i>
                   <p>API Tables</p>
                 </a>

               </li>
             </ul>
           </li>
           <li class="nav-item menu-open">
             <a href="#" class="nav-link active">
               <i class="nav-icon bi bi-speedometer"></i>
               <p>
                 Product Categories
                 <i class="nav-arrow bi bi-chevron-right"></i>
               </p>
             </a>
             <ul class="nav nav-treeview">
               <li class="nav-item">
                <a href="<?= site_url('add_category'); ?>" class="nav-link">
               <i class="bi bi-plus-circle me-2"></i> 
               <p>Add Category</p>
             </a>
               </li>
               <li class="nav-item">
                 <a href="<?= site_url('sub_categories'); ?>" class="nav-link">
                   <i class="bi bi-plus-circle me-2"></i> 
                   <p>Add Sub Categories</p>
                 </a>
               </li>

                  <li class="nav-item">
             <a href="<?= site_url('add_products'); ?>" class="nav-link">
               <i class="bi bi-plus-circle me-2"></i> 
               <p>Add Product</p>
             </a>
           </li>
              
               </li>
             </ul>
           </li>
         </ul>
         <!--end::Sidebar Menu-->
       </nav>
     </div>
     <!--end::Sidebar Wrapper-->
   </aside>