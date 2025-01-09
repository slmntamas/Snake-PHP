<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require('connect.php');
    
    $stmt = $kapcsolat->prepare("SELECT COUNT(*) FROM user WHERE username = :username");
    $stmt->execute([ 'username' => $_POST['username'] ]);
    $userExists = $stmt->fetchColumn();

    if ($userExists > 0) {
        $_SESSION['error'] = "A felhasználónév már foglalt!";
    } else {
        $kapcsolat->prepare("INSERT INTO user (username, password) VALUES (:username, :password)")
            ->execute([
                'username' => $_POST['username'],
                'password' => md5($_POST['password']),
            ]);
        
        $_SESSION['error'] = "";
        header("Location: login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <title>Snake Game Regisztráció</title>
</head>
<body>
    <div class="login-container">
        <form method="post">
            <label for="username">Felhasználónév:</label>
            <input type="text" name="username" id="username" required><br>
            <label for="password">Jelszó:</label>
            <input type="password" name="password" id="password" required><br>
            <input type="submit" class="submit-button" value="Regisztráció">
        </form>

        <a href="login.php" class="back-button">Vissza</a>

        <?php if (isset($_SESSION['error']) && $_SESSION['error'] != ""): ?>
            <div id="error-message" class="error-message">
                <?php echo $_SESSION['error']; ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
    </div>
</body>
</html>
