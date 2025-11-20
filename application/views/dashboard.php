<?php 
$data['title'] = "My Profile | AdminLTE";
$this->load->view('header', $data); 
?>

<body class="hold-transition sidebar-mini sidebar-expand-lg">


<div class="app-wrapper">

    <!-- HEADER (contains messages, notifications, user dropdowns) -->
    <?php $this->load->view('navigation/headernav'); ?>

    <!-- SIDEBAR -->
    <?php $this->load->view('navigation/sidebar'); ?>

    <!-- MAIN CONTENT WRAPPER -->
    <main class="app-main">

        <div class="app-content-header">
            <div class="container-fluid">
                <h3 class="mb-0">Dashboard</h3>
            </div>
        </div>

        <!-- PAGE CONTENT -->
        <div class="app-content">
            <div class="container-fluid">

                <p>Welcome to your Dashboard!</p>

            </div>
        </div>

    </main>

</div>

<!-- FOOTER -->
<?php $this->load->view('navigation/footer'); ?>

</body>
</html>
