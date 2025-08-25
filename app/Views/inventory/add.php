<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Inventory Item</title>
    <!-- Embedded CSS for a clean form layout -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #e2e8f0;
            margin: 0;
            padding: 2rem;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }
        .form-container {
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }
        h1 {
            color: #1f2937;
            text-align: center;
            margin-bottom: 1.5rem;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #4b5563;
            font-weight: 600;
        }
        input[type="text"],
        input[type="number"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 1rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.2s ease-in-out;
        }
        input[type="text"]:focus,
        input[type="number"]:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.3);
        }
        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #2563eb;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease-in-out;
        }
        input[type="submit"]:hover {
            background-color: #1d4ed8;
        }
        .error-container {
            background-color: #fecaca;
            color: #b91c1c;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Add New Inventory Item</h1>
        
        <!-- This PHP block checks for and displays validation errors -->
        <?php if (isset($validation)): ?>
            <div class="error-container">
                <?= $validation->listErrors() ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('inventory/create') ?>" method="post">
            <!-- This CSRF field is crucial for security -->
            <?= csrf_field() ?>
            
            <label for="sku">SKU:</label>
            <!-- The old() function re-fills the form with user input after an error -->
            <input type="text" id="sku" name="sku" value="<?= old('sku') ?>" required>
            
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?= old('name') ?>" required>
            
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" value="<?= old('quantity', 0) ?>" required>
            
            <label for="location">Location:</label>
            <input type="text" id="location" name="location" value="<?= old('location') ?>">
            
            <input type="submit" value="Add Item">
        </form>
    </div>
</body>
</html>
