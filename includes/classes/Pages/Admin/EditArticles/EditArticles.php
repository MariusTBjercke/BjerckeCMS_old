<?php

use Bjercke\Entity\Article;
use Bjercke\SqlConnection;
use Bjercke\Tile;

class EditArticles extends Tile {

    public function getArticles($limit = false): array
    {
        $em = SqlConnection::getInstance()->getEntityManager();

        if (!$limit) {
            return $em->getRepository(Article::class)->findBy([], ['id' => 'DESC']);
        }

        return $em->getRepository(Article::class)->findBy([], ['id' => 'DESC'], $limit);
    }

}