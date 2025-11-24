<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>CodeIgniter Email Example</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .email-container {
            max-width: 450px;
            margin: 80px auto;
            padding: 30px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0px 4px 15px rgba(0,0,0,0.1);
        }
        .btn-custom {
            width: 100%;
            padding: 10px;
            background: #007bff;
            color: white;
            border-radius: 6px;
            border: none;
        }
        .btn-custom:hover {
            background: #0056b3;
        }
    </style>
</head>

<body>

<div class="email-container">
    
    <h3 class="text-center mb-3">Send Email</h3>

    <!-- Flash message -->
    <?php if ($this->session->flashdata('email_sent')): ?>
        <div class="alert alert-info text-center">
            <?php echo $this->session->flashdata('email_sent'); ?>
        </div>
    <?php endif; ?>

    <!-- Email Form -->
    <?php echo form_open('Email/send_mail'); ?>

       <div class="mb-3">
    <label class="form-label">Recipient Emails (comma separated)</label>
    <input type="text" name="email" class="form-control" 
           placeholder="email1@gmail.com, email2@gmail.com, email3@gmail.com" required>
</div>


        <button type="submit" class="btn-custom">Send Mail</button>

    <?php echo form_close(); ?>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
