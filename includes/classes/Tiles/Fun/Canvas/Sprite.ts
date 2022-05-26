export class Sprite {
  public image: HTMLImageElement;
  public width: number;
  public height: number;
  public position: Object;
  public scale: number;
  public rotation: number;
  public alpha: number;
  public visible: boolean;

  constructor(imagePath: string, width: number, height: number) {
    this.image = new Image();
    this.image.src = imagePath;
    this.width = width;
    this.height = height;
    this.position = { x: 0, y: 0 };
  }
}