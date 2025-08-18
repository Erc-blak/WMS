<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Inventory Item</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <h1>Edit Inventory Item: <?= esc($item['name']) ?></h1>

    <?php if (session()->getFlashdata('error')): ?>
        <p style="color:red;"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>

    <form action="/inventory/update/<?= esc($item['id']) ?>" method="post">
        <?= csrf_field() ?>
        <label for="sku">SKU:</label><br>
        <input type="text" id="sku" name="sku" value="<?= esc($item['sku']) ?>" required><br><br>

        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" value="<?= esc($item['name']) ?>" required><br><br>

        <label for="quantity">Quantity:</label><br>
        <input type="number" id="quantity" name="quantity" value="<?= esc($item['quantity']) ?>" required><br><br>
        
        <label for="location">Location:</label><br>
        <input type="text" id="location" name="location" value="<?= esc($item['location']) ?>"><br><br>

        <input type="submit" value="Update Item">
    </form>
</body>
</html>