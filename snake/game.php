<?php
error_reporting(E_ALL);
ini_set("display_errors",1);
session_start();
require("../connect.php");
if (!isset($_SESSION["id"])) {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="url=index.html" />
    <title>Snake Game</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="gameContainer">
        <h1>Snake Game</h1>
        <h2 class="username">
            <img src="user.png" alt="User Icon" class="user-icon"> 
            <?php echo htmlspecialchars($_SESSION["username"]); ?>
        </h2>

        <canvas id="gameCanvas" width="600" height="600"></canvas>
        <div id="startMessage">
            Press any arrow key to start
            <div id="startImagesContainer">
                <img src="arrows6.png" id="arrows" alt="arrows" />
                <img src="p4.png" id="p_key" alt="p key" />
            </div>        
        </div>
        <div id="gameOverMessage" class="message">Game Over</div>
        <div id="pauseMessage" class="message">Paused</div>
        <div id="scoreContainer">
            <p>Score: <span id="score">0</span></p>
        </div>
        <button id="restartButton"><b>Restart</b></button>
        <img id="muteButton" src="sound_on.png" alt="Mute Button" />
        <img id="backButton" src="left_arrow.png" alt="Back to Menu Button" />
    </div>

    <script>
        document.getElementById('backButton').addEventListener('click', () => {
            window.location.href = 'index.php';
        });
    </script>
    <script src="snake.js"></script>
    <script src="game.js"></script>
    <script src="main.js"></script>
</body>
</html>
