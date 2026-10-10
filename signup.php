<?php

// ---------- DATABASE CONNECTION ----------
$dsn = 'mysql:host=localhost;port=3306;dbname=myapp;charset=utf8mb4';
$pdo = new PDO($dsn, 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// ---------- STATE ----------
$errors = [];
$name   = '';
$city   = '';
$age    = '';
$saved  = false;

// ---------- HANDLE POST ----------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $age  = $_POST['age'] ?? null;

    // Validation
    if ($name === '') $errors['name'] = 'Name is required';
    if ($city === '') $errors['city'] = 'City is required';

    // Insert with prepared statement
    if (empty($errors)) {
        $stmt = $pdo->prepare('INSERT INTO users (name, age, city) VALUES (?, ?, ?)');
        $stmt->execute([$name, $age ?: null, $city]);
        $saved = true;
    }
}

// ---------- FETCH ALL USERS ----------
$users = $pdo->query('SELECT name, age, city FROM users ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
</head>
<body>
    <h1>Sign Up</h1>

    <?php if (!empty($errors)): ?>
        <ul style="color:red">
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php if ($saved): ?>
        <p>
            Welcome <?= htmlspecialchars($name) ?> from <?= htmlspecialchars($city) ?>!
        </p>
    <?php endif; ?>

    <form method="POST">
        <p>
            <label>Name</label><br>
            <input name="name" placeholder="Sara" value="<?= htmlspecialchars($name) ?>">
        </p>
        <p>
            <label>Age</label><br>
            <input name="age" type="number" placeholder="22" value="<?= htmlspecialchars($age) ?>">
        </p>
        <p>
            <label>City</label><br>
            <input name="city" placeholder="Dhaka" value="<?= htmlspecialchars($city) ?>">
        </p>
        <button type="submit">Sign Up</button>
    </form>

    <hr>

    <h2>All Users</h2>

    <?php if (empty($users)): ?>
        <p>No users yet. Be the first!</p>
    <?php else: ?>
        <ul>
            <?php foreach ($users as $user): ?>
                <li>
                    <strong><?= htmlspecialchars($user['name']) ?></strong>
                    from <?= htmlspecialchars($user['city']) ?>
                    <?php if (!empty($user['age'])): ?>
                        (<?= htmlspecialchars($user['age']) ?>)
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>