<!DOCTYPE html>
<html>
<head>
<title>Reset Password</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5" style="max-width: 400px">

    <h3 class="text-center">Create New Password</h3>

    <?php if($this->session->flashdata('error')): ?>
        <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
    <?php endif; ?>


    <?= form_open('forgetpassward/updatePassword'); ?>

        <input type="hidden" name="token" value="<?= $token ?>">

        <label>New Password</label>
        <input type="password" name="password" class="form-control mb-3" required>

        <label>Confirm Password</label>
        <input type="password" name="confirm" class="form-control mb-3" required>

        <button class="btn btn-success w-100">Update Password</button>

    <?= form_close(); ?>


</div>

</body>
</html>
