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
                <h3 class="mb-0">My Profile</h3>
            </div>
        </div>

        <!-- PAGE CONTENT -->
        <div class="app-content">
            <div class="container-fluid">

                <!-- FLASH MESSAGES -->
                <?php if($this->session->flashdata('success')): ?>
                    <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
                <?php endif; ?>
                <?php if($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
                <?php endif; ?>

                <!-- FORM VALIDATION ERRORS -->
                <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>

                <!-- PROFILE CARD -->
                <div class="card shadow-lg w-75 mx-auto mt-4">

                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Edit Profile</h4>
                    </div>

                    <div class="card-body">

                        <form method="post" action="<?= site_url('New_admin/update_profile'); ?>">

                            <!-- CSRF Token -->
                            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" 
                                   value="<?= $this->security->get_csrf_hash(); ?>">

                            <table class="table table-bordered table-striped mb-0">

                                <tr>
                                    <th>ID</th>
                                    <td><?= $user->id; ?></td>
                                </tr>

                                <tr>
                                    <th>First Name</th>
                                    <td>
                                        <input type="text" name="first_name" class="form-control" 
                                               value="<?= html_escape($user->first_name); ?>" required>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Last Name</th>
                                    <td>
                                        <input type="text" name="last_name" class="form-control" 
                                               value="<?= html_escape($user->last_name); ?>" required>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Full Name</th>
                                    <td><?= html_escape($user->first_name . ' ' . $user->last_name); ?></td>
                                </tr>

                                <tr>
                                    <th>Email</th>
                                    <td>
                                        <input type="email" class="form-control" 
                                               value="<?= html_escape($user->email); ?>" readonly>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <select name="status" class="form-select">
                                            <option value="1" <?= $user->status == 1 ? 'selected' : ''; ?>>Active</option>
                                            <option value="0" <?= $user->status == 0 ? 'selected' : ''; ?>>Inactive</option>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Created At</th>
                                    <td><?= date('d-m-Y H:i', strtotime($user->created_at)); ?></td>
                                </tr>

                            </table>

                            <div class="text-end mt-3">
                                <a href="<?= site_url('tabels'); ?>" class="btn btn-secondary px-4">Back</a>
                                <button type="submit" class="btn btn-primary px-4">Update Profile</button>
                            </div>

                        </form>

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
