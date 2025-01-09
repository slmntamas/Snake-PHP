const Direction = {
    UP: { x: 0, y: -1 },
    DOWN: { x: 0, y: 1 },
    LEFT: { x: -1, y: 0 },
    RIGHT: { x: 1, y: 0 }
};

class Snake {
    constructor(gridSize) {
        this.gridSize = gridSize;
        this.body = [{ x: Math.floor(gridSize / 2), y: Math.floor(gridSize / 2) }];
        this.direction = Direction.RIGHT;
        this.growNextMove = false;
    }

    setDirection(newDirection) {
        if (newDirection.x + this.direction.x !== 0 || newDirection.y + this.direction.y !== 0) {
            this.direction = newDirection;
        }
    }

    move() {
        const newHead = {
            x: this.body[0].x + this.direction.x,
            y: this.body[0].y + this.direction.y
        };

        this.body.unshift(newHead);

        if (!this.growNextMove) {
            this.body.pop();
        } else {
            this.growNextMove = false;
        }
    }

    grow() {
        this.growNextMove = true;
    }

    collidesWithItself() {
        return this.body.slice(1).some(segment => segment.x === this.body[0].x && segment.y === this.body[0].y);
    }

    collidesWith(point) {
        return this.body.some(segment => segment.x === point.x && segment.y === point.y);
    }
}
