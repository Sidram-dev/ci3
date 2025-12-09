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

                        <!-- Product Name -->
                        <div class="mb-3">
                            <label class="fw-semibold">Product Name</label>
                            <input type="text" name="name" class="form-control shadow-sm"
                                   value="<?= $product->name; ?>" required>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label class="fw-semibold">Description</label>
                            <textarea id="descriptionEditor" name="description" class="form-control shadow-sm" rows="3"><?= $product->description; ?></textarea>
                        </div>

                        <!-- Category -->
                        <div class="mb-3">
                            <label class="fw-semibold">Category</label>
                            <select id="category" name="category" class="form-select shadow-sm" required>
                                <option value="">-- Select Category --</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat->category_id ?>"
                                        <?= ($product->category == $cat->category_id) ? 'selected' : ''; ?>>
                                        <?= $cat->category_name ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Sub Category -->
                        <div class="mb-3">
                            <label class="fw-semibold">Sub Category</label>
                            <select id="sub_category" name="sub_category" class="form-select shadow-sm" required>
                                <option value="">-- Select Sub Category --</option>
                            </select>
                        </div>

                        <!-- Stock -->
                        <div class="mb-3">
                            <label class="fw-semibold">Stock</label>
                            <input type="number" name="stock" class="form-control shadow-sm"
                                   value="<?= $product->stock; ?>" required>
                        </div>

                        <!-- Price -->
                        <div class="mb-3">
                            <label class="fw-semibold">Price</label>
                            <input type="text" name="price" class="form-control shadow-sm"
                                   value="<?= $product->price; ?>" required>
                        </div>

                        <!-- Image -->
                        <div class="mb-3">
                            <label class="fw-semibold">Product Image</label>
                            <input type="file" id="imageInput" name="image" class="form-control shadow-sm" accept="image/*">

                            <div class="mt-3">
                                <img id="imagePreview"
                                     src="<?= $product->image ? base_url('assets/upload/' . $product->image) : base_url('assets/upload/no-image.png'); ?>"
                                     class="border rounded shadow-sm" width="200">
                            </div>
                        </div>

                        <!-- Buttons -->
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

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- CKEditor -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>

<script>
let editor;
ClassicEditor
    .create(document.querySelector('#descriptionEditor'))
    .then(ed => editor = ed)
    .catch(error => console.error(error));
</script>

<!-- Image Preview -->
<script>
$('#imageInput').on('change', function (event) {
    const file = event.target.files[0];
    if(file){
        const reader = new FileReader();
        reader.onload = function(e){
            $('#imagePreview').attr('src', e.target.result);
        }
        reader.readAsDataURL(file);
    }
});
</script>

<!-- AJAX Form Submit -->
<script>
$('#editProductForm').on('submit', function(e) {
    e.preventDefault();

    $('textarea[name="description"]').val(editor.getData());
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
</script>

<!-- ✅ Category → SubCategory AJAX -->
<script>
$(document).ready(function () {

    function loadSubCategories(categoryId, selectedSubCat = '') {
        if(categoryId === ''){
            $('#sub_category').html('<option value="">-- Select Sub Category --</option>');
            return;
        }

        $.ajax({
            url: '<?= base_url("ProductController/get_subcategories"); ?>',
            type: 'GET',
            data: { category_id: categoryId },
            dataType: 'json',
            success: function (data) {

                $('#sub_category').html('<option value="">-- Select Sub Category --</option>');

                $.each(data, function (i, item) {
                    let selected = (item.sub_category_id == selectedSubCat) ? 'selected' : '';
                    $('#sub_category').append(
                        '<option value="'+item.sub_category_id+'" '+selected+'>'+item.sub_category_name+'</option>'
                    );
                });
            }
        });
    }

    // Load when page opens
    let currentCategory    = '<?= $product->category ?>';
    let currentSubCategory = '<?= $product->sub_category ?>';

    loadSubCategories(currentCategory, currentSubCategory);

    // Reload when category changes
    $('#category').change(function(){
        loadSubCategories($(this).val());
    });

});
</script>

</body>
</html>
