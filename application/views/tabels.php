<?php
$data['title'] = "Simple Tables | AdminLTE";
$this->load->view('header', $data);
?>

<body class="layout-fixed fixed-header fixed-footer sidebar-expand-lg bg-body-tertiary">

<div class="app-wrapper">

    <!-- HEADER -->
    <?php $this->load->view('navigation/headernav', $data); ?>
    <!-- SIDEBAR -->
    <?php $this->load->view('navigation/sidebar', $data); ?>

    <!-- MAIN CONTENT -->
    <main class="app-main">

        <div class="app-content-header">
            <div class="container-fluid">
                <h3 class="mb-0">Simple Tables</h3>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">

                <div class="card">
                    <div class="card-body table-responsive p-0">

                        <table class="table table-bordered table-striped text-nowrap">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Created at</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                            <?php if (!empty($users)): ?>
                                <?php foreach ($users as $u): ?>

                                    <?php
                                        $logged    = $logged_user;            // logged in user
                                        $isOwner   = ($logged->id == $u->id);
                                        $role      = strtolower($logged->role);
                                    ?>

                                    <tr>
                                        <td><?= html_escape("VV-" . str_pad($u->id, 4, "0", STR_PAD_LEFT)); ?></td>
                                        <td><?= html_escape($u->first_name); ?></td>
                                        <td><?= html_escape($u->last_name); ?></td>
                                        <td><?= html_escape($u->first_name . ' ' . $u->last_name); ?></td>
                                        <td><?= html_escape($u->email); ?></td>
                                        <td><?= html_escape(ucfirst($u->role ?? 'customer')); ?></td>

                                        <td>
                                            <?php if ($u->status == 1): ?>
                                                <span class="badge bg-success">Active</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Inactive</span>
                                            <?php endif; ?>
                                        </td>

                                        <td><?= html_escape(date('d-m-Y H:i', strtotime($u->created_at))); ?></td>

                                        <!-- ACTION COLUMN -->
                                        <td>
                                            <?php if ($role === 'admin'): ?>

                                                <!-- ADMIN HAS FULL ACCESS -->
                                                <a href="<?= site_url('tabels/edit/' . $u->id); ?>" class="btn btn-sm btn-primary">Edit</a>

                                                <a href="<?= site_url('tabels/view/' . $u->id); ?>" class="btn btn-sm btn-info">
                                                    <i class="bi bi-eye"></i>
                                                </a>

                                                <a href="<?= site_url('tabels/delete/' . $u->id); ?>"
                                                   class="btn btn-sm btn-danger"
                                                   onclick="return confirm('Are you sure to delete this user?');">
                                                    Delete
                                                </a>

                                            <?php elseif ($role === 'manager'): ?>

                                                <!-- MANAGER CAN VIEW ALL -->
                                                <a href="<?= site_url('tabels/view/' . $u->id); ?>" class="btn btn-sm btn-info">
                                                    <i class="bi bi-eye"></i>
                                                </a>

                                                <?php if ($isOwner): ?>
                                                    <!-- MANAGER CAN EDIT/DELETE OWN DATA -->
                                                    <a href="<?= site_url('tabels/edit/' . $u->id); ?>" class="btn btn-sm btn-primary">Edit</a>

                                                    <a href="<?= site_url('tabels/delete/' . $u->id); ?>"
                                                       class="btn btn-sm btn-danger"
                                                       onclick="return confirm('Are you sure to delete this user?');">
                                                        Delete
                                                    </a>
                                                <?php endif; ?>

                                            <?php elseif ($role === 'customer'): ?>

                                                <?php if ($isOwner): ?>

                                                    <!-- CUSTOMER CAN VIEW/EDIT/DELETE OWN PROFILE -->
                                                    <a href="<?= site_url('tabels/view/' . $u->id); ?>" class="btn btn-sm btn-info">
                                                        <i class="bi bi-eye"></i>
                                                    </a>

                                                    <a href="<?= site_url('tabels/edit/' . $u->id); ?>" class="btn btn-sm btn-primary">Edit</a>

                                                    <a href="<?= site_url('tabels/delete/' . $u->id); ?>"
                                                       class="btn btn-sm btn-danger"
                                                       onclick="return confirm('Are you sure to delete this user?');">
                                                        Delete
                                                    </a>

                                                <?php else: ?>

                                                    <!-- CUSTOMER NO ACCESS TO OTHERS -->
                                                    <span class="text-muted">No Access</span>

                                                <?php endif; ?>

                                            <?php endif; ?>
                                        </td>

                                    </tr>

                                <?php endforeach; ?>
                            <?php else: ?>

                                <tr>
                                    <td colspan="9" class="text-center">No users found</td>
                                </tr>

                            <?php endif; ?>
                            </tbody>
                        </table>

                        <div class="mt-3">
                            <?= $pagination ?? ''; ?>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </main>

    <?php $this->load->view('navigation/footer'); ?>

</div>

</body>

<?php $this->load->view('footer', $data); ?>
