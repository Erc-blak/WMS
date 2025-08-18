<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>WMS Inventory List</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <h1>Inventory List</h1>

    <?php if (session()->getFlashdata('success')): ?>
        <p style="color:green;"><?= session()->getFlashdata('success') ?></p>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <p style="color:red;"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>

    <p>
        <a href="/inventory/add">Add New Item</a> | 
        <a href="/report/export-inventory-csv">Export to CSV</a>
    </p>

    <table>
        <thead>
            <tr>
                <th>SKU</th>
                <th>Name</th>
                <th>Quantity</th>
                <th>Location</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (! empty($items) && is_array($items)): ?>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= esc($item['sku']) ?></td>
                    <td><?= esc($item['name']) ?></td>
                    <td><?= esc($item['quantity']) ?></td>
                    <td><?= esc($item['location']) ?></td>
                    <td>
                        <a href="/inventory/details/<?= esc($item['id']) ?>">View</a>
                        <a href="/inventory/edit/<?= esc($item['id']) ?>">Edit</a>
                        <form action="/inventory/delete/<?= esc($item['id']) ?>" method="post" style="display:inline;">
                            <?= csrf_field() ?>
                            <button type="submit" onclick="return confirm('Are you sure you want to delete this item?');">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr>
                <td colspan="5">No inventory items found.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>