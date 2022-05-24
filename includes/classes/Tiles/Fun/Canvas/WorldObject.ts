import {GameEntity} from "./GameEntity";

export class WorldObject extends GameEntity {
  public collision: boolean;

  constructor(position: any, size: any, color: string, collision: boolean = true) {
    super(position, size);
    this.color = color;
    this.collision = collision;
  }

  public draw(ctx: CanvasRenderingContext2D) {
    ctx.fillStyle = this.color;
    ctx.fillRect(this.position.x, this.position.y, this.size.width, this.size.height);
  }

  public collisionY(obj: GameEntity): void {
    if (this.collision && obj.position.y + obj.size.height > this.position.y && obj.position.x < this.position.x + this.size.width && obj.position.x + obj.size.width > this.position.x) {
      obj.collideY();
    }
  }

  public collideY() {
    if (this.collision) {
      super.velY = 0;
    }
  }
}