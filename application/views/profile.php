<?php $this->load->view('header'); ?>

<!-- INTL TEL INPUT CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.css"/>

<style>
/* KEEP FLAGS COMPACT */
.iti {
    width: 100% !important;
    max-width: 260px !important;
}
td .iti {
    display: block;
}
</style>

<body class="layout-fixed fixed-header fixed-footer sidebar-expand-lg bg-body-tertiary">

<div class="app-wrapper">

    <!-- HEADER -->
    <?php $this->load->view('navigation/headernav'); ?>

    <!-- SIDEBAR -->
    <?php $this->load->view('navigation/sidebar'); ?>

    <main class="app-main">

        <!-- PAGE TITLE -->
        <div class="app-content-header">
            <div class="container-fluid">
                <h3 class="fw-bold">My Profile</h3>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">

                <!-- FLASH MESSAGES -->
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
                <?php endif; ?>

                <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>

                
                <!-- CARD -->
                <div class="card shadow-lg w-75 mx-auto mt-4 border-0">

                    <div class="card-header bg-primary text-white py-3">
                        <h4 class="mb-0">Edit Profile</h4>
                    </div>

                    <div class="card-body p-4">

                        <div id="responseMsg"></div>

                        <!-- PROFILE FORM -->
                        <form id="profileForm" enctype="multipart/form-data">

                            <!-- CSRF TOKEN -->
                            <input type="hidden"
                                   name="<?= $this->security->get_csrf_token_name(); ?>"
                                   value="<?= $this->security->get_csrf_hash(); ?>">

                            <table class="table table-hover align-middle">

                                <tr>
                                    <th width="25%">User ID</th>
                                    <td class="fw-bold"><?= $user->id; ?></td>
                                </tr>

                                <tr>
                                    <th>First Name</th>
                                    <td>
                                        <input type="text" name="first_name" class="form-control shadow-sm"
                                               value="<?= html_escape($user->first_name); ?>" required>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Last Name</th>
                                    <td>
                                        <input type="text" name="last_name" class="form-control shadow-sm"
                                               value="<?= html_escape($user->last_name); ?>" required>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Email</th>
                                    <td>
                                        <input type="email" class="form-control shadow-sm"
                                               value="<?= html_escape($user->email); ?>" readonly>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Role</th>
                                    <td>
                                        <select name="role" class="form-select shadow-sm" required>
                                            <option value="admin" <?= $user->role == 'admin' ? 'selected' : ''; ?>>Admin</option>
                                            <option value="manager" <?= $user->role == 'manager' ? 'selected' : ''; ?>>Manager</option>
                                            <option value="user" <?= $user->role == 'user' ? 'selected' : ''; ?>>Customer</option>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <select name="status" class="form-select shadow-sm">
                                            <option value="1" <?= $user->status == 1 ? 'selected' : ''; ?>>Active</option>
                                            <option value="0" <?= $user->status == 0 ? 'selected' : ''; ?>>Inactive</option>
                                        </select>
                                    </td>
                                </tr>

                                <!-- *************************************** -->
                                <!--       PHONE + FLAG + AUTO-MASK         -->
                                <!-- *************************************** -->
                                <tr>
                                    <th>Phone Number</th>
                                    <td>

                                        <div style="max-width:260px;">
                                            <input type="tel"
                                                   id="phone"
                                                   name="phone"
                                                   class="form-control shadow-sm"
                                                   placeholder="000-000-0000"
                                                   required>
                                        </div>

                                        <input type="hidden"
                                               id="country_code"
                                               name="country_code"
                                               value="<?= $user->country_code ?>">

                                    </td>
                                </tr>
                                <!-- *************************************** -->

                                <tr>
                                    <th>Created At</th>
                                    <td class="text-muted">
                                        <?= date('d-m-Y H:i', strtotime($user->created_at)); ?>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Profile Image</th>
                                    <td>
                                        <input type="file" name="profile_image" class="form-control shadow-sm" accept="image/*">
                                        <small class="text-danger">Allowed: gif, jpg, png, jpeg, webp</small>
                                    </td>
                                </tr>

                            </table>

                            <div class="text-end mt-3">
                                <a href="<?= site_url('tabels'); ?>" class="btn btn-secondary px-4">Back</a>
                                <button type="submit" class="btn btn-primary px-4">Update</button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>

    </main>

    <?php $this->load->view('navigation/footer'); ?>

</div>

<!-- JQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- INTL TEL INPUT JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>

<script>
$(document).ready(function () {

    /* ----------------------------------------------------
       INTL-TEL-INPUT (FLAGS + COUNTRY DROPDOWN)
    ---------------------------------------------------- */

    const input = document.querySelector("#phone");

    const iti = window.intlTelInput(input, {
        initialCountry: "auto",
        separateDialCode: true,
        nationalMode: false,
        preferredCountries: ["in", "us", "gb", "ae"],
        geoIpLookup: function(callback) {
            callback("in");
        }
    });

    // Set existing phone + mask
    let existingPhone = "<?= $user->phone ?>";
    input.value = existingPhone;

    // On country change → update hidden field
    input.addEventListener("countrychange", function () {
        $("#country_code").val("+" + iti.getSelectedCountryData().dialCode);
    });

    // Initial set
    $("#country_code").val("+" + iti.getSelectedCountryData().dialCode);


    /* ----------------------------------------------------
       PHONE MASK 000-000-0000 (without breaking flags)
    ---------------------------------------------------- */

    function onlyDigits(str) {
        return str.replace(/\D/g, "");
    }

    function applyMask(value) {
        let d = onlyDigits(value).substring(0, 10);
        if (d.length > 6) return d.substring(0,3)+"-"+d.substring(3,6)+"-"+d.substring(6);
        if (d.length > 3) return d.substring(0,3)+"-"+d.substring(3);
        return d;
    }

    $("#phone").on("input", function () {
        this.value = applyMask(this.value);
    });


    /* ----------------------------------------------------
       AJAX REQUEST
    ---------------------------------------------------- */

    $("#profileForm").on("submit", function(e) {
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            url: "<?= site_url('New_admin/update_profile'); ?>",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",

            beforeSend: function() {
                $("#responseMsg").html('<div class="alert alert-info">Updating...</div>');
            },

            success: function(res) {
                if (res.status === true) {
                    $("#responseMsg").html('<div class="alert alert-success">' + res.msg + '</div>');
                } else {
                    $("#responseMsg").html('<div class="alert alert-danger">' + res.msg + '</div>');
                }
            },

            error: function() {
                $("#responseMsg").html('<div class="alert alert-danger">Something went wrong!</div>');
            }
        });
    });

});
</script>

<?php $this->load->view('footer'); ?>
