<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();
require("../connect.php");

if (!isset($_SESSION["id"])) {
    header("Location: ../login.php");
    exit();
}

$stmt = $kapcsolat->prepare("SELECT score FROM user WHERE id = :id");
$stmt->execute(["id" => $_SESSION["id"]]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$score = $user['score'] ?? 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="menustyle.css">
    <title>Snake Game</title>
</head>
<body>
    <div class="menu-container">
        <div class="image-container">
            <h1 class="menu-title">Snake Game</h1>
            <div class="user-info-box">
                <h2 class="username">
                    <img src="user.png" alt="User Icon" class="user-icon"> 
                    <?php echo htmlspecialchars($_SESSION["username"]); ?>
                </h2>
                <h3 class="user-score">
                    <img src="crown.png" alt="Crown Icon" class="score-icon">
                    <?php echo htmlspecialchars($score); ?>
                </h3>
            </div>
            <img src="letöltés.jpg" alt="Menu Background" class="menu-image">
            <div class="button-container">
                <button class="highscore-button" onclick="showHighscore()">Highscore</button>
                <button class="start-button" onclick="startGame()">Start Game</button>
            </div>
            <div class="logout-container">
                <button class="logout-button" onclick="logout()">
                    <img src="signout.png" alt="Logout Icon" class="logout-icon"> 
                </button>
            </div>

        </div>
    </div>

    <div class="github-button-container">
        <a href="https://github.com/slmntamas/Snake-Game" target="_blank" class="github-button">View on GitHub</a>
    </div>

    <script>
        function startGame() {
            window.location.href = "game.php";
        }

        function showHighscore() {
            window.location.href = "highscore.php";
        }

        function logout() {
            window.location.href = "logout.php";
        }
    </script>
</body>
</html>
