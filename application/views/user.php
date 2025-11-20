<?php $this->load->view('header'); ?>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h3>Edit User</h3>
        </div>
        <div class="card-body">

            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
            <?php endif; ?>

            <?php echo form_open('tabels/update/' . $user->id); ?>

            <div class="mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" id="first_name" name="first_name"
                    class="form-control" value="<?= set_value('first_name', $user->first_name); ?>" required>
            </div>

            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" id="last_name" name="last_name"
                    class="form-control" value="<?= set_value('last_name', $user->last_name); ?>" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email (readonly)</label>
                <input type="email" id="email" name="email"
                    class="form-control" value="<?= $user->email; ?>" readonly>
            </div>

            <label>Status</label>
            <select name="status" class="form-control">
                <option value="1" <?= ((int)$user->status === 1) ? 'selected' : ''; ?>>Active</option>
                <option value="0" <?= ((int)$user->status === 0) ? 'selected' : ''; ?>>Inactive</option>
            </select>


            <button type="submit" class="btn btn-success">Update User</button>
            <a href="<?= site_url('tabels'); ?>" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>

<?php $this->load->view('footer'); ?>