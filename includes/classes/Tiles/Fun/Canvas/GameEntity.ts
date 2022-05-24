import {Sprite} from "./Sprite";

export abstract class GameEntity {
  public position: any;
  public velX: number;
  public velY: number;
  public size: any;
  public moveSpeed: number;
  public friction: number;
  public gravity: number;
  public grounded: boolean;
  public sprite: Sprite;
  public ctx: CanvasRenderingContext2D;
  public color: string;
  public flipX: boolean;
  public flipY: boolean;

  protected constructor(position, size) {
    this.position = position;
    this.size = size;
    this.velX = 0;
    this.velY = 0;
    this.flipX = false;
    this.flipY = false;
  }

  abstract collideY(): void;

  abstract draw(ctx: CanvasRenderingContext2D): void;
}