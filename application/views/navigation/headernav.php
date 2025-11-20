<nav class="app-header navbar navbar-expand bg-body">
    <div class="container-fluid">

        <!-- LEFT NAV -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="bi bi-list"></i>
                </a>
            </li>
            <li class="nav-item d-none d-md-block">
                <a href="#" class="nav-link">Home</a>
            </li>
            <li class="nav-item d-none d-md-block">
                <a href="#" class="nav-link">Contact</a>
            </li>
        </ul>

        <!-- RIGHT NAV -->
        <ul class="navbar-nav ms-auto">

            <!-- SEARCH -->
            <li class="nav-item">
                <a class="nav-link" data-widget="navbar-search" href="#">
                    <i class="bi bi-search"></i>
                </a>
            </li>

            <!-- MESSAGES DROPDOWN -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-lte-toggle="dropdown" href="#">
                    <i class="bi bi-envelope"></i>
                    <span class="navbar-badge badge bg-danger">3</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <li class="dropdown-item">No new messages</li>
                </ul>
            </li>

            <!-- NOTIFICATIONS DROPDOWN -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-lte-toggle="dropdown" href="#">
                    <i class="bi bi-bell"></i>
                    <span class="navbar-badge badge bg-warning">5</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <li class="dropdown-item">No new notifications</li>
                </ul>
            </li>

            <!-- FULLSCREEN -->
            <li class="nav-item">
              <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                    <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                    <i data-lte-icon="minimize" class="bi bi-fullscreen-exit d-none"></i>
                </a>
            </li>

            <!-- USER MENU DROPDOWN -->
            <li class="nav-item dropdown user-menu">
             <a href="#" class="nav-link" data-lte-toggle="dropdown">
                    <img src="<?= base_url('assets/images/profile.jpg'); ?>"
                         class="user-image rounded-circle shadow" alt="User Image">
                    <span class="d-none d-md-inline">
                        <?= isset($user) ? $user->full_name : 'Guest User'; ?>
                    </span>
                </a>

                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <li class="user-header text-bg-primary">
                        <img src="<?= base_url('assets/images/profile.jpg'); ?>"
                             class="rounded-circle shadow" alt="User Image">
                        <p>
                            <?= $user->full_name ?> - Web Developer
                            <small>Member since Nov 2023</small>
                        </p>
                    </li>

                    <li class="user-body">
                        <div class="row">
                            <div class="col-4 text-center"><a href="#">Followers</a></div>
                            <div class="col-4 text-center"><a href="#">Sales</a></div>
                            <div class="col-4 text-center"><a href="#">Friends</a></div>
                        </div>
                    </li>

                    <li class="user-footer">
                        <a href="<?= site_url('contacts'); ?>" class="btn btn-default btn-flat">Profile</a>
                        <a href="#" class="btn btn-default btn-flat float-end">Sign out</a>
                    </li>
                </ul>
            </li>

        </ul>

    </div>
</nav>


