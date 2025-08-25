<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>WMS Dashboard</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <h1>Welcome, <?= esc($username) ?>!</h1>
    <p>You are logged in as a user with role ID: <?= esc($role_id) ?></p>

    <h2>Main Menu</h2>
    <ul>
        <li><a href="/inventory">Inventory Management</a></li>
        <li><a href="/order">Order Management</a></li>
        <li><a href="/report">Reports & Tracking</a></li>
        <li><a href="/warehouse-layout">Warehouse Layout</a></li>
        <li><a href="/scan">Barcode Scanning</a></li>
    </ul>

    <p><a href="/logout">Logout</a></p>
</body>
</html>