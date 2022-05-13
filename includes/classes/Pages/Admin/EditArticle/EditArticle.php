<?php

use Bjercke\Entity\Article;
use Bjercke\SqlConnection;
use Bjercke\Tile;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\TransactionRequiredException;

class EditArticle extends Tile {

    /**
     * @throws OptimisticLockException
     * @throws TransactionRequiredException
     * @throws ORMException
     */
    public function getArticle() {
        $articleId = $_GET['id'] ?? null;
        $em = $this->db->getEntityManager();

        return is_null($articleId) ? $em->getRepository(Article::class)->findAll()[0] : $em->find(Article::class, $articleId);
    }

}