import {DOMReady} from "@assets/js/shared/domready";
import PlayerSheet from "@assets/img/canvas/spritesheet/player.png";
import FarmSource from "@assets/img/canvas/maps/farm.png";
import {Player} from "./Player";
import {Sprite} from "./Sprite";
import {WorldObject} from "./WorldObject";
import {Map} from "./Map";
import {GameEntity} from "./GameEntity";

export class Canvas {
    private canvas: HTMLCanvasElement;
    private readonly ctx: CanvasRenderingContext2D;
    private readonly width: number;
    private readonly height: number;
    private player: Player;
    private worldObjects: WorldObject[] = [];
    private gameEntities: GameEntity[] = [];
    private currentMap: Map;
    public offset: {x: number, y: number};

    constructor(canvasId: string, width: number, height: number) {
        this.canvas = <HTMLCanvasElement>document.getElementById(canvasId);
        this.ctx = this.canvas.getContext("2d");
        this.width = width;
        this.height = height;
        this.canvas.width = width;
        this.canvas.height = height;
        this.offset = {x: 0, y: 0};
        this.addPlayer();
        this.init();
    }

    private init() {
        this.addGameEntities();
        this.addWorldObjects();
        this.setMap();
    }

    private addPlayer() {
        const data = require("@assets/img/canvas/spritesheet/player.json");
        this.player = new Player(data);
        this.player.position.x = this.width / 2 - this.player.size.width / 2;
        this.player.position.y = this.height / 2 - this.player.size.height / 2;
        this.player.sprite = new Sprite(PlayerSheet, this.player.size.width, this.player.size.height);
        this.player.ctx = this.ctx;
    }

    public start() {
        requestAnimationFrame(this.start.bind(this));
        this.clear();

        this.draw();
        this.player.update();
        this.mapMovement();
    }

    private clear() {
        this.ctx.clearRect(0, 0, this.width, this.height);
    }

    private draw() {
        this.currentMap.draw(this.ctx);
        this.drawGameEntities();
        this.drawWorldObjects();
        this.drawCollisionObjects();
        this.player.draw(this.ctx);
    }

    private setMap() {
        const mapImage = new Image();
        mapImage.src = FarmSource;
        const mapData = require("./MapData.json");
        this.currentMap = new Map({x: 550, y: 800}, {width: this.width, height: this.height}, mapImage, mapData, this.offset);
    }

    private addGameEntities() {
        this.gameEntities.push();
    }

    private drawGameEntities() {
        this.gameEntities.forEach(gameEntity => {
            gameEntity.draw(this.ctx);
        });
    }

    private addWorldObjects() {
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

    public drawCollisionObjects(): void {
        this.currentMap.collisionObjects.forEach(object => {
            object.draw(this.ctx);
        });
    }

    private mapMovement() {
        const distanceRight = this.width - this.player.position.x - this.player.size.width;
        const distanceLeft = this.player.position.x;
        const distanceTop = this.player.position.y;
        const distanceBottom = this.height - this.player.position.y - this.player.size.height;

        // Set the distance from the player to the map boundaries
        const distanceX = 350;
        const distanceY = 200;

        if (distanceRight <= distanceX && this.player.velX > 0) {
            this.player.position.x = this.width - distanceX - this.player.size.width;
            this.offset.x += this.player.velX;
        }

        if (distanceLeft <= distanceX && this.player.velX < 0) {
            this.player.position.x = distanceX;
            this.offset.x += this.player.velX;
        }

        if (distanceTop <= distanceY && this.player.velY < 0) {
            this.player.position.y = distanceY;
            this.offset.y += this.player.velY;
        }

        if (distanceBottom <= distanceY && this.player.velY > 0) {
            this.player.position.y = this.height - distanceY - this.player.size.height;
            this.offset.y += this.player.velY;
        }
    }
}

DOMReady(() => {
    const canvas = new Canvas("canvas", 1020, 720);
    canvas.start();
});