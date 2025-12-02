<?php $this->load->view('header'); ?>

<body class="layout-fixed fixed-header fixed-footer sidebar-expand-lg bg-body-tertiary">

<div class="app-wrapper">

    <!-- HEADER -->
    <?php $this->load->view('navigation/headernav'); ?>

    <!-- SIDEBAR -->
    <?php $this->load->view('navigation/sidebar'); ?>

    <main class="app-main">

        <!-- PAGE HEADER -->
        <div class="app-content-header">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <h3 class="fw-bold">Manage Products</h3>
                <a href="<?= site_url('ProductController/add_product'); ?>" class="btn btn-primary px-4">+ Add New Product</a>
            </div>
        </div>

        <!-- PAGE CONTENT -->
        <div class="app-content">
            <div class="container-fluid">

                <!-- SUCCESS / ERROR MESSAGES -->
                <?php if($this->session->flashdata('success')): ?>
                    <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
                <?php endif; ?>

                <?php if($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
                <?php endif; ?>

                <!-- PRODUCT LIST CARD -->
                <div class="card shadow-lg border-0 rounded-3">
                    
                    <div class="card-header bg-primary text-white py-3">
                        <h4 class="mb-0">Product List</h4>
                    </div>

                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Sub-Category</th>
                                        <th>Stock</th>
                                        <th>Price</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($products as $product): ?>
                                    <tr>
                                        <td><?= $product->id; ?></td>

                                        <td>
                                            <?php if($product->image): ?>
                                                <img src="<?= base_url('assets/upload/'.$product->image); ?>" 
                                                     class="rounded shadow-sm" width="60">
                                            <?php else: ?>
                                                <span class="text-muted">No Image</span>
                                            <?php endif; ?>
                                        </td>

                                        <td><?= $product->name; ?></td>
                                        <td><?= $product->category; ?></td>
                                        <td><?= $product->sub_category; ?></td>
                                        <td><span class="badge bg-info"><?= $product->stock; ?></span></td>
                                        <td><strong>₹<?= $product->price; ?></strong></td>

                                        <td class="text-center">
                                            <a href="<?= site_url('edit_product/'.$product->id); ?>" 
                                               class="btn btn-sm btn-warning px-3">Edit</a>

                                            <a href="<?= site_url('ProductController/delete_product/'.$product->id); ?>" 
                                               class="btn btn-sm btn-danger px-3"
                                               onclick="return confirm('Are you sure you want to delete this product?')">
                                               Delete
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>

                <div class="mt-3">
                    <a href="<?= site_url('ProductController/add_product'); ?>" class="btn btn-secondary px-4">
                        Back to Add Product
                    </a>
                </div>

            </div>
        </div>

    </main>
      <?php $this->load->view('footer'); ?>

    <!-- FOOTER -->
    <?php $this->load->view('navigation/footer'); ?>

</div>

</body>
</html>
