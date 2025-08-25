<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Warehouse Location</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <h1>Add New Warehouse Location</h1>

    <?php if (session()->getFlashdata('errors')): ?>
        <p style="color:red;">Please correct the following errors:</p>
        <ul>
        <?php foreach (session()->getFlashdata('errors') as $error): ?>
            <li style="color:red;"><?= esc($error) ?></li>
        <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="/warehouse-layout/save" method="post">
        <?= csrf_field() ?>
        
        <label for="location_code">Location Code:</label><br>
        <input type="text" id="location_code" name="location_code" value="<?= old('location_code') ?>" required><br><br>

        <label for="aisle">Aisle:</label><br>
        <input type="text" id="aisle" name="aisle" value="<?= old('aisle') ?>" required><br><br>

        <label for="shelf">Shelf:</label><br>
        <input type="text" id="shelf" name="shelf" value="<?= old('shelf') ?>" required><br><br>

        <input type="submit" value="Add Location">
    </form>
</body>
</html>