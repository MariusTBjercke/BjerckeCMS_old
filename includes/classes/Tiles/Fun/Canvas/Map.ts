import {GameEntity} from "./GameEntity";

export class Map extends GameEntity {
  public image: HTMLImageElement;
  public dx: number;
  public dy: number;

  constructor(position: any, size: any, image: HTMLImageElement) {
    super(position, size);
    this.image = image;
    this.dx = 0;
    this.dy = 0;
  }

  public collideY(): void {
  }

  public draw(ctx: CanvasRenderingContext2D): void {
    ctx.drawImage(this.image, this.position.x, this.position.y, this.size.width, this.size.height, this.dx, this.dy, this.size.width, this.size.height);
  }

}