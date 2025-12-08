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
                                    <i class="bi bi-plus-circle"></i> Add Category
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

                                <!-- Form Start using form_open() -->
                                <?php echo form_open('CategoryController/stores'); ?>

                                <div class="mb-3">
                                    <label for="category_name" class="form-label fw-semibold">Category Name</label>
                                    <input type="text"
                                        class="form-control form-control-lg rounded-3"
                                        id="category_name"
                                        name="category_name"
                                        placeholder="Enter Category Name"
                                        required>
                                </div>

                                <div class="d-grid mt-4">
                                    <button type="submit" class="btn btn-success btn-lg rounded-3">Submit</button>
                                </div>
                                    <?php echo form_close(); ?>
                                    <!-- Form End -->

                                </div>

                            </div>

                        </div>
                    </div>

                </div>

        </main>

        <?php $this->load->view('navigation/footer'); ?>
    </div>

    <?php $this->load->view('footer'); ?>