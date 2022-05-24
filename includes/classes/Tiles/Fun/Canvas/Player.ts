import {Sprite} from './Sprite';
import {GameEntity} from "./GameEntity";

export class Player extends GameEntity {
  private readonly keys: Array<string>;
  private readonly walkSpeed: number;
  private readonly runSpeed: number;

  constructor(position: any, size: any) {
    super(position, size);
    this.moveSpeed = 3;
    this.walkSpeed = this.moveSpeed;
    this.runSpeed = 10;
    this.friction = 0.85;
    this.gravity = 0.85;
    this.grounded = false;
    this.keys = [];
    this.init();
  }

  public update(): void {
    this.playerMovement();
    this.worldBoundsCheck();
  }

  public collideY(): void {
    this.velY = 0;
  }

  public collideX() {
    this.velX = 0;
  }

  private initGravity(): void {
    if (!this.grounded) {
      this.velY += this.gravity;
    }
  }

  private playerMovement() {

    // Running
    if (this.keys["Shift"]) {
      this.moveSpeed = this.runSpeed;
    } else {
      this.moveSpeed = this.walkSpeed;
    }

    if (this.keys["ArrowLeft"]) {
      if (this.velX > -this.moveSpeed) {
        this.velX--;
      }
      this.flipX = true;
    }

    if (this.keys["ArrowRight"]) {
      if (this.velX < this.moveSpeed) {
        this.velX++;
      }
      this.flipX = false;
    }

    if (this.keys["ArrowUp"]) {
      if (this.velY > -this.moveSpeed) {
        this.velY--;
      }
    }

    if (this.keys["ArrowDown"]) {
      if (this.grounded) return;

      if (this.velY < this.moveSpeed) {
        this.velY++;
      }
    }

    this.position.x += this.velX;
    this.position.y += this.velY;

    // Friction
    this.velX *= this.friction;
    this.velY *= this.friction;
  }

  public setSprite(sprite: Sprite) {
    this.sprite = sprite;
  }

  public setContext(ctx: CanvasRenderingContext2D) {
    this.ctx = ctx;
  }

  public init() {
    this.eventListeners();
  }

  public worldBoundsCheck() {
    if (this.position.x > this.ctx.canvas.width + this.size.width) {
      this.position.x = -this.size.width * 1.5;
    } else if (this.position.x < -this.size.width * 1.5) {
      this.position.x = this.ctx.canvas.width + this.size.width;
    }
  }

  public eventListeners() {
    document.addEventListener("keydown", (e) => {
      this.keys[e.key] = true;
    });

    document.addEventListener("keyup", (e) => {
      this.keys[e.key] = false;
    });
  }

  public setMoveSpeed(amount: number) {
    this.moveSpeed = amount;
  }

  public draw(ctx: CanvasRenderingContext2D) {
    if (this.flipX) {
      ctx.save();
      ctx.scale(-1, 1);
      ctx.drawImage(this.sprite.image, -this.position.x - this.size.width, this.position.y, this.sprite.width, this.sprite.height);
      ctx.restore();
    } else {
      ctx.drawImage(this.sprite.image, this.position.x, this.position.y, this.sprite.width, this.sprite.height);
    }
  }

}