<?php

declare(strict_types=1);

use Bjercke\Entity\Article;
use Bjercke\SqlConnection;
use Bjercke\Tile;

class ArticleList extends Tile {

    public function getArticles($limit = 5) {
        $em = SqlConnection::getInstance()->getEntityManager();

        return $em->getRepository(Article::class)->findBy([], ['id' => 'DESC'], $limit);
    }

}