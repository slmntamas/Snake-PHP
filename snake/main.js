const canvas = document.getElementById("gameCanvas");
const ctx = canvas.getContext("2d");
const scoreElement = document.getElementById("score");
const restartButton = document.getElementById("restartButton");
const startMessage = document.getElementById("startMessage");

const cellSize = 30;
const gridSize = canvas.width / cellSize;
let game;
let gameInterval;
let isPaused = true;
let isGameStarted = false;
const eatSound = new Audio('score.mp3');
const gameOverSound = new Audio("game_over.mp3");
const muteButton = document.getElementById("muteButton");
let isMuted = false;
let isGameOver = false;

function startGame() {
    game = new Game(gridSize);
    clearInterval(gameInterval);
    gameInterval = null;
    updateScore();
    isPaused = true;
    isGameStarted = false;
    isGameOver = false;
    startMessage.style.display = 'none';
    gameOverMessage.style.display = 'none';
    pauseMessage.style.display = 'none';

    draw();
}

function gameLoop() {
    if (isPaused) return;

    if (!game.update()) {
        clearInterval(gameInterval);
        isGameOver = true;
        if (!isMuted) {
            gameOverSound.play();
        }
        gameOverMessage.style.display = 'block';
        

        saveScore(game.getScore());
        return;
    }
    draw();
    updateScore();
}

function draw() {
    ctx.fillStyle = "#acff33";
    ctx.fillRect(0, 0, canvas.width, canvas.height);
    
    ctx.strokeStyle = "#69b200";
    for (let x = 0; x < canvas.width; x += cellSize) {
        for (let y = 0; y < canvas.height; y += cellSize) {
            ctx.strokeRect(x, y, cellSize, cellSize);
        }
    }

    ctx.fillStyle = "blue";
    game.snake.body.forEach(segment => {
        ctx.fillRect(segment.x * cellSize, segment.y * cellSize, cellSize, cellSize);
    });

    ctx.fillStyle = "red";
    ctx.fillRect(game.food.x * cellSize, game.food.y * cellSize, cellSize, cellSize);
}

function updateScore() {
    scoreElement.textContent = game.getScore();
}

function initializeGameState() {
    isPaused = true;
    isGameStarted = false;
}

document.addEventListener("keydown", (event) => {
    if (!isGameStarted && (event.key === "ArrowUp" || event.key === "ArrowDown" || event.key === "ArrowLeft" || event.key === "ArrowRight")) {
        startMessage.style.display = 'none';
        isGameStarted = true;
        isPaused = false;

        switch (event.key) {
            case "ArrowUp":
                game.snake.setDirection(Direction.UP);
                break;
            case "ArrowDown":
                game.snake.setDirection(Direction.DOWN);
                break;
            case "ArrowLeft":
                game.snake.setDirection(Direction.LEFT);
                break;
            case "ArrowRight":
                game.snake.setDirection(Direction.RIGHT);
                break;
        }

        gameInterval = setInterval(gameLoop, 150);
    } else if (isGameStarted && !isPaused && !isGameOver) {
        switch (event.key) {
            case "ArrowUp":
                game.snake.setDirection(Direction.UP);
                break;
            case "ArrowDown":
                game.snake.setDirection(Direction.DOWN);
                break;
            case "ArrowLeft":
                game.snake.setDirection(Direction.LEFT);
                break;
            case "ArrowRight":
                game.snake.setDirection(Direction.RIGHT);
                break;
        }
    }

    if (event.key === "p" && isGameStarted && !isGameOver && gameInterval !== null) { 
        togglePause();
    }
});
restartButton.addEventListener("click", () => {
    startGame();
    isGameStarted = false;
    startMessage.style.display = 'block'; 
    isPaused = true;
});

function togglePause() {
    if (!isGameStarted || gameInterval === null || isGameOver) return;

    isPaused = !isPaused;
    if (isPaused) {
        clearInterval(gameInterval);
        pauseMessage.style.display = 'block';
    } else {
        pauseMessage.style.display = 'none';
        gameInterval = setInterval(gameLoop, 150);
    }
}

muteButton.addEventListener("click", () => {
    isMuted = !isMuted;
    eatSound.muted = isMuted;

    muteButton.src = isMuted ? "sound_off.png" : "sound_on.png";
});

startGame();
startMessage.style.display = 'block';

function saveScore(score) {
    fetch('../save_score.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `score=${score}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            console.log('Pontszám sikeresen mentve!');
        } else {
            console.error('Hiba történt: ', data.message);
        }
    })
    .catch(error => {
        console.error('Hálózati hiba: ', error);
    });
}