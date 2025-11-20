<?php $this->load->view('header'); ?>

<body class="layout-fixed fixed-header fixed-footer sidebar-expand-lg bg-body-tertiary">
<div class="app-wrapper">

    <!-- HEADER -->
    <?php $this->load->view('navigation/headernav'); ?>

    <!-- SIDEBAR -->
    <?php $this->load->view('navigation/sidebar'); ?>

    <!-- MAIN CONTENT -->
    <main class="app-main">

        <!-- PAGE HEADING -->
        <div class="app-content-header">
            <div class="container-fluid">
                <!-- <h3 class="mb-0">Create New Admin</h3> -->
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">

                <div class="row justify-content-center">
                    <div class="col-md-8">

                        <div class="card shadow-lg border-0 rounded-4">

                            <div class="card-header bg-primary text-white rounded-top-4">
                                <h4 class="mb-0"><i class="bi bi-person-plus"></i> New Admin</h4>
                            </div>

                            <div class="card-body p-4">

                                <?php if ($this->session->flashdata('error')): ?>
                                    <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
                                <?php endif; ?>

                                <?php if ($this->session->flashdata('success')): ?>
                                    <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
                                <?php endif; ?>

                                <?= form_open('new_admin/save'); ?>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Full Name</label>
                                    <input type="text" name="full_name" class="form-control form-control-lg"
                                           placeholder="Enter full name" required>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">First Name</label>
                                        <input type="text" name="first_name" class="form-control form-control-lg"
                                               placeholder="Enter first name" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">Last Name</label>
                                        <input type="text" name="last_name" class="form-control form-control-lg"
                                               placeholder="Enter last name" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Email</label>
                                    <input type="email" name="email" class="form-control form-control-lg"
                                           placeholder="Enter email address" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Password</label>
                                    <input type="password" name="password" class="form-control form-control-lg"
                                           placeholder="Enter password" required>
                                </div>

                                <div class="d-flex justify-content-between mt-4">
                                    <a href="<?= site_url('tabels'); ?>" class="btn btn-light border px-4 py-2">
                                        <i class="bi bi-arrow-left"></i> Back
                                    </a>
                                    <button class="btn btn-success px-5 py-2 fw-bold">
                                        <i class="bi bi-save"></i> Create Admin
                                    </button>
                                </div>

                                </form>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </main>
 <?php $this->load->view('navigation/footer'); ?>
</div>

<?php $this->load->view('footer'); ?>
