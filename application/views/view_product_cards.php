<style>
    /* CARD STYLING */
    .product-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.25);
    }

    .product-img {
        height: 200px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .product-card:hover .product-img {
        transform: scale(1.05);
    }

    .card-title {
        font-size: 1.1rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .card-body p {
        font-size: 0.9rem;
    }

    /* Make all cards same height */
    .card-body {
        display: flex;
        flex-direction: column;
    }

    /* Remove link underline */
    a.text-decoration-none {
        color: inherit;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .product-img {
            height: 180px;
        }
    }


    .product-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.25);
    }

    .product-img {
        height: 200px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .product-card:hover .product-img {
        transform: scale(1.05);
    }

    .card-title {
        font-size: 1.1rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .card-body p {
        font-size: 0.9rem;
    }

    .card-body {
        display: flex;
        flex-direction: column;
    }

    a.text-decoration-none {
        color: inherit;
    }

    @media (max-width: 768px) {
        .product-img {
            height: 180px;
        }
    }
</style>


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

                    <!-- FILTER DROPDOWNS -->
                    <div class="d-flex gap-2 mb-4">
    <select id="filter_dropdown" class="form-select w-auto">
        <option value="">Select Category/Subcategory</option>
        <?php foreach ($category_options as $cat): ?>
            <option value="<?= $cat['category'] ?>"><?= $cat['category'] ?></option>
            <?php foreach ($cat['subcategories'] as $sub): ?>
                <option value="<?= $sub ?>">-- <?= $sub ?></option>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </select>
    <button id="filter_btn" class="btn btn-primary">Filter</button>
</div>

<div class="row g-4" id="product_cards">
    <?php if (!empty($products)): ?>
        <?php foreach ($products as $product): ?>
            <div class="col-12 col-md-6 col-lg-4 d-flex align-items-stretch">
                <a href="<?= site_url('ProductController/product_details/' . $product->id); ?>" class="text-decoration-none w-100">
                    <div class="card product-card shadow-sm rounded-4 overflow-hidden h-100">
                        <?php if ($product->image): ?>
                            <img src="<?= base_url('assets/upload/' . $product->image); ?>" class="card-img-top product-img" alt="<?= $product->name; ?>">
                        <?php else: ?>
                            <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height:200px;">No Image</div>
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
        <div class="col-12 text-center text-muted">No products found.</div>
    <?php endif; ?>
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



        </main>

        <!-- FOOTER -->
        <?php $this->load->view('footer'); ?>
        <?php $this->load->view('navigation/footer'); ?>

    </div>
</body>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#filter_btn').click(function() {
        let value = $('#filter_dropdown').val();

        $.ajax({
            url: "<?= site_url('ProductController/filter_products'); ?>",
            type: "POST",
            data: { value: value },
            dataType: "json",
            success: function(products) {
                let html = '';

                if(products.length > 0){
                    products.forEach(function(product){
                        html += `<div class="col-12 col-md-6 col-lg-4 d-flex align-items-stretch">
                                    <a href="<?= site_url('ProductController/product_details/'); ?>${product.id}" class="text-decoration-none w-100">
                                        <div class="card product-card shadow-sm rounded-4 overflow-hidden h-100">
                                            ${product.image ? `<img src="<?= base_url('assets/upload/'); ?>${product.image}" class="card-img-top product-img" alt="${product.name}">` 
                                            : `<div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height:200px;">No Image</div>`}
                                            <div class="card-body d-flex flex-column">
                                                <h5 class="card-title fw-bold">${product.name}</h5>
                                                <p class="card-text text-muted mb-1">${product.category} / ${product.sub_category}</p>
                                                <p class="card-text text-success fw-bold mb-2">₹ ${Number(product.price).toFixed(2)}</p>
                                                <p class="card-text text-muted mb-3">Stock: ${product.stock}</p>
                                                <div class="mt-auto">
                                                    <button class="btn btn-outline-primary w-100">View Details</button>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>`;
                    });
                } else {
                    html = '<div class="col-12 text-center text-muted">No products found.</div>';
                }

                $('#product_cards').html(html);
            }
        });
    });
});
</script>


</html>