<?php
$body_class = "login-page";
$data = ['title' => 'Login | AdminLTE', 'body_class' => $body_class];
$this->load->view('header', $data);
?>

<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>Admin</b>LTE</a>
    </div>

    <div class="card">
        <div class="card-body login-card-body">

            <p class="login-box-msg">Sign in to start your session</p>

            <!-- AJAX message -->
            <div id="ajaxMessage"></div>

            <?= form_open('login/submit', ['id' => 'loginForm']); ?>

                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                    <div class="input-group-text"><span class="bi bi-envelope"></span></div>
                </div>

                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                    <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
                </div>

                <div class="row mb-3">
                    <div class="col-8">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember">
                            <label class="form-check-label" for="remember">Remember Me</label>
                        </div>
                    </div>

                    <div class="col-4">
                        <button type="submit" id="btnLogin" class="btn btn-primary btn-block">Sign In</button>
                    </div>
                </div>

            <?= form_close(); ?>

            <div class="social-auth-links text-center mb-3 d-grid gap-2">
                <p>- OR -</p>
                <a href="#" class="btn btn-primary">
                    <i class="bi bi-facebook me-2"></i> Sign in using Facebook
                </a>
                <a href="#" class="btn btn-danger">
                    <i class="bi bi-google me-2"></i> Sign in using Google+
                </a>
            </div>

            <p class="mb-1 text-center"><a href="<?= site_url('forgetpassward') ?>">I forgot my password</a></p>
            <p class="mb-0 text-center"><a href="<?= site_url('register') ?>">Register a new membership</a></p>
        </div>
    </div>
</div>

<?php $this->load->view('footer'); ?>

<!-- jQuery for AJAX -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$("#loginForm").submit(function(e){
    e.preventDefault();

    $("#btnLogin").prop("disabled", true).text("Please wait...");

    $.ajax({
        url: "<?= site_url('login/submit'); ?>",
        type: "POST",
        data: $(this).serialize(),
        dataType: "json",
        success: function(response) {

            if(response.status === false){
                $("#ajaxMessage").html(
                    `<div class="alert alert-danger">${response.message}</div>`
                );
                $("#btnLogin").prop("disabled", false).text("Sign In");
            } 
            else {
                $("#ajaxMessage").html(
                    `<div class="alert alert-success">${response.message}</div>`
                );

                setTimeout(() => {
                    window.location.href = "<?= site_url('dashboard'); ?>";
                }, 1200);
            }
        },
        error: function() {
            $("#ajaxMessage").html(
                `<div class="alert alert-danger">Something went wrong! Try again.</div>`
            );
            $("#btnLogin").prop("disabled", false).text("Sign In");
        }
    });
});
</script>
