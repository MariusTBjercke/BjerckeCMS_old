<?php

declare(strict_types=1);

use Bjercke\SqlConnection;
use Bjercke\Tile;
use Bjercke\TileRenderer;

class NewTileTile extends Tile {

    public function getTiles() {
        $em = SqlConnection::getInstance()->getEntityManager();

        return $em->getRepository(\Bjercke\Entity\Tile::class)->findBy([], ['id' => 'DESC']);
    }

    public function renderTileList(): bool|string {
        $view = TileRenderer::getInstance();
        ob_start();
        $view->renderTilePiece('NewTile', 'Tiles/Tools/NewTile/tilelist.html.twig');

        return ob_get_clean();
    }

}