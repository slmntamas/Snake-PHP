class Game {
    constructor(gridSize) {
        this.gridSize = gridSize;
        this.snake = new Snake(gridSize);
        this.food = this.placeFood();
        this.score = 0;
    }

    placeFood() {
        let x, y;
        do {
            x = Math.floor(Math.random() * this.gridSize);
            y = Math.floor(Math.random() * this.gridSize);
        } while (this.snake.collidesWith({ x, y }));
        return { x, y };
    }

    update() {
        this.snake.move();

        if (this.snake.collidesWithItself() ||
            this.snake.body[0].x < 0 || this.snake.body[0].x >= this.gridSize ||
            this.snake.body[0].y < 0 || this.snake.body[0].y >= this.gridSize) {
            return false;
        }

        if (this.snake.body[0].x === this.food.x && this.snake.body[0].y === this.food.y) {
            this.snake.grow();
            this.food = this.placeFood();
            this.score++;
            eatSound.play();
        }
        return true;
    }

    getScore() {
        return this.score;
    }
}
