<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>WMS Order List</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <h1>Order List</h1>

    <p><a href="/order/add">Create New Order</a></p>

    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Status</th>
                <th>Created Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (! empty($orders) && is_array($orders)): ?>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= esc($order['id']) ?></td>
                    <td><?= esc($order['customer_name']) ?></td>
                    <td><?= esc($order['status']) ?></td>
                    <td><?= esc($order['created_at']) ?></td>
                    <td><a href="/order/details/<?= esc($order['id']) ?>">View</a></td>
                </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr>
                <td colspan="5">No orders found.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>