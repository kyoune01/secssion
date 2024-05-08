<?php
declare(strict_types=1);

session_start();

if (!isset($_SESSION['name'])) {
    header("Location:/login.php");
    exit;
}

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location:/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
</head>
<body>
    <p>Hello, <?= $_SESSION['name'] ?> !!</p>
    <p>Hello, <?= htmlspecialchars($_SESSION['name']) ?> !!</p>
    <form action="" method="post">
        <input type="hidden" name="logout">
        <input type="submit" value="logout">
    </form>
</body>
</html>