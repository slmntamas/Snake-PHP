<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();
    require('connect.php');
    
    $stmt = $kapcsolat->prepare("SELECT id, username, score FROM user WHERE username = :username AND password = :password");
    $stmt->execute([
        "username" => $_POST["username"],
        "password" => md5($_POST["password"])
    ]);
    
    $user_id = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user_id != null) {
        $_SESSION["id"] = $user_id['id'];
        $_SESSION["username"] = $user_id['username'];
        $_SESSION["score"] = $user_id['score'];
        header("Location: snake/index.php");
        exit();
    } else {
        $_SESSION['error'] = "Hibás felhasználónév vagy jelszó.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <title>Snake Game Bejelentkezés</title>
</head>
<body>
    <div class="login-container">
        <form method="post">
            <label for="username">Felhasználónév:</label>
            <input type="text" name="username" id="username" required><br>
            <label for="password">Jelszó:</label>
            <input type="password" name="password" id="password" required><br>
            <input type="submit" value="Bejelentkezés">
            <input type="button" class="register-button" onclick="window.location.href='reg.php'" value="Regisztráció">
        </form>

        <?php if (isset($_SESSION['error']) && $_SESSION['error'] != ""): ?>
            <div id="error-message" class="error-message">
                <?php echo $_SESSION['error']; ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
    </div>
</body>
</html>
