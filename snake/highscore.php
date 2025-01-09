<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();
require("../connect.php");

if (!isset($_SESSION["id"])) {
    header("Location: ../login.php");
    exit();
}

$stmt = $kapcsolat->prepare("SELECT username, score FROM user ORDER BY score DESC");
$stmt->execute();
$highscores = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="highscore_style.css">
    <title>Snake Game - Highscores</title>
</head>
<body>
    <div class="menu-container">
        <div class="image-container">
            <div class="menu-title">
                <h1>Highscores</h1>
            </div>
            <div class="highscore-list">
                <ol>
                    <?php foreach ($highscores as $highscore): ?>
                        <li>
                            <span class="username"><?php echo htmlspecialchars($highscore['username']); ?></span>
                            <span class="score"><?php echo htmlspecialchars($highscore['score']); ?></span>
                        </li>
                    <?php endforeach; ?>
                </ol>
            </div>
        </div>
        <div class="button-container">
            <button class="back-button" onclick="goBack()">Back to Menu</button>
        </div>
    </div>

    <script>
        function goBack() {
            window.location.href = "index.php";
        }
    </script>
</body>
</html>

