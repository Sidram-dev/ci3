<?php $this->load->view('header'); ?>

<div class="container mt-4">
    <h2>User Details</h2>
    <table class="table table-bordered table-striped w-50">
        <tr>
            <th>ID</th>
            <td><?= $user->id; ?></td>
        </tr>
        <tr>
            <th>First Name</th>
            <td><?= $user->first_name; ?></td>
        </tr>
        <tr>
            <th>Last Name</th>
            <td><?= $user->last_name; ?></td>
        </tr>
        <tr>
            <th>Full Name</th>
            <td><?= $user->first_name . ' ' . $user->last_name; ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?= $user->email; ?></td>
        </tr>
        <tr>
            <th>Status</th>
            <td>
                <?php if ($user->status == 1): ?>
                    <span class="badge bg-success">Active</span>
                <?php else: ?>
                    <span class="badge bg-danger">Inactive</span>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <th>Created At</th>
            <td><?= date('d-m-Y H:i', strtotime($user->created_at)); ?></td>
        </tr>
    </table>
    <a href="<?= site_url('tabels'); ?>" class="btn btn-secondary mt-3">Back</a>
</div>

<?php $this->load->view('footer'); ?>
