<style>
/* Basic styling for dropdowns */
th {
    position: relative; /* relative for dropdown positioning */
}

.card-body.table-responsive {
    overflow: visible !important; /* allow dropdown to overflow */
    position: relative;
}

.column-filter-dropdown {
    display: none;
    position: absolute;
    top: 25px;
    left: 0;
    background: #fff;
    border: 1px solid #ccc;
    padding: 10px;
    z-index: 1050 !important;
    min-width: 200px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    border-radius: 5px;
}

.filter-triangle {
    cursor: pointer;
    margin-left: 5px;
    font-size: 0.8rem;
}

.column-filter-dropdown label,
.column-filter-dropdown select,
.column-filter-dropdown input {
    display: block;
    margin-bottom: 5px;
    width: 100%;
}

.column-filter-dropdown button {
    margin-top: 5px;
    width: 48%;
}

.column-filter-buttons {
    display: flex;
    justify-content: space-between;
    gap: 4%;
}
</style>

<?php
$data['title'] = "Simple Tables | AdminLTE";
$this->load->view('header', $data);
?>

<body class="layout-fixed fixed-header fixed-footer sidebar-expand-lg bg-body-tertiary">

<div class="app-wrapper">

    <?php $this->load->view('navigation/headernav', $data); ?>
    <?php $this->load->view('navigation/sidebar', $data); ?>

    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Simple Tables</h3>

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

        <div class="app-content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body table-responsive p-0">

                        <table class="table table-bordered table-striped text-nowrap">
                            <thead class="table-dark">
                                <tr>
                                    <?php
                                    // Define columns and labels
                                    $columns = [
                                        'id' => 'ID',
                                        'first_name' => 'First Name',
                                        'last_name' => 'Last Name',
                                        'full_name' => 'Full Name',
                                        'email' => 'Email',
                                        'country_code' => 'Country Code',
                                        'phone' => 'Phone',
                                        'role' => 'Role',
                                        'status' => 'Status',
                                        'created_at' => 'Created At',
                                        'action' => 'Action'
                                    ];
                                    foreach($columns as $field => $label):
                                    ?>
                                        <th style="position: relative;">
                                            <?= $label ?>
                                            <?php if($field != 'action'): ?>
                                                <span class="filter-triangle">&#9662;</span>
                                                <div class="column-filter-dropdown">
                                                    <label>Field:</label>
                                                    <select class="filter-field">
                                                        <option value="<?= $field ?>" selected><?= $label ?></option>
                                                    </select>

                                                    <label>Operator:</label>
                                                    <select class="filter-operator">
                                                        <option value="=">Equal To</option>
                                                        <option value="!=">Not Equal To</option>
                                                        <option value="contains">Contains</option>
                                                    </select>

                                                    <label>Value:</label>
                                                    <input type="text" class="filter-value" placeholder="Enter value">

                                                    <div class="column-filter-buttons">
                                                        <button class="apply-filter btn btn-sm btn-primary">Search</button>
                                                        <button class="cancel-filter btn btn-sm btn-secondary">Cancel</button>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </th>
                                    <?php endforeach; ?>
                                </tr>
                            </thead>

                            <tbody>
                                <?php if(!empty($users)): ?>
                                    <?php foreach($users as $u):
                                        $logged = $logged_user;
                                        $isOwner = ($logged->id == $u->id);
                                        $role = strtolower($logged->role);
                                    ?>
                                    <tr>
                                        <td><?= html_escape("VV-" . str_pad($u->id, 4, "0", STR_PAD_LEFT)); ?></td>
                                        <td><?= html_escape($u->first_name); ?></td>
                                        <td><?= html_escape($u->last_name); ?></td>
                                        <td><?= html_escape($u->first_name . ' ' . $u->last_name); ?></td>
                                        <td><?= html_escape($u->email); ?></td>
                                        <td><?= html_escape($u->country_code); ?></td>
                                        <td><?= html_escape($u->phone); ?></td>
                                        
                                        <td><?= html_escape(ucfirst($u->role ?? 'customer')); ?></td>
                                        <td>
                                            <?php if($u->status==1): ?>
                                                <span class="badge bg-success">Active</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Inactive</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= html_escape(date('d-m-Y H:i', strtotime($u->created_at))); ?></td>
                                        <td>
                                            <?php if($role==='admin'): ?>
                                                <a href="<?= site_url('tabels/edit/'.$u->id); ?>" class="btn btn-sm btn-primary">Edit</a>
                                                <a href="<?= site_url('tabels/view/'.$u->id); ?>" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                                                <a href="<?= site_url('tabels/delete/'.$u->id); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');">Delete</a>
                                            <?php elseif($role==='manager'): ?>
                                                <a href="<?= site_url('tabels/view/'.$u->id); ?>" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                                                <?php if($isOwner): ?>
                                                    <a href="<?= site_url('tabels/edit/'.$u->id); ?>" class="btn btn-sm btn-primary">Edit</a>
                                                    <a href="<?= site_url('tabels/delete/'.$u->id); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');">Delete</a>
                                                <?php endif; ?>
                                            <?php elseif($role==='customer'): ?>
                                                <?php if($isOwner): ?>
                                                    <a href="<?= site_url('tabels/view/'.$u->id); ?>" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                                                    <a href="<?= site_url('tabels/edit/'.$u->id); ?>" class="btn btn-sm btn-primary">Edit</a>
                                                    <a href="<?= site_url('tabels/delete/'.$u->id); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');">Delete</a>
                                                <?php else: ?>
                                                    <span class="text-muted">No Access</span>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="11" class="text-center">No users found</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>

                        <div class="mt-3"><?= $pagination ?? ''; ?></div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php $this->load->view('navigation/footer'); ?>

</div>

<?php $this->load->view('footer', $data); ?>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<script>
$(document).ready(function(){
    // Toggle column filter
    $('.filter-triangle').click(function(e){
        e.stopPropagation();
        $('.column-filter-dropdown').hide(); // hide others
        $(this).closest('th').find('.column-filter-dropdown').toggle();
    });

    // Close when clicking outside
    // $(document).click(function(){
    //     $('.column-filter-dropdown').hide();
    // });

    // Apply filter button
$('.apply-filter').click(function(e){
    e.preventDefault();

    let $dropdown = $(this).closest('.column-filter-dropdown');
    let field = $dropdown.find('.filter-field').val();
    let operator = $dropdown.find('.filter-operator').val();
    let value = $dropdown.find('.filter-value').val();

    // CSRF Token Fetch
    let csrfName = $('meta[name="csrf-token-name"]').attr('content');
    let csrfHash = $('meta[name="csrf-token-hash"]').attr('content');

    let postData = {};
    postData['field'] = field;
    postData['operator'] = operator;
    postData['value'] = value;
    postData[csrfName] = csrfHash;   // ADD TOKEN

    $.ajax({
        url: "<?= site_url('tabels/filter_column'); ?>",
        type: "POST",
        dataType: "json",
        data: postData,
        success: function(res){
            if (res.status === 'success') {
                $('table tbody').html(res.html);
            } else {
                $('table tbody').html('<tr><td colspan="11" class="text-center">'+res.message+'</td></tr>');
            }

            // Update CSRF token for next request
            $('meta[name="csrf-token-hash"]').attr('content', res.newToken);

            $dropdown.hide();
        },
        error: function(xhr){
            alert("AJAX ERROR: " + xhr.status + " " + xhr.statusText);
            $dropdown.hide();
        }
    });
});

    // Cancel filter button
    $('.cancel-filter').click(function(e){
        e.preventDefault();
        let $dropdown = $(this).closest('.column-filter-dropdown');
        $dropdown.find('.filter-value').val('');
        $dropdown.hide();
    });
});
</script>
