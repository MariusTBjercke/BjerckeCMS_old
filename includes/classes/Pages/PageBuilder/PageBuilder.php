<?php

use Bjercke\Entity\Article;
use Bjercke\Entity\Page;
use Bjercke\Site;
use Bjercke\Tile;

class PageBuilder extends Tile {
    public Page $page;

    protected function __construct() {
        parent::__construct();
        $this->page = $this->getPageToEdit();
    }

    /**
     * Get page from db that matches the given name.
     *
     * @return Page|null Returns the corresponding page if found, or first db entry. If there's nothing in db, return
     *     null.
     */
    public function getPageToEdit(): Page|null {
        if (isset($_REQUEST['name'])) {
            $_SESSION['page_name'] = $_REQUEST['name'];
        }
        $name = $_SESSION['page_name'] ?? "home";
        $em = $this->db->getEntityManager();

        $page = $em->getRepository(Page::class)->findOneBy(['name' => $name]);
        $alt = $em->getRepository(Page::class)->findAll()[0];

        if ($page instanceof Page) {
            return $page;
        }

        if ($alt instanceof Page) {
            return $em->getRepository(Page::class)->findAll()[0];
        }

        return null;
    }

    /**
     * Get existing tile order from db.
     *
     * @return array|null
     */
    public function getTileOrder(): ?array {
        $em = $this->db->getEntityManager();
        $tileOrder = $this->page->getTileOrder();

        foreach ($tileOrder as $tile) {
            $tiles[] = $em->getRepository(\Bjercke\Entity\Tile::class)->findOneBy(array('id' => $tile));
        }

        return $tiles ?? null;
    }

    /**
     * Get all available tiles from db.
     *
     * @return array|object[]
     */
    public function getAllTiles() {
        $em = $this->db->getEntityManager();

        return $em->getRepository(Bjercke\Entity\Tile::class)->findAll();
    }

    public function getTileToEdit() {
        if (isset($_REQUEST['options'])) {
            $options = json_decode($_REQUEST['options'], true);
            if ($options['tileId'] !== null) {
                $tileId = $options['tileId'];
            }
        }

        $em = $this->db->getEntityManager();

        return $em->getRepository(Bjercke\Entity\Tile::class)->findOneBy(array('id' => $tileId ?? null));
    }

    public function getArticles(){
        $em = $this->db->getEntityManager();

        return $em->getRepository(Article::class)->findAll();
    }

    public function getCurrentArticle() {
        $em = $this->db->getEntityManager();
        return $this->getTileToEdit()->getArticle();
    }
}