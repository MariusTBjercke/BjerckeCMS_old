import {WorldObject} from "@tiles/Fun/Canvas/WorldObject";

export class Boundary {
    public position: any;
    public size: any;

    constructor(position: any, size: any) {
        this.position = position;
        this.size = size;
    }

    public contains(x: number, y: number): boolean {
        return x >= this.position.x && x <= this.position.x + this.size.width && y >= this.position.y && y <= this.position.y + this.size.height;
    }

    public collideY(worldObject: WorldObject): boolean {
        return worldObject.collision && this.position.y + this.size.height > worldObject.position.y && this.position.x < worldObject.position.x + worldObject.size.width && this.position.x + this.size.width > worldObject.position.x;
    }
}