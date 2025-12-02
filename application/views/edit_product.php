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
                <div class="container-fluid">
                    <h3 class="fw-bold">Edit Product</h3>
                </div>
            </div>

            <!-- CONTENT AREA -->
            <div class="app-content">
                <div class="container-fluid">

                    <!-- SUCCESS / ERROR -->
                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
                    <?php endif; ?>

                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
                    <?php endif; ?>

                    <!-- CARD -->
                    <div class="card shadow-lg w-75 mx-auto border-0">

                        <div class="card-header bg-warning text-dark py-3">
                            <h4 class="mb-0">Update Product Details</h4>
                        </div>

                        <div class="card-body p-4">

                            <?= form_open_multipart('ProductController/update_product/' . $product->id); ?>

                            <!-- HIDDEN OLD IMAGE -->
                            <input type="hidden" name="old_image" value="<?= $product->image; ?>">

                            <!-- PRODUCT NAME -->
                            <div class="mb-3">
                                <label class="fw-semibold">Product Name</label>
                                <input type="text" name="name" class="form-control shadow-sm"
                                    value="<?= $product->name; ?>" required>
                            </div>

                            <!-- DESCRIPTION -->
                            <div class="mb-3">
                                <label class="fw-semibold">Description</label>
                                <textarea name="description" class="form-control shadow-sm" rows="3"><?= $product->description; ?></textarea>
                            </div>

                            <!-- CATEGORY -->
                            <div class="mb-3">
                                <label class="fw-semibold">Category</label>
                                <select name="category" class="form-select shadow-sm" required>
                                    <option value="">-- Select Category --</option>

                                    <option value="Electronics" <?= ($product->category == "Electronics") ? "selected" : "" ?>>Electronics</option>
                                    <option value="Fashion" <?= ($product->category == "Fashion") ? "selected" : "" ?>>Fashion</option>
                                    <option value="Beauty" <?= ($product->category == "Beauty") ? "selected" : "" ?>>Beauty</option>
                                    <option value="Home Appliances" <?= ($product->category == "Home Appliances") ? "selected" : "" ?>>Home Appliances</option>
                                    <option value="Grocery" <?= ($product->category == "Grocery") ? "selected" : "" ?>>Grocery</option>
                                    <option value="Sports" <?= ($product->category == "Sports") ? "selected" : "" ?>>Sports</option>
                                </select>
                            </div>

                            <!-- SUB CATEGORY -->
                            <div class="mb-3">
                                <label class="fw-semibold">Sub Category</label>
                                <input type="text" name="sub_category" class="form-control shadow-sm"
                                    value="<?= $product->sub_category; ?>">
                            </div>

                            <!-- STOCK -->
                            <div class="mb-3">
                                <label class="fw-semibold">Stock</label>
                                <input type="number" name="stock" class="form-control shadow-sm"
                                    value="<?= $product->stock; ?>" required>
                            </div>

                            <!-- PRICE -->
                            <div class="mb-3">
                                <label class="fw-semibold">Price</label>
                                <input type="text" name="price" class="form-control shadow-sm"
                                    value="<?= $product->price; ?>" required>
                            </div>

                        <!-- IMAGE UPLOAD WITH FILE INPUT AND LIVE PREVIEW -->
<div class="mb-3">
    <label class="fw-semibold">Product Image</label>
    
    <!-- Visible file input -->
    <input type="file" id="imageInput" name="image" class="form-control shadow-sm" accept="image/*">

    <!-- Current / Preview Image -->
    <?php if ($product->image): ?>
        <div class="mt-3">
            <img id="imagePreview" src="<?= base_url('assets/upload/' . $product->image); ?>"
                 class="border rounded shadow-sm" width="200">
        </div>
    <?php else: ?>
        <div class="mt-3">
            <img id="imagePreview" src="<?= base_url('assets/upload/no-image.png'); ?>"
                 class="border rounded shadow-sm" width="200">
        </div>
    <?php endif; ?>
</div>

                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-success px-4">Update</button>
                                <a href="<?= site_url('ProductController/manage_product'); ?>" class="btn btn-secondary px-4">Back</a>
                            </div>

                            <?= form_close(); ?>

                        </div>
                    </div>

                </div>
            </div>

        </main>

        <!-- FOOTER -->
        <?php $this->load->view('navigation/footer'); ?>

    </div>
    <script>
        // When user clicks the image, open the hidden file input
        document.getElementById('imagePreview').addEventListener('click', function() {
            document.getElementById('imageInput').click();
        });

        // When user selects a file, show preview immediately
        document.getElementById('imageInput').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('imagePreview').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>

</html>