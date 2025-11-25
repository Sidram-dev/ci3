<!DOCTYPE html>
<html>
<head>
<title>Forgot Password</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5" style="max-width: 400px">

    <h3 class="text-center">Forgot Password</h3>

    <?php if($this->session->flashdata('error')): ?>
        <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
    <?php endif; ?>

    <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>


    <?= form_open('forgetpassward/sendLink'); ?>
        <label>Email</label>
        <input type="email" name="email" class="form-control mb-3" required>

        <button class="btn btn-primary w-100">Send Reset Link</button>

    <?= form_close(); ?>

</div>

</body>
</html>
