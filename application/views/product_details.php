<?php $this->load->view('header'); ?>

<body class="layout-fixed fixed-header fixed-footer sidebar-expand-lg bg-body-tertiary">

<div class="app-wrapper">
<?php $this->load->view('navigation/headernav', ['logged_user' => $logged_user]); ?>
    <?php $this->load->view('navigation/sidebar'); ?>

    <main class="app-main">

        <div class="app-content">
            <div class="container-fluid mt-4">

                <a href="<?= site_url('ProductController/view_products'); ?>" class="btn btn-secondary mb-3">
                    ← Back to Products
                </a>

                <div class="card shadow-lg border-0 rounded-3">
                    <div class="row g-0">
                        
                        <div class="col-md-4">
                            <?php if($product->image): ?>
                                <img src="<?= base_url('assets/upload/'.$product->image); ?>" 
                                     class="img-fluid rounded-start w-100" 
                                     style="object-fit:cover; height:100%;">
                            <?php else: ?>
                                <div class="bg-secondary text-white text-center d-flex justify-content-center align-items-center" 
                                     style="height:100%; min-height:300px;">
                                    No Image
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-8">
                            <div class="card-body p-4">
                                <h2 class="card-title fw-bold"><?= $product->name; ?></h2>

                                <p class="text-muted mb-2">
                                    <strong>Category:</strong> <?= $product->category_name; ?> / <?= $product->sub_category_name; ?>

                                </p>

                                <p class="text-success fw-bold fs-4 mb-3">
                                    ₹ <?= number_format($product->price, 2); ?>
                                </p>

                                <p class="mb-3">
                                    <strong>Description:</strong><br>
                                    <?= $product->description ? $product->description : "No description available"; ?>
                                </p>

                                <p class="mb-4">
                                    <strong>Stock:</strong> <?= $product->stock; ?>
                                </p>

                                <div class="mt-3">
                                    <a href="<?= site_url('ProductController/edit_product/'.$product->id); ?>" 
                                       class="btn btn-warning px-4">Edit Product</a>
                                    <a href="<?= site_url('ProductController/delete_product/'.$product->id); ?>" 
                                       onclick="return confirm('Are you sure?')" 
                                       class="btn btn-danger px-4">Delete</a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </main>
        <?php $this->load->view('footer'); ?>

    <?php $this->load->view('navigation/footer'); ?>
</div>

</body>
</html>
