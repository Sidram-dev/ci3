<?php
$body_class = "register-page";
$data = ['title' => 'Register | AdminLTE', 'body_class' => $body_class];
$this->load->view('header', $data);
?>

<div class="register-box">
    <div class="register-logo">
        <a href="#"><b>Admin</b>LTE</a>
    </div>

    <div class="card">
        <div class="card-body register-card-body">
            <p class="register-box-msg">Register a new membership</p>

            <!-- AJAX Message Box -->
            <div id="ajaxMessage"></div>

            <?= form_open('register/submit', ['id' => 'registerForm']); ?>

            <div class="input-group mb-3">
                <input type="text" name="full_name" class="form-control" placeholder="Full Name" required>
                <div class="input-group-text"><span class="bi bi-person-fill"></span></div>
            </div>

            <div class="input-group mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email" required>
                <div class="input-group-text"><span class="bi bi-envelope"></span></div>
            </div>

            <div class="input-group mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
                <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
            </div>

            <div class="row">
                <div class="col-8">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="terms">
                        <label class="form-check-label" for="terms">
                            I agree to the <a href="#">terms</a>
                        </label>
                    </div>
                </div>

                <div class="col-4">
                    <button type="submit" id="btnSubmit" class="btn btn-primary btn-block">
                        Register
                    </button>
                </div>
            </div>

            </form>

            <div class="social-auth-links text-center mb-3 d-grid gap-2">
                <p>- OR -</p>
                <a href="#" class="btn btn-primary">
                    <i class="bi bi-facebook me-2"></i> Sign up using Facebook
                </a>
                <a href="#" class="btn btn-danger">
                    <i class="bi bi-google me-2"></i> Sign up using Google+
                </a>
            </div>

            <p class="mb-0 text-center">
                <a href="<?= site_url('login'); ?>">I already have a membership</a>
            </p>
        </div>
    </div>
</div>

<?php $this->load->view('footer'); ?>

<!-- jQuery - Required for AJAX -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$("#registerForm").submit(function(e){
    e.preventDefault(); // stop reload

    $("#btnSubmit").prop("disabled", true).text("Please wait...");

    $.ajax({
        url: "<?= site_url('register/submit'); ?>",
        type: "POST",
        data: $(this).serialize(),
        dataType: "json",
        success: function(response){

            if(response.status === false){
                // Validation or Email Exists Error
                $("#ajaxMessage").html(
                    `<div class="alert alert-danger">${response.message}</div>`
                );
                $("#btnSubmit").prop("disabled", false).text("Register");
            } 
            else {
                // Success
                $("#ajaxMessage").html(
                    `<div class="alert alert-success">${response.message}</div>`
                );

                // Redirect to login (NO reload of register page)
                setTimeout(() => {
                    window.location.href = "<?= site_url('login'); ?>";
                }, );
            }
        },

        error: function(){
            $("#ajaxMessage").html(
                `<div class="alert alert-danger">Something went wrong! Try again.</div>`
            );
            $("#btnSubmit").prop("disabled", false).text("Register");
        }
    });
});
</script>
