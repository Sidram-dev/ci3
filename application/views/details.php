<?php $this->load->view('header'); ?>

<body class="layout-fixed fixed-header fixed-footer sidebar-expand-lg bg-body-tertiary">

<div class="app-wrapper">

    <!-- HEADER NAV -->
    <?php $this->load->view('navigation/headernav'); ?>

    <!-- SIDEBAR -->
    <?php $this->load->view('navigation/sidebar'); ?>

    <!-- MAIN CONTENT -->
    <main class="app-main">

        <!-- PAGE TITLE -->
        <div class="app-content-header">
            <div class="container-fluid">
                <h3 class="mb-0">User Details</h3>
            </div>
        </div>

        <!-- PAGE CONTENT -->
        <div class="app-content">
            <div class="container-fluid">

                <div class="card shadow-lg w-75 mx-auto mt-4">

                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">User Information</h4>
                    </div>

                    <div class="card-body">

                        <table class="table table-bordered table-striped mb-0">
                            <tr>
                                <th>ID</th>
                                <td><?= $user->id; ?></td>
                            </tr>

                            <tr>
                                <th>First Name</th>
                                <td><?= $user->first_name; ?></td>
                            </tr>

                            <tr>
                                <th>Last Name</th>
                                <td><?= $user->last_name; ?></td>
                            </tr>

                            <tr>
                                <th>Full Name</th>
                                <td><?= $user->first_name . ' ' . $user->last_name; ?></td>
                            </tr>

                            <tr>
                                <th>Email</th>
                                <td><?= $user->email; ?></td>
                            </tr>

                            <tr>
                                <th>Status</th>
                                <td>
                                    <?php if ($user->status == 1): ?>
                                        <span class="badge bg-success px-3">Active</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger px-3">Inactive</span>
                                    <?php endif; ?>
                                </td>
                            </tr>

                            <tr>
                                <th>Created At</th>
                                <td><?= date('d-m-Y H:i', strtotime($user->created_at)); ?></td>
                            </tr>
                        </table>

                    </div>

                    <div class="card-footer text-end">
                        <a href="<?= site_url('tabels'); ?>" class="btn btn-secondary px-4">Back</a>
                    </div>

                </div>

            </div>
        </div>

    </main>

    <!-- FOOTER -->
    <?php $this->load->view('navigation/footer'); ?>

</div>

</body>

<?php $this->load->view('footer'); ?>
