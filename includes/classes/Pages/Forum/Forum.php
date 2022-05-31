<?php

use Bjercke\Entity\Forum\Post;
use Bjercke\SqlConnection as Sql;
use Bjercke\Tile;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

class Forum extends Tile {
    protected Sql $db;

    public function __construct() {
        parent::__construct();
        $this->db = Sql::getInstance();
    }

    /**
     * Get the latest posts from the database and instantiate post objects.
     *
     * @return array|null Array of post objects.
     */
    public function getLatestPosts(int $limit = null): array|null {
        $entityManager = $this->db->getEntityManager();
        $posts = $entityManager->getRepository(Post::class)->findBy([], ['id' => 'DESC'], $limit);

        if (is_array($posts)) {
            return $posts;
        }

        return null;
    }

    /**
     * @param Post $post
     * @return void
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function createPost(Post $post): void {
        $entityManager = $this->db->getEntityManager();
        $entityManager->persist($post);
        $entityManager->flush();
    }
}