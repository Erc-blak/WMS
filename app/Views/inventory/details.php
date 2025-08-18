<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventory Item Details</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <h1>Item Details: <?= esc($item['name']) ?></h1>

    <div>
        <p><strong>SKU:</strong> <?= esc($item['sku']) ?></p>
        <p><strong>Quantity:</strong> <?= esc($item['quantity']) ?></p>
        <p><strong>Location:</strong> <?= esc($item['location']) ?></p>
        <p><strong>Last Updated:</strong> <?= esc($item['updated_at']) ?></p>
    </div>

    <h2>History Log</h2>
    <table>
        <thead>
            <tr>
                <th>Action</th>
                <th>Notes</th>
                <th>Timestamp</th>
            </tr>
        </thead>
        <tbody>
            <?php if (! empty($history) && is_array($history)): ?>
            <?php foreach ($history as $record): ?>
                <tr>
                    <td><?= esc($record['action']) ?></td>
                    <td><?= esc($record['notes']) ?></td>
                    <td><?= esc($record['created_at']) ?></td>
                </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr>
                <td colspan="3">No history found for this item.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <p><a href="/inventory">← Back to Inventory List</a></p>
</body>
</html>