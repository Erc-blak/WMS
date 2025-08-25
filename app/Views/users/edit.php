<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <h1>Edit User</h1>

    <?php if (session()->getFlashdata('errors')): ?>
        <p style="color:red;">Please correct the following errors:</p>
        <ul>
        <?php foreach (session()->getFlashdata('errors') as $error): ?>
            <li style="color:red;"><?= esc($error) ?></li>
        <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="/users/update/<?= esc($user['id']) ?>" method="post">
        <?= csrf_field() ?>
        
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" value="<?= old('username', $user['username']) ?>" required><br><br>

        <label for="password">New Password (optional):</label><br>
        <input type="password" id="password" name="password"><br><br>

        <label for="role_id">Role:</label><br>
        <select id="role_id" name="role_id" required>
            <?php foreach ($roles as $role): ?>
                <option value="<?= esc($role['id']) ?>" <?= (old('role_id', $user['role_id']) == $role['id']) ? 'selected' : '' ?>>
                    <?= esc($role['name']) ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <input type="submit" value="Update User">
    </form>
</body>
</html>