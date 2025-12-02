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

                <!-- ALERT MESSAGES -->
                <div id="alert-message"></div>

                <!-- CARD -->
                <div class="card shadow-lg w-75 mx-auto border-0">

                    <div class="card-header bg-warning text-dark py-3">
                        <h4 class="mb-0">Update Product Details</h4>
                    </div>

                    <div class="card-body p-4">

                        <?= form_open_multipart('ProductController/update_product/' . $product->id, ['id' => 'editProductForm']); ?>

                        <input type="hidden" name="old_image" value="<?= $product->image; ?>">

                        <div class="mb-3">
                            <label class="fw-semibold">Product Name</label>
                            <input type="text" name="name" class="form-control shadow-sm"
                                   value="<?= $product->name; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="fw-semibold">Description</label>
                            <textarea name="description" class="form-control shadow-sm"
                                      rows="3"><?= $product->description; ?></textarea>
                        </div>

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

                        <div class="mb-3">
                            <label class="fw-semibold">Sub Category</label>
                            <input type="text" name="sub_category" class="form-control shadow-sm"
                                   value="<?= $product->sub_category; ?>">
                        </div>

                        <div class="mb-3">
                            <label class="fw-semibold">Stock</label>
                            <input type="number" name="stock" class="form-control shadow-sm"
                                   value="<?= $product->stock; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="fw-semibold">Price</label>
                            <input type="text" name="price" class="form-control shadow-sm"
                                   value="<?= $product->price; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="fw-semibold">Product Image</label>
                            <input type="file" id="imageInput" name="image" class="form-control shadow-sm" accept="image/*">

                            <div class="mt-3">
                                <img id="imagePreview"
                                     src="<?= $product->image ? base_url('assets/upload/' . $product->image) : base_url('assets/upload/no-image.png'); ?>"
                                     class="border rounded shadow-sm" width="200">
                            </div>
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

    <?php $this->load->view('navigation/footer'); ?>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {

    // Image live preview
    $('#imageInput').on('change', function(event) {
        const file = event.target.files[0];
        if(file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').attr('src', e.target.result);
            }
            reader.readAsDataURL(file);
        }
    });

    // AJAX form submission
    $('#editProductForm').on('submit', function(e) {
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
