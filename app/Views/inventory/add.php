<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Inventory Item</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <h1>Add New Inventory Item</h1>

    <?php if (session()->getFlashdata('error')): ?>
        <p style="color:red;"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>

    <form action="/inventory/save" method="post">
        <?= csrf_field() ?>
        <label for="sku">SKU:</label><br>
        <input type="text" id="sku" name="sku" required><br><br>

        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required><br><br>

        <label for="quantity">Quantity:</label><br>
        <input type="number" id="quantity" name="quantity" value="0" required><br><br>
        
        <label for="location">Location:</label><br>
        <input type="text" id="location" name="location"><br><br>

        <input type="submit" value="Add Item">
    </form>
</body>
</html>