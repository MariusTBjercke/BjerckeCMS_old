<?php

use Bjercke\Entity\Article;
use Bjercke\DatabaseManager;
use Bjercke\Tile;

class EditArticles extends Tile {

    public function getArticles($limit = false): array
    {
        $em = DatabaseManager::getInstance()->getEntityManager();

        if (!$limit) {
            return $em->getRepository(Article::class)->findBy([], ['id' => 'DESC']);
        }

        return $em->getRepository(Article::class)->findBy([], ['id' => 'DESC'], $limit);
    }

}