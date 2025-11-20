<?php $this->load->view('header'); ?>

<body class="layout-fixed fixed-header fixed-footer sidebar-expand-lg bg-body-tertiary">
<div class="app-wrapper">

    <!-- HEADER NAV -->
    <?php $this->load->view('navigation/headernav'); ?>

    <!-- SIDEBAR -->
    <?php $this->load->view('navigation/sidebar'); ?>

    <main class="app-main">

        <!-- PAGE HEADER -->
        <div class="app-content-header">
            <div class="container-fluid">
                <h3 class="mb-0">Edit User Profile</h3>
            </div>
        </div>

        <!-- PAGE CONTENT -->
        <div class="app-content">
            <div class="container-fluid">

                <!-- FORM OPEN -->
                <?= form_open("new_admin/update/" . $user->id); ?>

                <!-- CSRF -->
                <input type="hidden"
                       name="<?= $this->security->get_csrf_token_name(); ?>"
                       value="<?= $this->security->get_csrf_hash(); ?>">

                <div class="card shadow-lg w-75 mx-auto mt-4">

                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Edit User</h4>
                    </div>

                    <div class="card-body">

                        <div class="mb-3">
                            <label class="form-label fw-bold">Full Name</label>
                            <input type="text" name="full_name" class="form-control"
                                   value="<?= $user->full_name ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">First Name</label>
                            <input type="text" name="first_name" class="form-control"
                                   value="<?= $user->first_name ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Last Name</label>
                            <input type="text" name="last_name" class="form-control"
                                   value="<?= $user->last_name ?>">
                        </div>

                    <div class="mb-3">
    <label class="form-label fw-bold">Email (Cannot be edited)</label>

    <!-- Readonly visible input -->
    <input type="email" class="form-control" value="<?= $user->email ?>" readonly>

    <!-- Hidden actual input (submitted to controller) -->
    <input type="hidden" name="email" value="<?= $user->email ?>">
</div>


                        <div class="mb-3">
                            <label class="form-label fw-bold">Status</label>
                            <select name="status" class="form-control">
                                <option value="1" <?= $user->status == 1 ? 'selected' : '' ?>>Active</option>
                                <option value="0" <?= $user->status == 0 ? 'selected' : '' ?>>Inactive</option>
                            </select>
                        </div>

                    </div>

                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-success px-4">Save</button>
                        <a href="<?= site_url('new_admin/profile'); ?>" class="btn btn-secondary px-4">Cancel</a>
                    </div>

                </div>

                <?= form_close(); ?>

            </div>
        </div>

    </main>

    <!-- FOOTER -->
    <?php $this->load->view('navigation/footer'); ?>

</div>
</body>

<?php $this->load->view('footer'); ?>
