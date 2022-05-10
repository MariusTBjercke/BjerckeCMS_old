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
     * @return array Array of post objects.
     */
    public function getLatestPosts(int $limit = null): array {
        $entityManager = $this->db->getEntityManager();

        return $entityManager->getRepository(Post::class)->findBy([], ['id' => 'DESC'], $limit);
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