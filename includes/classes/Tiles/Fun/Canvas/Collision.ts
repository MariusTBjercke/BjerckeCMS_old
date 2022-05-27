import {Player} from "./Player";

export class Collision {
    public position: { x: number, y: number };
    public size: { width: number, height: number };
    public offset: { x: number, y: number };

    constructor(data: any, offset: { x: number, y: number }) {
        this.position = {
            x: data.x,
            y: data.y
        };
        this.size = {
            width: data.width,
            height: data.height
        };
        this.offset = offset;
    }

    public contains(player: Player): void {
        console.log(this.position);
    }

    public collideY() {
    }

    public update() {
    }

    draw(ctx: CanvasRenderingContext2D): void {
        ctx.fillStyle = "rgba(255,0,0,0.5)";
        ctx.fillRect(200 - this.offset.x, 200 - this.offset.y, this.size.width + 200, this.size.height+ 100);
    }
}