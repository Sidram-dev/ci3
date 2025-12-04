<!doctype html>
<html lang="en">
<head>
  <meta name="csrf-token-name" content="<?= $this->security->get_csrf_token_name(); ?>">
<meta name="csrf-token-hash" content="<?= $this->security->get_csrf_hash(); ?>">

    <meta charset="utf-8" />
    <title><?= htmlspecialchars($title ?? "AdminLTE 4"); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/adminlte.css'); ?>">

    <!-- Overlay Scrollbars -->
    <link rel="stylesheet" href="<?= base_url('assets/css/overlayscrollbars.min.css'); ?>">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap-icons.min.css'); ?>">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/index.css'); ?>">

    <link rel="stylesheet" href="<?= base_url('assets/css/custom.css'); ?>">

    <!-- Page-specific safe CSS for login centering -->
    <style>
    /* only applies when body has class 'login-page' */
    body.login-page {
      background: #f4f6f9;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
      box-sizing: border-box;
    }
    .login-box {
      width: 400px;
      max-width: 100%;
      margin: 0 auto;
    }
    .login-card-body { padding: 24px; }
    .login-card-body .input-group .form-control { height: 44px; }
    .btn-block { width: 100%; }
    @media (max-width:420px){ .login-box{ width:100%; padding:0 10px; } }
    </style>
</head>

<?php
// ensure $body_class variable is available. If not set, fallback to dashboard layout.
$body_class_output = isset($body_class) ? $body_class : 'hold-transition sidebar-mini layout-fixed';
?>
<body class="<?= htmlspecialchars($body_class_output); ?>">
