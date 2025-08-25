<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Warehouse Layout</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <h1>Warehouse Locations</h1>
    <p><a href="/warehouse-layout/add">Add New Location</a></p>

    <?php if (session()->getFlashdata('success')): ?>
        <p style="color:green;"><?= session()->getFlashdata('success') ?></p>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <p style="color:red;"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Location Code</th>
                <th>Aisle</th>
                <th>Shelf</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (! empty($locations) && is_array($locations)): ?>
            <?php foreach ($locations as $location): ?>
                <tr>
                    <td><?= esc($location['location_code']) ?></td>
                    <td><?= esc($location['aisle']) ?></td>
                    <td><?= esc($location['shelf']) ?></td>
                    <td>
                        <a href="/warehouse-layout/edit/<?= esc($location['id']) ?>">Edit</a>
                        <form action="/warehouse-layout/delete/<?= esc($location['id']) ?>" method="post" style="display:inline;">
                            <?= csrf_field() ?>
                            <button type="submit" onclick="return confirm('Are you sure you want to delete this location?');">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr>
                <td colspan="4">No locations found.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>