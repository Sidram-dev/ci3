<?php $this->load->view('header'); ?>

<body class="layout-fixed fixed-header fixed-footer sidebar-expand-lg bg-body-tertiary">

<div class="app-wrapper">

    <!-- Header -->
    <?php $this->load->view('navigation/headernav'); ?>

    <!-- Sidebar -->
    <?php $this->load->view('navigation/sidebar'); ?>

    <!-- Main Content -->
    <main class="app-main">

        <!-- Page Header -->
        <div class="app-content-header">
            <div class="container-fluid">
                <!-- <h3 class="mb-0">Edit User</h3> -->
            </div>
        </div>

        <!-- Content -->
        <div class="app-content">
            <div class="container-fluid">

                <div class="row justify-content-center">
                    <div class="col-md-8">

                        <div class="card shadow-lg border-0 rounded-4">

                            <div class="card-header bg-primary text-white rounded-top-4 py-3">
                                <h4 class="mb-0">
                                    <i class="bi bi-pencil-square"></i> Update admin
                                </h4>
                            </div>

                            <div class="card-body p-4">

                                <!-- Flash Messages -->
                                <?php if ($this->session->flashdata('error')): ?>
                                    <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
                                <?php endif; ?>

                                <?php if ($this->session->flashdata('success')): ?>
                                    <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
                                <?php endif; ?>

                                <?= form_open('tabels/update/' . $user->id); ?>

                                <div class="row g-4">

                                    <!-- First Name -->
                                    <div class="col-md-6 col-12">
                                        <label class="form-label fw-semibold">First Name</label>
                                        <input type="text"
                                               name="first_name"
                                               class="form-control form-control-lg rounded-3"
                                               value="<?= set_value('first_name', $user->first_name); ?>"
                                               required>
                                    </div>

                                    <!-- Last Name -->
                                    <div class="col-md-6 col-12">
                                        <label class="form-label fw-semibold">Last Name</label>
                                        <input type="text"
                                               name="last_name"
                                               class="form-control form-control-lg rounded-3"
                                               value="<?= set_value('last_name', $user->last_name); ?>"
                                               required>
                                    </div>

                                    <!-- Email -->
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Email (Readonly)</label>
                                        <input type="email"
                                               class="form-control form-control-lg rounded-3"
                                               value="<?= $user->email; ?>"
                                               readonly>
                                    </div>

                                    <!-- Status -->
                                    <div class="col-md-6 col-12">
                                        <label class="form-label fw-semibold">Status</label>
                                        <select name="status"
                                                class="form-select form-select-lg rounded-3">
                                            <option value="1" <?= ($user->status == 1) ? 'selected' : ''; ?>>Active</option>
                                            <option value="0" <?= ($user->status == 0) ? 'selected' : ''; ?>>Inactive</option>
                                        </select>
                                    </div>

                                </div>

                                <!-- Buttons -->
                                <div class="mt-5 d-flex justify-content-between">
                                    <a href="<?= site_url('tabels'); ?>"
                                       class="btn btn-secondary btn-lg px-4 rounded-3">
                                        Cancel
                                    </a>

                                    <button type="submit"
                                            class="btn btn-success btn-lg px-4 rounded-3">
                                        Update admin
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
