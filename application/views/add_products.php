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

                    <div id="alert-message"></div>

                    <div class="card shadow-lg w-75 mx-auto mt-4 border-0">
                        <div class="card-header bg-primary text-white py-3">
                            <h4 class="mb-0">Product Details</h4>
                        </div>

                        <div class="card-body p-4">

                            <?= form_open_multipart('ProductController/save_product', ['id' => 'productForm']); ?>

                            <div class="mb-3">
                                <label>Product Name</label>
                                <input type="text" name="name" class="form-control shadow-sm" required>
                            </div>

                            <div class="mb-3">
                                <label>Description</label>
                                <textarea name="description" id="descriptionEditor"></textarea>
                            </div>

                            <!-- CATEGORY -->
                            <select name="category" id="category" class="form-select shadow-sm" required>
                                <option value="">-- Select Category --</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat->category_id ?>"><?= $cat->category_name ?></option>
                                <?php endforeach; ?>
                            </select>


                            <!-- SUB CATEGORY -->
                            <div class="mb-3">
                                <label>Sub-Category</label>
                                <select name="sub_category" id="sub_category" class="form-select shadow-sm" required>
                                    <option value="">-- Select Sub Category --</option>
                                </select>

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
        ClassicEditor.create(document.querySelector('#descriptionEditor'));
    </script>

    <script>
        $(document).ready(function() {

            // -------- AJAX SUBMIT PRODUCT FORM --------
            $('#productForm').on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                    formData.append(csrfName, csrfHash); // <-- ADD CSRF TOKEN

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
                            $('#sub_category').html('<option value="">-- Select Sub Category --</option>');
                        } else {
                            $('#alert-message').html('<div class="alert alert-danger">' + response.message + '</div>');
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        $('#alert-message').html('<div class="alert alert-danger">Server error</div>');
                    }
                });
            });

            // -------- DEPENDENT DROPDOWN: CATEGORY → SUBCATEGORY --------
            $('#category').on('change', function() {
                var category_id = $(this).val();

                if (!category_id) {
                    $('#sub_category').html('<option value="">-- Select Sub Category --</option>');
                    return;
                }

                $('#sub_category').html('<option value="">Loading...</option>');

                var csrfName = $('meta[name="csrf-token-name"]').attr('content');
                var csrfHash = $('meta[name="csrf-token-hash"]').attr('content');

                var postData = {
                    category_id: category_id
                };
                postData[csrfName] = csrfHash; // add CSRF token

                $.post("<?= site_url('ProductController/get_sub_categories_by_category'); ?>",
                    postData,
                    function(data) {
                        var options = '<option value="">-- Select Sub Category --</option>';
                        if (data.length > 0) {
                            $.each(data, function(i, item) {
                                options += '<option value="' + item.sub_category_id + '">' + item.sub_category_name + '</option>';
                            });
                        } else {
                            options += '<option value="">No subcategories found</option>';
                        }
                        $('#sub_category').html(options);

                        // Update CSRF token for next request
                        $('meta[name="csrf-token-hash"]').attr('content', data.csrf_hash);
                    },
                    "json"
                ).fail(function(xhr, status, error) {
                    console.error(error);
                    $('#sub_category').html('<option value="">Error loading</option>');
                });
            });


        });
    </script>

</body>

</html>