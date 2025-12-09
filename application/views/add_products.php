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

                    <!-- PRODUCT CARD -->
                    <div class="card shadow-lg w-75 mx-auto mt-4 border-0">

                        <div class="card-header bg-primary text-white py-3">
                            <h4 class="mb-0">Product Details</h4>
                        </div>

                        <div class="card-body p-4">

                            <?= form_open_multipart('ProductController/save_product', ['id' => 'productForm']); ?>

                            <!-- Product Name -->
                            <div class="mb-3">
                                <label for="productName">Product Name</label>
                                <input type="text" id="productName" name="name" class="form-control shadow-sm" value="<?= set_value('name'); ?>" required>
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label for="descriptionEditor">Description</label>
                                <textarea id="descriptionEditor" name="description"><?= set_value('description'); ?></textarea>
                            </div>

                            <!-- Category Dropdown -->
                            <div class="mb-3">
                                <label for="category">Category</label>
                                <select id="category" name="category" class="form-select" required>
                                    <option value="">-- Select Category --</option>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?= $cat->category_id ?>">
                                            <?= $cat->category_name ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Sub Category Dropdown -->
                            <div class="mb-3">
                                <label for="sub_category">Sub Category</label>
                                <select id="sub_category" name="sub_category" class="form-select" required>
                                    <option value="">-- Select Sub Category --</option>
                                </select>
                            </div>


                            <!-- Stock -->
                            <div class="mb-3">
                                <label for="stock">Stock</label>
                                <input type="number" id="stock" name="stock" class="form-control shadow-sm" value="<?= set_value('stock'); ?>" required>
                            </div>

                            <!-- Price -->
                            <div class="mb-3">
                                <label for="price">Price</label>
                                <input type="text" id="price" name="price" class="form-control shadow-sm" value="<?= set_value('price'); ?>" required>
                            </div>

                            <!-- Image -->
                            <div class="mb-3">
                                <label for="image">Image</label>
                                <input type="file" id="image" name="image" class="form-control shadow-sm">
                            </div>

                            <!-- Buttons -->
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

    <!-- CKEditor -->
    <script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>

    <script>
        let editor;

        // Initialize CKEditor
        ClassicEditor
            .create(document.querySelector('#descriptionEditor'))
            .then(ed => editor = ed)
            .catch(error => console.error(error));

        $(document).ready(function() {
            // Load Subcategories based on selected Category

            $('#category').on('change', function() {
                let category_id = $(this).val();

                if (category_id === '') {
                    $('#sub_category').html('<option value="">-- Select Sub Category --</option>');
                    return;
                }

                $.ajax({
                    url: '<?= base_url("ProductController/get_subcategories"); ?>',
                    method: 'GET',
                    data: {
                        category_id: category_id
                    },
                    dataType: 'json',
                    success: function(data) {

                        $('#sub_category').html('<option value="">-- Select Sub Category --</option>');

                        if (data.length > 0) {
                            $.each(data, function(i, row) {
                                $('#sub_category').append(
                                    '<option value="' + row.sub_category_id + '">' + row.sub_category_name + '</option>'
                                );
                            });
                        } else {
                            $('#sub_category').html('<option value="">No sub categories found</option>');
                        }
                    }
                });
            });

            // AJAX Form Submit
            $('#productForm').on('submit', function(e) {
                e.preventDefault();

                // Get CKEditor data
                $('textarea[name="description"]').val(editor.getData());

                let formData = new FormData(this);

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
                        if (response.status === 'success') {
                            $('#alert-message').html('<div class="alert alert-success">' + response.message + '</div>');
                            $('#productForm')[0].reset();
                            editor.setData('');
                        } else {
                            $('#alert-message').html('<div class="alert alert-danger">' + response.message + '</div>');
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#alert-message').html('<div class="alert alert-danger">An error occurred: ' + error + '</div>');
                    }
                });

            });

        });
    </script>

</body>

</html>