<?php $this->load->view('header'); ?>

<body class="layout-fixed fixed-header fixed-footer sidebar-expand-lg bg-body-tertiary">
<div class="app-wrapper">

    <!-- HEADER -->
    <?php $this->load->view('navigation/headernav'); ?>

    <!-- SIDEBAR -->
    <?php $this->load->view('navigation/sidebar'); ?>

    <!-- MAIN CONTENT -->
    <main class="app-main">

        <div class="app-content">
            <div class="container-fluid">

                <div class="row justify-content-center">
                    <div class="col-md-8">

                        <div class="card shadow-lg border-0 rounded-4">

                            <div class="card-header bg-primary text-white rounded-top-4">
                                <h4 class="mb-0"><i class="bi bi-person-plus"></i> New Admin</h4>
                            </div>

                            <div class="card-body p-4">

                                <!-- area for AJAX messages -->
                                <div id="ajaxMessage"></div>

                                <!-- Use form_open('', ...) so action is current controller route.
                                     This page will still work without JS (progressive enhancement). -->
                                <?= form_open('new_admin/save', ['id' => 'newAdminForm']); ?>

                                <!-- CSRF token -->
                                <input type="hidden"
                                       name="<?= $this->security->get_csrf_token_name(); ?>"
                                       value="<?= $this->security->get_csrf_hash(); ?>"
                                       id="csrf_token">

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Full Name</label>
                                    <input type="text" name="full_name" class="form-control form-control-lg"
                                           placeholder="Enter full name" required>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">First Name</label>
                                        <input type="text" name="first_name" class="form-control form-control-lg"
                                               placeholder="Enter first name" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">Last Name</label>
                                        <input type="text" name="last_name" class="form-control form-control-lg"
                                               placeholder="Enter last name" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Email</label>
                                    <input type="email" name="email" class="form-control form-control-lg"
                                           placeholder="Enter email address" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Password</label>
                                    <input type="password" name="password" class="form-control form-control-lg"
                                           placeholder="Enter password" required>
                                </div>

                                <div class="d-flex justify-content-between mt-4">
                                    <a href="<?= site_url('tabels'); ?>" class="btn btn-light border px-4 py-2">
                                        <i class="bi bi-arrow-left"></i> Back
                                    </a>
                                    <button type="submit" id="submitBtn" class="btn btn-success px-5 py-2 fw-bold">
                                        <i class="bi bi-save"></i> Create Admin
                                    </button>
                                </div>

                                <?= form_close(); ?>

                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </main>

    <?php $this->load->view('navigation/footer'); ?>
</div>

<?php $this->load->view('footer'); ?>

<!-- Ensure jQuery is present. If your footer already loads jQuery, this won't hurt. -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(function() {
    // attach submit handler - uses progressive enhancement: form action still works without JS
    $('#newAdminForm').on('submit', function(e) {
        e.preventDefault(); // prevent default only when JS enabled

        $('#ajaxMessage').html('');
        $('#submitBtn').prop('disabled', true).text('Saving...');

        // serialize form (includes CSRF hidden field)
        var data = $(this).serialize();

        // debug: uncomment to see serialized data in console
        // console.log('Submitting:', data);

        $.ajax({
            url: "<?= site_url('new_admin/save'); ?>",
            method: "POST",
            data: data,
            dataType: "json",
            timeout: 15000,

            success: function(resp) {
                // expected JSON: { status: 'success'|'error', message: '...', csrf_token_name: '...', csrf_hash: '...' }
                if (!resp) {
                    $('#ajaxMessage').html('<div class="alert alert-danger">Invalid server response.</div>');
                    $('#submitBtn').prop('disabled', false).html('<i class="bi bi-save"></i> Create Admin');
                    return;
                }

                // update CSRF token if provided
                if (resp.csrf_token_name && resp.csrf_hash) {
                    $('#csrf_token').val(resp.csrf_hash);
                }

                if (resp.status === 'success') {
                    $('#ajaxMessage').html('<div class="alert alert-success">' + resp.message + '</div>');
                    // redirect after 600ms
                    setTimeout(function() {
                        window.location.href = "<?= site_url('dashboard'); ?>";
                    }, 600);
                } else {
                    var msg = resp.message || 'Failed to save.';
                    $('#ajaxMessage').html('<div class="alert alert-danger">' + msg + '</div>');
                    $('#submitBtn').prop('disabled', false).html('<i class="bi bi-save"></i> Create Admin');
                }
            },

            error: function(xhr, status, error) {
                var serverText = xhr.responseText || '';
                $('#ajaxMessage').html('<div class="alert alert-danger">AJAX error: ' + status + ' ' + error + '<br><small>' + $('<div>').text(serverText).html() + '</small></div>');
                $('#submitBtn').prop('disabled', false).html('<i class="bi bi-save"></i> Create Admin');
                console.error('AJAX error', status, error, xhr);
            }
        });
    });
});
</script>

</body>
</html>
