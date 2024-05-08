<?php
declare(strict_types=1);

if (!empty($_POST['name']) && !empty($_POST['pass'])) {
    session_start();
    session_regenerate_id();
    $_SESSION['name'] = $_POST['name'];
    $_SESSION['pass'] = $_POST['pass'];
    header("Location:/");
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
    <form action="" method="post">
        <div style="display: grid; grid-template-columns: 50px 1fr;">
            <label for="name">name</label>
            <input type="text" name="name" id="name">
            <label for="pass">pass</label>
            <input type="password" name="pass" id="pass">
        </div>
        <input type="submit" value="login">
    </form>
</body>
</html>
