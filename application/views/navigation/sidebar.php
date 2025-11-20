<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark" data-lte-breakpoint="lg">
    <div class="sidebar-brand">
        <a href="<?= site_url('dashboard'); ?>" class="brand-link">
            <img src="<?= base_url('assets/images/logo.png'); ?>" alt="AdminLTE Logo" class="brand-image opacity-75 shadow" />
            <span class="brand-text fw-light">AdminLTE 4</span>
        </a>
    </div>

    <div class="sidebar-wrapper">
        <nav class="mt-2">
        <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview">

                
                <li class="nav-item">
                    <a href="<?= site_url('dashboard'); ?>" class="nav-link">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item menu-open">
                   <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                        <i class="nav-icon bi bi-table"></i>
                        <p>
                            Tables
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= site_url('tabels'); ?>" class="nav-link active">
                                <p>Admins Table</p>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </nav>
    </div>
</aside>
