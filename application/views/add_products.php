<?php $this->load->view('header'); ?>

<body class="layout-fixed fixed-header fixed-footer sidebar-expand-lg bg-body-tertiary">

<div class="app-wrapper">

    <!-- HEADER -->
    <?php $this->load->view('navigation/headernav', ['logged_user' => $logged_user]); ?>

    <!-- SIDEBAR -->
    <?php $this->load->view('navigation/sidebar'); ?>

    <main class="app-main">

        <div class="app-content-header">
            <div class="container-fluid">
                <h3 class="fw-bold">Add Product</h3>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">

                <!-- ALERT MESSAGES -->
                <div id="alert-message"></div>

                <!-- CARD -->
                <div class="card shadow-lg w-75 mx-auto mt-4 border-0">

                    <div class="card-header bg-primary text-white py-3">
                        <h4 class="mb-0">Product Details</h4>
                    </div>

                    <div class="card-body p-4">

                        <?= form_open_multipart('ProductController/save_product', ['id' => 'productForm']); ?>

                        <div class="mb-3">
                            <label>Product Name</label>
                            <input type="text" name="name" class="form-control shadow-sm" value="<?= set_value('name'); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label>Description</label>
                            <textarea name="description" class="form-control shadow-sm"><?= set_value('description'); ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label>Category</label>
                            <select name="category" class="form-select shadow-sm" required>
                                <option value="">-- Select Category --</option>
                                <option value="Electronics" <?= set_value('category') == 'Electronics' ? 'selected' : ''; ?>>Electronics</option>
                                <option value="Fashion" <?= set_value('category') == 'Fashion' ? 'selected' : ''; ?>>Fashion</option>
                                <option value="Groceries" <?= set_value('category') == 'Groceries' ? 'selected' : ''; ?>>Groceries</option>
                                <option value="Home & Kitchen" <?= set_value('category') == 'Home & Kitchen' ? 'selected' : ''; ?>>Home & Kitchen</option>
                                <option value="Beauty" <?= set_value('category') == 'Beauty' ? 'selected' : ''; ?>>Beauty</option>
                                <option value="Sports" <?= set_value('category') == 'Sports' ? 'selected' : ''; ?>>Sports</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Sub-Category</label>
                            <input type="text" name="sub_category" class="form-control shadow-sm" value="<?= set_value('sub_category'); ?>">
                        </div>

                        <div class="mb-3">
                            <label>Stock</label>
                            <input type="number" name="stock" class="form-control shadow-sm" value="<?= set_value('stock'); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label>Price</label>
                            <input type="text" name="price" class="form-control shadow-sm" value="<?= set_value('price'); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label>Image</label>
                            <input type="file" name="image" class="form-control shadow-sm">
                        </div>

                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-success px-4">Add Product</button>
                            <a href="<?= site_url('ProductController/manage_product'); ?>" class="btn btn-warning px-4">Manage Products</a>
                            <a href="<?= site_url('ProductController/view_products'); ?>" class="btn btn-info px-4">View Products</a>
                        </div>

                        <?= form_close(); ?>

                    </div>
                </div>
            </div>
        </div>

    </main>

    <?php $this->load->view('footer'); ?>
    <?php $this->load->view('navigation/footer'); ?>

</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {

    $('#productForm').on('submit', function(e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            beforeSend: function() {
                $('#alert-message').html('<div class="alert alert-info">Processing...</div>');
            },
            success: function(response) {
                if(response.status === 'success') {
                    $('#alert-message').html('<div class="alert alert-success">'+response.message+'</div>');
                    $('#productForm')[0].reset();
                } else {
                    $('#alert-message').html('<div class="alert alert-danger">'+response.message+'</div>');
                }
            },
            error: function(xhr, status, error) {
                $('#alert-message').html('<div class="alert alert-danger">An error occurred: '+error+'</div>');
            }
        });

    });

});
</script>

</body>
</html>
