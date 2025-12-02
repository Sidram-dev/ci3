<?php
$data['title'] = "API Users | AdminLTE";
$this->load->view('header', $data);
?>

<body class="layout-fixed fixed-header fixed-footer sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        <?php $this->load->view('navigation/headernav', $data); ?>
        <?php $this->load->view('navigation/sidebar', $data); ?>

        <main class="app-main">

            <!-- PAGE HEADER & FILTER -->
            <div class="app-content-header">
                <div class="container-fluid d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Simple Tables</h3>

                    <!-- FILTER DROPDOWN -->
                    <form method="get" class="d-flex align-items-center">
                        <label for="role_filter" class="me-2 mb-0">List View:</label>
                        <select name="role" id="role_filter" class="form-select me-2" onchange="this.form.submit()">
                            <option value="">All</option>
                            <option value="admin" <?= (isset($role_filter) && $role_filter === 'admin') ? 'selected' : '' ?>>Admin</option>
                            <option value="manager" <?= (isset($role_filter) && $role_filter === 'manager') ? 'selected' : '' ?>>Manager</option>
                            <option value="customer" <?= (isset($role_filter) && $role_filter === 'customer') ? 'selected' : '' ?>>Customer</option>
                        </select>
                    </form>
                </div>
            </div>
            <div class="app-content-header">
                <div class="container-fluid d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">API Users</h3>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid">
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
                                        <th>Role</th>
                                        <th>Gender</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($users)): ?>
                                        <?php foreach ($users as $u): ?>
                                            <tr>
                                                <td><?= "VV-" . str_pad($u->id, 4, "0", STR_PAD_LEFT); ?></td>
                                                <td><?= $u->first_name; ?></td>
                                                <td><?= $u->last_name; ?></td>
                                                <td><?= $u->full_name; ?></td>
                                                <td><?= $u->email; ?></td>
                                                <td><?= ucfirst($u->role); ?></td>
                                                <td><?= ucfirst($u->gender); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center">No users found from API</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                            <!-- PAGINATION -->
                            <div class="mt-3">
                                <?= $pagination ?? ''; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <?php $this->load->view('navigation/footer'); ?>
    </div>
    <?php $this->load->view('footer', $data); ?>
</body>