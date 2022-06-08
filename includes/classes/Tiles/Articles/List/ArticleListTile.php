<?php

declare(strict_types=1);

use Bjercke\Entity\Article;
use Bjercke\DatabaseManager;
use Bjercke\Tile;

class ArticleListTile extends Tile {

    public function getArticles($limit = 5) {
        $em = DatabaseManager::getInstance()->getEntityManager();

        return $em->getRepository(Article::class)->findBy([], ['id' => 'DESC'], $limit);
    }

}