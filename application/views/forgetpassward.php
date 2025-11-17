<?php $this->load->view('header'); ?>

<div class="login-logo">
    <a href="#"><b>Admin</b>LTE</a>
</div>

<div class="card">
    <div class="card-body login-card-body">

        <p class="login-box-msg">
            You forgot your password?<br>
            Enter your email below to reset it.
        </p>

        <form action="<?= base_url('auth/sendResetLink') ?>" method="post">
            <div class="input-group mb-3">
                <input type="email" class="form-control" placeholder="Email" name="email" required>
                <div class="input-group-text">
                    <span class="bi bi-envelope"></span>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 mb-3">
                Request New Password
            </button>
        </form>

        <p class="mb-0 text-center">
            <a href="<?= site_url('login') ?>">Back to login</a>
        </p>

    </div>
</div>

<?php $this->load->view('footer'); ?>
