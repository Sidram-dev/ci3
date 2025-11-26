<?php
// UNIVERSAL CURRENT USER VARIABLE
// This works in ALL views (dashboard, tables, profile, etc.)
$currentUser = null;

if (isset($user)) {
    $currentUser = $user;
} elseif (isset($logged_user)) {
    $currentUser = $logged_user;
}
?>

<nav class="app-header navbar navbar-expand bg-body">
    <div class="container-fluid">

        <!-- Left Nav -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="bi bi-list"></i>
                </a>
            </li>
            <li class="nav-item d-none d-md-block">
                <a href="<?= site_url('dashboard'); ?>" class="nav-link">Home</a>
            </li>
            <li class="nav-item d-none d-md-block">
                <a href="<?= site_url('new_admin'); ?>" class="nav-link">Create-Admin</a>
            </li>
        </ul>

        <!-- Right Nav -->
        <ul class="navbar-nav ms-auto">

            <!-- Search -->
            <li class="nav-item">
                <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                    <i class="bi bi-search"></i>
                </a>
            </li>

            <!-- Messages -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-bs-toggle="dropdown" href="#">
                    <i class="bi bi-chat-text"></i>
                    <span class="navbar-badge badge text-bg-danger">3</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <!-- message items ... unchanged ... -->
                </div>
            </li>

            <!-- Notifications -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-bs-toggle="dropdown" href="#">
                    <i class="bi bi-bell-fill"></i>
                    <span class="navbar-badge badge text-bg-warning">15</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <!-- notification items ... unchanged ... -->
                </div>
            </li>

            <!-- Fullscreen -->
            <li class="nav-item">
                <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                    <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                    <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display:none"></i>
                </a>
            </li>

            <!-- User Dropdown -->
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <img src="<?= base_url('assets/images/profile.jpg'); ?>"
                         class="user-image rounded-circle shadow" alt="User Image">
                    <span class="d-none d-md-inline">
                        <?= $currentUser ? ($currentUser->first_name . ' ' . $currentUser->last_name) : 'Guest User'; ?>
                    </span>
                </a>

                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">

                    <!-- User Header -->
                    <li class="user-header text-bg-primary">
                        <img src="<?= base_url('assets/images/profile.jpg'); ?>"
                             class="rounded-circle shadow" alt="User Image">

                        <p>
                             <?= $currentUser ? ($currentUser->first_name . ' ' . $currentUser->last_name) : 'Guest User'; ?> Web Devoloper
                            <br><small>Member since Nov 2023</small>
                        </p>
                    </li>

                    <!-- Body -->
                    <li class="user-body">
                        <div class="row">
                            <div class="col-4 text-center"><a href="#">Followers</a></div>
                            <div class="col-4 text-center"><a href="#">Sales</a></div>
                            <div class="col-4 text-center"><a href="#">Friends</a></div>
                        </div>
                    </li>

                    <!-- Footer -->
                    <li class="user-footer">
                        <a href="<?= site_url('New_admin/profile'); ?>" class="btn btn-default btn-flat">Profile</a>
                        <a href="<?= site_url('register/logout'); ?>" class="btn btn-default btn-flat float-end">Sign out</a>
                    </li>

                </ul>
            </li>

        </ul>
    </div>
</nav>
