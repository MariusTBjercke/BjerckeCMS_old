<?php

declare(strict_types=1);

use Bjercke\Entity\Article;
use Bjercke\SqlConnection;
use Bjercke\Tile;

class ArticleDisplay extends Tile {

    /**
     * @throws Exception
     */
    public function getArticle($articleId): Article {
        $em = SqlConnection::getInstance()->getEntityManager();
        $article = $em->getRepository(Article::class)->find(1);
        if ($article instanceof Article) {
            return $article;
        }

        throw new RuntimeException("Article not found.");
    }

}