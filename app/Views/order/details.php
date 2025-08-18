<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Details</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <h1>Order Details: #<?= esc($order['id']) ?></h1>

    <div>
        <p><strong>Customer Name:</strong> <?= esc($order['customer_name']) ?></p>
        <p><strong>Status:</strong> <?= esc($order['status']) ?></p>
        <p><strong>Created At:</strong> <?= esc($order['created_at']) ?></p>
    </div>

    <h2>Order Items</h2>
    <table>
        <thead>
            <tr>
                <th>Item Name</th>
                <th>SKU</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
            <?php if (! empty($items) && is_array($items)): ?>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= esc($item['name']) ?></td>
                    <td><?= esc($item['sku']) ?></td>
                    <td><?= esc($item['quantity']) ?></td>
                </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr>
                <td colspan="3">No items found for this order.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <p><a href="/order">← Back to Order List</a></p>
</body>
</html>