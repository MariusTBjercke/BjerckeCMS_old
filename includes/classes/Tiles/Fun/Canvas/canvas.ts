import {DOMReady} from "@assets/js/shared/domready";
import PlayerSheet from "@assets/img/canvas/spritesheet/player.png";
import FarmSource from "@assets/img/canvas/maps/farm.png";
import {Player} from "./Player";
import {Sprite} from "./Sprite";
import {WorldObject} from "./WorldObject";
import {Map} from "./Map";
import {GameEntity} from "./GameEntity";

class Canvas {
    private canvas: HTMLCanvasElement;
    private ctx: CanvasRenderingContext2D;
    private width: number;
    private height: number;
    private player: Player;
    private worldObjects: WorldObject[] = [];
    private gameEntities: GameEntity[] = [];
    private currentMap: Map;

    constructor(canvasId: string, width: number, height: number) {
        this.canvas = <HTMLCanvasElement>document.getElementById(canvasId);
        this.ctx = this.canvas.getContext("2d");
        this.width = width;
        this.height = height;
        this.canvas.width = width;
        this.canvas.height = height;
        // TODO: Implement JSON data
        const playerData = require("@assets/img/canvas/spritesheet/player.json");
        this.player = new Player({x: 0, y: 0}, {width: 77, height: 200});
        this.player.position.x = this.width / 2 - this.player.size.width / 2;
        this.player.position.y = this.height / 2 - this.player.size.height / 2;
        this.player.setSprite(new Sprite(PlayerSheet, this.player.size.width, this.player.size.height));
        this.player.setContext(this.ctx);
        this.init();
    }

    private init() {
        this.addGameEntities();
        this.addWorldObjects();
        this.setMap();
    }

    public start() {
        requestAnimationFrame(this.start.bind(this));
        this.clear();

        this.draw();
        this.player.update();
        this.mapMovement();
    }

    public clear() {
        this.ctx.clearRect(0, 0, this.width, this.height);
    }

    public draw() {
        this.currentMap.draw(this.ctx);
        this.drawGameEntities();
        this.drawWorldObjects();
        this.player.draw(this.ctx);
    }

    public setMap() {
        const mapImage = new Image();
        mapImage.src = FarmSource;
        this.currentMap = new Map({x: 550, y: 800}, {width: this.width, height: this.height}, mapImage);
    }

    public addGameEntities() {
        this.gameEntities.push();
    }

    public drawGameEntities() {
        this.gameEntities.forEach(gameEntity => {
            gameEntity.draw(this.ctx);
        });
    }

    public addWorldObjects() {
        // const groundBar = new WorldObject({x: 50, y: 400}, {width: 300, height: 50}, "#187218", true);
        // const groundBar2 = new WorldObject({x: 350, y: 500}, {width: 300, height: 50}, "#1f6c43", true);

        this.worldObjects.push();
    }

    private drawWorldObjects() {
        this.worldObjects.forEach((worldObject: WorldObject) => {
            worldObject.draw(this.ctx);
            worldObject.collisionY(this.player);
        });
    }

    public mapMovement() {
        const distanceRight = this.width - this.player.position.x - this.player.size.width;
        const distanceLeft = this.player.position.x;
        const distanceTop = this.player.position.y;
        const distanceBottom = this.height - this.player.position.y - this.player.size.height;

        const distance = 100;

        if (distanceRight <= distance && this.player.velX > 0) {
            this.player.position.x = this.width - distance - this.player.size.width;
            this.currentMap.position.x += this.player.velX;
        }

        if (distanceLeft <= distance && this.player.velX < 0) {
            this.player.position.x = distance;
            this.currentMap.position.x += this.player.velX;
        }

        if (distanceTop <= distance && this.player.velY < 0) {
            this.player.position.y = distance;
            this.currentMap.position.y += this.player.velY;
        }

        if (distanceBottom <= distance && this.player.velY > 0) {
            this.player.position.y = this.height - distance - this.player.size.height;
            this.currentMap.position.y += this.player.velY;
        }
    }
}

DOMReady(() => {
    const canvas = new Canvas("canvas", 1020, 720);
    canvas.start();
});