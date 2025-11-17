<html>
<head>
    <title>Contact View List</title>
</head>

<body>
    <h1>Contact View List</h1>

    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>Email</th>
            <th>Password</th>
        </tr>

        <?php if (!empty($records)) { ?>
            <?php foreach ($records as $row) { ?>
                <tr>
                    <td><?= $row->id ?></td>
                    <td><?= $row->email ?></td>
                    <td><?= $row->password ?></td>
                </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td colspan="3">No records found</td>
            </tr>
        <?php } ?>
    </table>

</body>
</html>
