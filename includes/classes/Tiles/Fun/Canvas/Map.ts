import {GameEntity} from "./GameEntity";
import {Collision} from "./Collision";

export class Map extends GameEntity {
  public image: HTMLImageElement;
  public dx: number;
  public dy: number;
  public data: any;
  public collisionObjects: Collision[] = [];
  public offset: {x: number, y: number};

  constructor(position: any, size: any, image: HTMLImageElement, data: any, offset: {x: number, y: number}) {
    super(position, size);
    this.image = image;
    this.dx = 0;
    this.dy = 0;
    this.data = data;
    this.offset = offset;
    this.setCollisionData();
  }

  public collideY(): void {
  }

  public draw(ctx: CanvasRenderingContext2D): void {
    ctx.drawImage(this.image, this.position.x + this.offset.x, this.position.y + this.offset.y, this.size.width, this.size.height, this.dx, this.dy, this.size.width, this.size.height);
  }

  private setCollisionData(): void {
    this.data.layers.forEach(col => {
      if (col.name == "Collision") {
        col.objects.forEach(x => {
          this.collisionObjects.push(new Collision(x, this.offset));
        });
      }
    });
  }
}