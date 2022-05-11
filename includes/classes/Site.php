<?php

namespace Bjercke;

use Bjercke\Entity\Page;
use Bjercke\Entity\User;
use Bjercke\Language\Language;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\TransactionRequiredException;
use Singleton;

class Site extends Singleton {
    private string $pageName;
    private Page $currentPage;
    private User $currentUser;
    private array $pages;
    private string $action;
    private SqlConnection $db;
    private Language $language;

    protected function __construct() {
        parent::__construct();
        $this->pageName = $_GET['page'] ?? 'home';
        $this->db = SqlConnection::getInstance();
        $this->currentUser = $this->setCurrentUser();
        $this->pages = $this->setPagesFromDb();
        $this->currentPage = new Page(
            "Home", "Home", "Home", "default", "home", "Home/home.html.twig", "Home", true, false
        );
        $this->action = $_SESSION['action'] ?? '';
        $this->language = new Language("en");
    }

    /**
     * Returns a string from the database.
     *
     * @param int|null $stringId The id of the string to get from DB.
     * @param null $alias The alias of the string to get from DB.
     */
    public function getString(int|null $stringId, $alias = null): string
    {
        return $this->language->getString($stringId, $alias);
    }

    /**
     * @param string $path Path to the page
     * @return string
     */
    public function getUrl(string $path = ''): string {
        $isSecure = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            || $_SERVER['SERVER_PORT'] === 443);
        $protocol = $isSecure ? 'https://' : 'http://';

        return $protocol . $_SERVER['HTTP_HOST'] . '/' . $path;
    }

    public function getAsset(string $assetPath): string {
        return $this->getUrl() . 'assets/' . $assetPath;
    }

    public function getPageDescription(): string {
        return $this->currentPage->getDescription();
    }

    /**
     * @param string $path Redirect path.
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws TransactionRequiredException
     */
    public function logout(string $path = '/'): void {
        $em = $this->db->getEntityManager();
        $user = $em->find(User::class, $this->getCurrentUser()->getId());
        if ($user instanceof User) {
            $user->setLoggedIn(false);
            $em->flush();
        }

        // Unset cookie and session data
        setcookie('user', '', time() - 3600, '/');
        session_unset();
        session_destroy();
        header("Location: " . $path);
    }

    public function setCurrentUser() {
        // Cookie check
        if (isset($_COOKIE['user']) && !$_SESSION['user']) {
            $_SESSION['user'] = $_COOKIE['user'];
        }

        if (isset($_SESSION['user'])) {
            return unserialize($_SESSION['user'], ['allowed_classes' => true]);
        }

        if (isset($_COOKIE['user'])) {
            return unserialize($_COOKIE['user'], ['allowed_classes' => true]);
        }

        return new User();
    }

    /**
     * @param int $tileId ID of the tile from the DB.
     * @return void Renders a specified tile.
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws TransactionRequiredException
     */
    public function renderTile($tileId): void {
        $em = $this->db->getEntityManager();
        $tile = $em->find(\Bjercke\Entity\Tile::class, $tileId);

        if ($tile instanceof \Bjercke\Entity\Tile) {
            $tileRenderer = TileRenderer::getInstance();
            $tileRenderer->setTile($tile);
            $tileRenderer->render();
        }
    }

    /**
     * @throws OptimisticLockException
     * @throws TransactionRequiredException
     * @throws ORMException
     */
    public function renderPageTiles() {
        $currentPage = $this->getCurrentPage();

        $tileOrder = $currentPage->getTileOrder();

        foreach ($tileOrder as $tile) {
            $this->renderTile($tile);
        }
    }

    public function getPages(): array {
        return $this->pages;
    }

    public function setPages(array $pages) {
        $this->pages = $pages;
    }

    public function setPagesFromDb(): array {
        // Get pages from DB
        $em = $this->db->getEntityManager();

        try {
            $dbPages = $em->getRepository(Page::class)->findAll();

            foreach ($dbPages as $dbPage) {
                $pages[] = new Page(
                    $dbPage->getName(), $dbPage->getTitle(), $dbPage->getDescription(), $dbPage->getIcon(),
                    $dbPage->getUrl(),
                    $dbPage->getTemplate(), $dbPage->getClass(), $dbPage->getNavigation(), $dbPage->getRequiresLogin(),
                    $dbPage->getHideWhenLoggedIn(), $dbPage->getTileOrder()
                );
            }
        } catch (Exception $e) {
            $pages = [];
        }

        return $pages ?? [];
    }

    /**
     * Return array of users.
     *
     * @return array
     */
    public function getUsers(): array {
        return $this->db->getUsers();
    }

    public function setAction(string $action) {
        $this->action = $action;
    }

    public function getAction(): string {
        return $this->action;
    }

    public function setPageName(string $pageName) {
        $this->pageName = $pageName;
    }

    public function getPageName(): string {
        return $this->pageName;
    }

    /**
     * @return User
     */
    public function getCurrentUser(): User {
        return $this->currentUser;
    }

    /**
     * @return Page
     */
    public function getCurrentPage(): Page {
        return $this->currentPage;
    }

    /**
     * @param Page $currentPage
     */
    public function setCurrentPage(Page $currentPage): void {
        $this->currentPage = $currentPage;
    }

    public function getYear(): string {
        return date("Y");
    }

}