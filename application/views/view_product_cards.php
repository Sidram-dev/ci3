<?php $this->load->view('header'); ?>

<body class="layout-fixed fixed-header fixed-footer sidebar-expand-lg bg-body-tertiary">

    <div class="app-wrapper">

        <!-- HEADER -->
        <?php $this->load->view('navigation/headernav'); ?>

        <!-- SIDEBAR -->
        <?php $this->load->view('navigation/sidebar'); ?>

        <main class="app-main">

            <div class="app-content">
                <div class="container-fluid mt-4">

                    <!-- PAGE HEADER -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="fw-bold">All Products</h2>
                        <a href="<?= site_url('ProductController/add_product'); ?>" class="btn btn-primary">Add Product</a>
                    </div>

<!-- FILTER DROPDOWN -->
<div class="mb-4">
    <form method="GET" action="<?= site_url('ProductController/view_products'); ?>">
        <label class="fw-bold mb-2">Filter by Category / Subcategory</label>

        <!-- Main Category -->
        <select name="category" class="form-select mb-2" style="max-width:400px;" onchange="this.form.submit()">
            <option value="">-- Select Main Category --</option>
            <?php foreach ($categories as $cat => $subcats): ?>
                <option value="<?= $cat; ?>" <?= ($selected_category == $cat) ? 'selected' : ''; ?>>
                    <?= $cat; ?>
                </option>
            <?php endforeach; ?>
        </select>

        <!-- Subcategory (shows only subcategories of selected main category) -->
        <?php if ($selected_category): ?>
            <select name="subcat" class="form-select" style="max-width:400px;" onchange="this.form.submit()">
                <option value="">-- Select Subcategory --</option>
                <?php foreach ($categories[$selected_category] as $sub): ?>
                    <option value="<?= $sub; ?>" <?= ($selected_subcat == $sub) ? 'selected' : ''; ?>>
                        <?= str_repeat('&nbsp;&nbsp;', 1) . $sub; ?> <!-- Indent subcategory -->
                    </option>
                <?php endforeach; ?>
            </select>
        <?php endif; ?>
    </form>
</div>

                    <!-- PRODUCT CARDS -->
                    <div class="row g-4 justify-content-center">
                        <?php if (!empty($products)): ?>
                            <?php foreach ($products as $product): ?>
                                <div class="col-12 col-md-6 col-lg-4 d-flex align-items-stretch">
                                    <a href="<?= site_url('ProductController/product_details/' . $product->id); ?>" class="text-decoration-none w-100">
                                        <div class="card product-card shadow-sm rounded-4 overflow-hidden h-100">

                                            <!-- IMAGE -->
                                            <?php if ($product->image): ?>
                                                <img src="<?= base_url('assets/upload/' . $product->image); ?>"
                                                    class="card-img-top product-img"
                                                    alt="<?= $product->name; ?>">
                                            <?php else: ?>
                                                <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height:200px;">
                                                    No Image
                                                </div>
                                            <?php endif; ?>

                                            <div class="card-body d-flex flex-column">
                                                <h5 class="card-title fw-bold"><?= $product->name; ?></h5>
                                                <p class="card-text text-muted mb-1"><?= $product->category; ?> / <?= $product->sub_category; ?></p>
                                                <p class="card-text text-success fw-bold mb-2">₹ <?= number_format($product->price, 2); ?></p>
                                                <p class="card-text text-muted mb-3">Stock: <?= $product->stock; ?></p>

                                                <div class="mt-auto">
                                                    <button class="btn btn-outline-primary w-100">View Details</button>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-12 text-center text-muted">
                                No products found.
                            </div>
                        <?php endif; ?>
                    </div>

                </div>

            </div>
            <?php $this->load->view('navigation/footer'); ?>
        </main>
        <?php $this->load->view('footer'); ?>