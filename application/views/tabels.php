<?php 
$data['title'] = "Simple Tables | AdminLTE";
$this->load->view('header', $data); 
?>

<body class="hold-transition sidebar-mini sidebar-expand-lg">


<div class="app-wrapper">

    <!-- HEADER -->
    <?php 
    $session_user = $this->session->userdata('user');
    if (empty($session_user) || !is_object($session_user)) {
        $session_user = (object)['full_name' => 'Guest User'];
    }
    $this->load->view('navigation/headernav', ['user' => $session_user]); 
    ?>

    <!-- SIDEBAR -->
    <?php $this->load->view('navigation/sidebar'); ?>

    <!-- MAIN CONTENT WRAPPER -->
    <main class="app-main">

        <div class="app-content-header">
            <div class="container-fluid">
                <h3 class="mb-0">Simple Tables</h3>
            </div>
        </div>

        <!-- PAGE CONTENT -->
        <div class="app-content">
            <div class="container-fluid">

                <h2 class="mb-3">Registered Users</h2>

                <div class="card">
                    <div class="card-body table-responsive p-0">
                        <table class="table table-bordered table-striped text-nowrap">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($users)): ?>
                                    <?php foreach ($users as $u): ?>
                                        <tr>
                                            <td><?= html_escape($u->id); ?></td>
                                            <td><?= html_escape($u->first_name); ?></td>
                                            <td><?= html_escape($u->last_name); ?></td>
                                            <td><?= html_escape($u->first_name . ' ' . $u->last_name); ?></td>
                                            <td><?= html_escape($u->email); ?></td>
                                            <td>
                                                <?php if ($u->status == 1): ?>
                                                    <span class="badge bg-success">Active</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Inactive</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= html_escape(date('d-m-Y H:i', strtotime($u->created_at))); ?></td>
                                            <td>
                                                <a href="<?= site_url('tabels/edit/' . $u->id); ?>" class="btn btn-sm btn-primary">Edit</a>
                                                <a href="<?= site_url('tabels/view/' . $u->id); ?>" class="btn btn-sm btn-info">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="<?= site_url('tabels/delete/' . $u->id); ?>" class="btn btn-sm btn-danger"
                                                   onclick="return confirm('Are you sure to delete this user?');">
                                                   Delete
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center">No users found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>

                        <div class="mt-3">
                            <?= $pagination ?? ''; ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </main>

</div>

<!-- FOOTER -->
<?php $this->load->view('navigation/footer'); ?>

</body>
</html>
