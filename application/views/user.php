<?php $this->load->view('header'); ?>

<body class="layout-fixed fixed-header fixed-footer sidebar-expand-lg bg-body-tertiary">

    <div class="app-wrapper">

        <?php $this->load->view('navigation/headernav'); ?>
        <?php $this->load->view('navigation/sidebar'); ?>

        <main class="app-main">

            <div class="app-content p-4">

                <div class="row justify-content-center">
                    <div class="col-md-8">

                        <div class="card shadow-lg border-0 rounded-4">

                            <div class="card-header bg-primary text-white rounded-top-4 py-3">
                                <h4 class="mb-0">
                                    <i class="bi bi-pencil-square"></i> Update Admin
                                </h4>
                            </div>

                            <div class="card-body p-4">

                                <!-- AJAX Messages -->
                                <div id="messageBox"></div>

                                <form id="updateUserForm">

                                    <input type="hidden" name="id" value="<?= $user->id; ?>">

                                    <!-- CSRF token -->
                                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                                        value="<?= $this->security->get_csrf_hash(); ?>">

                                    <div class="row g-4">

                                        <div class="col-md-6 col-12">
                                            <label class="form-label fw-semibold">First Name</label>
                                            <input type="text"
                                                name="first_name"
                                                class="form-control form-control-lg rounded-3"
                                                value="<?= $user->first_name; ?>"
                                                required>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <label class="form-label fw-semibold">Last Name</label>
                                            <input type="text"
                                                name="last_name"
                                                class="form-control form-control-lg rounded-3"
                                                value="<?= $user->last_name; ?>"
                                                required>
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label fw-semibold">Email (Readonly)</label>
                                            <input type="email"
                                                class="form-control form-control-lg rounded-3"
                                                value="<?= $user->email; ?>"
                                                readonly>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <label class="form-label fw-semibold">Phone Number</label>

                                            <div style="max-width:260px;">
                                                <input type="tel"
                                                    id="phone"
                                                    name="phone"
                                                    class="form-control form-control-lg rounded-3"
                                                    value="<?= $user->phone ?>"
                                                    placeholder="000-000-0000"
                                                    required>
                                            </div>

                                            <input type="hidden"
                                                id="country_code"
                                                name="country_code"
                                                value="<?= $user->country_code ?>">
                                        </div>


                                        <div class="col-md-6 col-12">
                                            <label class="form-label fw-semibold">Status</label>
                                            <select name="status"
                                                class="form-select form-select-lg rounded-3">
                                                <option value="1" <?= ($user->status == 1) ? 'selected' : ''; ?>>Active</option>
                                                <option value="0" <?= ($user->status == 0) ? 'selected' : ''; ?>>Inactive</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <label class="form-label fw-semibold">Role</label>
                                            <select name="role"
                                                class="form-select form-select-lg rounded-3">
                                                <option value="customer" <?= ($user->role == 'customer') ? 'selected' : ''; ?>>Customer</option>
                                                <option value="admin" <?= ($user->role == 'admin') ? 'selected' : ''; ?>>Admin</option>
                                                <option value="manager" <?= ($user->role == 'manager') ? 'selected' : ''; ?>>Manager</option>
                                            </select>
                                        </div>

                                    </div>

                                    <div class="mt-5 d-flex justify-content-between">
                                        <a href="<?= site_url('tabels'); ?>"
                                            class="btn btn-secondary btn-lg px-4 rounded-3">
                                            Cancel
                                        </a>

                                        <button type="submit"
                                            class="btn btn-success btn-lg px-4 rounded-3">
                                            Update
                                        </button>
                                    </div>
                                </form>

                            </div>

                        </div>

                    </div>
                </div>

            </div>

        </main>

        <?php $this->load->view('navigation/footer'); ?>
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>

</body>

<?php $this->load->view('footer'); ?>

<!-- jQuery for AJAX -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).on("submit", "#updateUserForm", function(e) {
        e.preventDefault();

        let formData = $(this).serialize();

        $.ajax({
            url: "<?= site_url('tabels/update/' . $user->id); ?>",
            type: "POST",
            data: formData,
            dataType: "json",

            beforeSend: function() {
                $("#messageBox").html('<div class="alert alert-info">Updating... Please wait.</div>');
            },

            success: function(response) {
                if (response.status === "success") {
                    $("#messageBox").html('<div class="alert alert-success">' + response.message + '</div>');
                } else if (response.status === "error" && response.validation_errors) {
                    $("#messageBox").html('<div class="alert alert-danger">' + response.validation_errors + '</div>');
                } else {
                    $("#messageBox").html('<div class="alert alert-danger">' + response.message + '</div>');
                }
            },

            error: function(xhr, status, error) {
                $("#messageBox").html('<div class="alert alert-danger">Server error! Please try again.</div>');
                console.error(xhr.responseText);
            }
        });
    });

    // -------------------------------------------
    //     PHONE FLAG + MASK SCRIPT (same as profile.php)
    // -------------------------------------------

    const phoneInput = document.querySelector("#phone");

    const iti = window.intlTelInput(phoneInput, {
        initialCountry: "auto",
        separateDialCode: true,
        nationalMode: false,
        preferredCountries: ["in", "us", "gb", "ae"],
        geoIpLookup: function(callback) {
            callback("in"); // default
        }
    });

    // load existing phone
    let existingPhone = "<?= $user->phone ?>";
    phoneInput.value = existingPhone;

    // update hidden field on country change
    phoneInput.addEventListener("countrychange", function() {
        $("#country_code").val("+" + iti.getSelectedCountryData().dialCode);
    });

    // initial hidden dial code set
    $("#country_code").val("+" + iti.getSelectedCountryData().dialCode);

    // phone mask function
    function onlyDigits(str) {
        return str.replace(/\D/g, "");
    }

    function applyMask(value) {
        let d = onlyDigits(value).substring(0, 10);
        if (d.length > 6) return d.substring(0, 3) + "-" + d.substring(3, 6) + "-" + d.substring(6);
        if (d.length > 3) return d.substring(0, 3) + "-" + d.substring(3);
        return d;
    }

    $("#phone").on("input", function() {
        this.value = applyMask(this.value);
    });
</script>