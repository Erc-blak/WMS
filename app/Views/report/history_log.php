<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventory History Log</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <h1>Inventory History Log</h1>
    <p><a href="/">← Back to Home</a></p>

    <table>
        <thead>
            <tr>
                <th>Item Name (SKU)</th>
                <th>Action</th>
                <th>Notes</th>
                <th>Timestamp</th>
            </tr>
        </thead>
        <tbody>
            <?php if (! empty($history) && is_array($history)): ?>
            <?php foreach ($history as $record): ?>
                <tr>
                    <td><?= esc($record['name']) ?> (<?= esc($record['sku']) ?>)</td>
                    <td><?= esc($record['action']) ?></td>
                    <td><?= esc($record['notes']) ?></td>
                    <td><?= esc($record['created_at']) ?></td>
                </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr>
                <td colspan="4">No history found.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>