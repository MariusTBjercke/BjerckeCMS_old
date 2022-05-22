import {DOMReady} from "../shared/domready";

class Canvas {
    private canvas: HTMLCanvasElement;
    private ctx: CanvasRenderingContext2D;
    private width: number;
    private height: number;

    constructor(canvasId: string) {
        this.canvas = <HTMLCanvasElement>document.getElementById(canvasId);
        this.ctx = this.canvas.getContext("2d");
        this.width = this.canvas.width;
        this.height = this.canvas.height;
    }

    public clear() {
        this.ctx.clearRect(0, 0, this.width, this.height);
    }

    public drawRectangle(x: number, y: number, width: number, height: number, color: string) {
        this.ctx.fillStyle = color;
        this.ctx.fillRect(x, y, width, height);
    }
}

DOMReady(() => {
    const canvas = new Canvas("canvas");
    canvas.drawRectangle(10, 10, 100, 100, "red");
});