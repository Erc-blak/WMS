<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create New Order</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <h1>Create New Order</h1>

    <?php if (session()->getFlashdata('errors')): ?>
        <p style="color:red;">Please correct the following errors:</p>
        <ul>
        <?php foreach (session()->getFlashdata('errors') as $error): ?>
            <li style="color:red;"><?= esc($error) ?></li>
        <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="/order/save" method="post">
        <?= csrf_field() ?>

        <label for="customer_name">Customer Name:</label><br>
        <input type="text" id="customer_name" name="customer_name" value="<?= old('customer_name') ?>" required><br><br>

        <h2>Select Items</h2>
        <?php if (! empty($items) && is_array($items)): ?>
            <?php foreach ($items as $item): ?>
                <div style="margin-bottom: 10px;">
                    <input type="hidden" name="item_ids[]" value="<?= esc($item['id']) ?>">
                    <label for="quantity_<?= esc($item['id']) ?>"><?= esc($item['name']) ?> (SKU: <?= esc($item['sku']) ?>):</label>
                    <input type="number" id="quantity_<?= esc($item['id']) ?>" name="quantities[]" min="0" value="0" style="width: 60px;">
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No inventory items available to add to an order. Please add some first.</p>
        <?php endif; ?>
        
        <br>
        <input type="submit" value="Create Order">
    </form>
</body>
</html>