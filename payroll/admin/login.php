```php
<?php
session_start();
require_once 'connect.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Please enter your username and password.';
    } else {
        $stmt = $connection->prepare(
            'SELECT id, username, password FROM users WHERE username = ? LIMIT 1'
        );

        if ($stmt) {
            $stmt->bind_param('s', $username);
            $stmt->execute();

            $res = $stmt->get_result();

            if ($res && $row = $res->fetch_assoc()) {
                if ($password === $row['password']) {
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['username'] = $row['username'];

                    header('Location: dashboard.php');
                    exit;
                } else {
                    $error = 'Invalid username or password.';
                }
            } else {
                $error = 'Invalid username or password.';
            }

            $stmt->close();
        } else {
            $error = 'Database error. Please try again.';
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Payroll Admin — Login</title>

    <?php
    $cssV = file_exists(__DIR__ . '/assets/css/styles.css')
        ? filemtime(__DIR__ . '/assets/css/styles.css')
        : time();
    ?>

    <link
        rel="stylesheet"
        href="assets/css/styles.css?v=<?= $cssV ?>"
    >
</head>

<body class="page-login">

    <div id="mobile-overlay" class="mobile-overlay"></div>

    <main class="auth-card">

        <div class="auth-brand">
            <img src="assets/images/lcc.png" alt="logo">

            <div>
                <h1>Payroll Admin</h1>
            </div>
        </div>

        <?php if ($error): ?>
            <div class="alert error">
                <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>

        <form method="post" class="form-auth" autocomplete="off">

            <input
                type="text"
                name="username"
                placeholder="Enter Admin Username"
                required
                autocomplete="username"
                value="<?= htmlspecialchars($_POST['username'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
            >

            <input
                type="password"
                name="password"
                placeholder="Enter Admin Password"
                required
                autocomplete="current-password"
            >

            <button class="btn primary" type="submit">
                Sign in
            </button>

        </form>

    </main>

    <script src="assets/js/script.js"></script>

</body>
</html>
```
