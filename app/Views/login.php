<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>WMS Login</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <h1>Warehouse Management System</h1>
    <h2>Login</h2>

    <?php if (session()->getFlashdata('msg')): ?>
        <p style="color:red;"><?= session()->getFlashdata('msg') ?></p>
    <?php endif; ?>

    <form action="/login/auth" method="post">
        <?= csrf_field() ?>
        
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Login">
    </form>
</body>
</html>
