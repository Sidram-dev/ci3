<?php $this->load->view('header'); ?>

<body class="layout-fixed fixed-header fixed-footer sidebar-expand-lg bg-body-tertiary">

    <div class="app-wrapper">

        <?php $this->load->view('navigation/headernav'); ?>
        <?php $this->load->view('navigation/sidebar'); ?>

        <main class="app-main">

            <div class="app-content p-4">

                <div class="row justify-content-center">
                    <div class="col-md-6">

                        <div class="card shadow-lg border-0 rounded-4">

                            <div class="card-header bg-primary text-white rounded-top-4 py-3">
                                <h4 class="mb-0">
                                    <i class="bi bi-plus-circle"></i> Add Sub Category
                                </h4>
                            </div>
                            <div class="card-body p-4">
                                <!-- Flash messages -->
                                <?php if ($this->session->flashdata('success')): ?>
                                    <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
                                <?php endif; ?>
                                <?php if ($this->session->flashdata('error')): ?>
                                    <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
                                <?php endif; ?>

                                <!-- FORM START -->
                                <?php echo form_open('categorycontroller/store_sub_category'); ?>

                                <!-- Category Dropdown (Moved First) -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Select Category</label>

                                    <select class="form-control form-control-lg rounded-3" name="category_id" required>
                                        <option value="">-- Select Category --</option>

                                        <?php foreach ($categories as $cat): ?>
                                            <option value="<?= $cat->category_id; ?>">
                                                <?= $cat->category_name; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <!-- Sub Category Name (Moved Below) -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Sub Category Name</label>
                                    <input type="text"
                                        class="form-control form-control-lg rounded-3"
                                        name="sub_category_name"
                                        placeholder="Enter Sub Category Name"
                                        required>
                                </div>

                                <!-- Buttons -->
                                <div class="d-flex justify-content-between mt-4">
                                    <a href="<?= base_url('category_list'); ?>"
                                        class="btn btn-secondary btn-lg rounded-3">
                                        Cancel
                                    </a>

                                    <button type="submit"
                                        class="btn btn-success btn-lg rounded-3">
                                        Submit
                                    </button>
                                </div>

                                <?php echo form_close(); ?>

                            </div>

                        </div>

                    </div>
                </div>

            </div>

        </main>

        <?php $this->load->view('navigation/footer'); ?>
    </div>

    <?php $this->load->view('footer'); ?>