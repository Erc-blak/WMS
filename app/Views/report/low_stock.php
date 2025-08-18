<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Low Stock Report</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <h1>Low Stock Report</h1>
    <p>Items with a quantity less than 10 are listed below.</p>
    <p><a href="/report">← Back to Reports</a></p>

    <table>
        <thead>
            <tr>
                <th>SKU</th>
                <th>Name</th>
                <th>Current Quantity</th>
                <th>Location</th>
            </tr>
        </thead>
        <tbody>
            <?php if (! empty($low_stock_items) && is_array($low_stock_items)): ?>
            <?php foreach ($low_stock_items as $item): ?>
                <tr>
                    <td><?= esc($item['sku']) ?></td>
                    <td><?= esc($item['name']) ?></td>
                    <td style="color: red; font-weight: bold;"><?= esc($item['quantity']) ?></td>
                    <td><?= esc($item['location']) ?></td>
                </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr>
                <td colspan="4">No items are currently low in stock.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>