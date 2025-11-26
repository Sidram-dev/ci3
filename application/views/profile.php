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
                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
                    <?php endif; ?>
                    <?php if ($this->session->flashdata('error')): ?>
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
                            <div id="responseMsg"></div>

                            <form id="profileForm" enctype="multipart/form-data">

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
                                        <th>Role</th>
                                        <td>
                                            <select name="role" class="form-select" required>
                                                <option value="admin" <?= $user->role == 'admin' ? 'selected' : ''; ?>>Admin</option>
                                                <option value="manager" <?= $user->role == 'manager' ? 'selected' : ''; ?>>Manager</option>
                                                <option value="user" <?= $user->role == 'user' ? 'selected' : ''; ?>>Customer</option>
                                            </select>
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

                                    <tr>
                                        <th>Profile Image</th>
                                        <td>
                                            <input type="file" name="profile_image" class="form-control" accept="image/*">
                                            <small class="text-danger">
                                                Allowed formats: gif, jpg, png, jpeg, webp
                                            </small>
                                        </td>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {

            $("#profileForm").on("submit", function(e) {
                e.preventDefault(); // Stop normal form submit

                let formData = new FormData(this);

                $.ajax({
                    url: "<?= site_url('New_admin/update_profile'); ?>",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: "json",

                    beforeSend: function() {
                        $("#responseMsg").html('<div class="alert alert-info">Updating...</div>');
                    },

                    success: function(res) {
                        if (res.status === true) {
                            $("#responseMsg").html('<div class="alert alert-success">' + res.msg + '</div>');

                            // Optional: reload profile image without full page reload
                            setTimeout(() => {
                                $("#responseMsg").fadeOut();
                            }, 3000);

                        } else {
                            $("#responseMsg").html('<div class="alert alert-danger">' + res.msg + '</div>');
                        }
                    },

                    error: function() {
                        $("#responseMsg").html('<div class="alert alert-danger">Something went wrong!</div>');
                    }
                });
            });

        });
    </script>

</body>
<?php $this->load->view('footer'); ?>