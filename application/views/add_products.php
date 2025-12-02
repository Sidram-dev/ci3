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

                <!-- ALERTS -->
                <div id="ajax-alert"></div>

                <!-- CARD -->
                <div class="card shadow-lg w-75 mx-auto mt-4 border-0">
                    <div class="card-header bg-primary text-white py-3">
                        <h4 class="mb-0">Product Details</h4>
                    </div>

                    <div class="card-body p-4">

                        <form id="addProductForm" enctype="multipart/form-data">

                            <div class="mb-3">
                                <label>Product Name</label>
                                <input type="text" name="name" class="form-control shadow-sm" required>
                            </div>

                            <div class="mb-3">
                                <label>Description</label>
                                <textarea name="description" class="form-control shadow-sm"></textarea>
                            </div>

                            <div class="mb-3">
                                <label>Category</label>
                                <select name="category" class="form-select shadow-sm" required>
                                    <option value="">-- Select Category --</option>
                                    <option value="Electronics">Electronics</option>
                                    <option value="Fashion">Fashion</option>
                                    <option value="Groceries">Groceries</option>
                                    <option value="Home & Kitchen">Home & Kitchen</option>
                                    <option value="Beauty">Beauty</option>
                                    <option value="Sports">Sports</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>Sub-Category</label>
                                <input type="text" name="sub_category" class="form-control shadow-sm">
                            </div>

                            <div class="mb-3">
                                <label>Stock</label>
                                <input type="number" name="stock" class="form-control shadow-sm" required>
                            </div>

                            <div class="mb-3">
                                <label>Price</label>
                                <input type="text" name="price" class="form-control shadow-sm" required>
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

                        </form>

                    </div>
                </div>
            </div>
        </div>

    </main>

    <?php $this->load->view('footer'); ?>
    <?php $this->load->view('navigation/footer'); ?>

</div>

<!-- AJAX SCRIPT -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#addProductForm').on('submit', function(e){
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: '<?= site_url("ProductController/save_product_ajax"); ?>',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            beforeSend: function(){
                $('#ajax-alert').html('');
            },
            success: function(response){
                if(response.status){
                    $('#ajax-alert').html('<div class="alert alert-success">'+response.message+'</div>');
                    $('#addProductForm')[0].reset();
                } else {
                    $('#ajax-alert').html('<div class="alert alert-danger">'+response.message+'</div>');
                }
            },
            error: function(){
                $('#ajax-alert').html('<div class="alert alert-danger">Server error, please try again.</div>');
            }
        });
    });
</script>

</body>
</html>
