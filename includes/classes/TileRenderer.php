<?php

declare(strict_types=1);

namespace Bjercke;

use Bjercke\Entity\Article;
use Bjercke\Entity\Tile;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

class TileRenderer extends ViewRenderer {
    private string $title;
    private string $templatePath;
    private string $className;
    private $article;
    private Tile $tile;

    /**
     * Tile constructor.
     *
     */
    protected function __construct() {
        parent::__construct();
        $this->loader = new FilesystemLoader(__DIR__ . '/');
        $this->twig = new Environment($this->loader);
    }

    /**
     * Render view/page.
     *
     * @return void
     */
    public function render(): void {
        $class = call_user_func("$this->className::getInstance");
        if ($this->getArticle() instanceof Article) {
            $this->twig->addGlobal('article', $this->getArticle());
        }

        try {
            echo $this->twig->render($this->templatePath, ['site' => Site::getInstance(), 'tile' => $class]);
        } catch (LoaderError|RuntimeError|SyntaxError $e) {
            echo "Error rendering: " . $e->getMessage();
        }
    }

    public function renderTilePiece(string $className, string $templatePath): void {
        $this->className = $className;
        $this->templatePath = $templatePath;
        $this->render();
    }

    /**
     * @return string
     */
    public function getTitle(): string {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTemplatePath(): string {
        return $this->templatePath;
    }

    /**
     * @param string $templatePath
     */
    public function setTemplatePath(string $templatePath): void {
        $this->templatePath = $templatePath;
    }

    /**
     * @return string
     */
    public function getClassName(): string {
        return $this->className;
    }

    /**
     * @param string $className
     */
    public function setClassName(string $className): void {
        $this->className = $className;
    }

    /**
     * @return mixed
     */
    public function getArticle(): mixed {
        return $this->article;
    }

    /**
     * @param mixed $article
     */
    public function setArticle(mixed $article): void {
        $this->article = $article;
    }

    /**
     * @return Tile
     */
    public function getTile(): Tile {
        return $this->tile;
    }

    /**
     * @param Tile $tile
     */
    public function setTile(Tile $tile): void {
        $this->tile = $tile;
        $this->templatePath = $tile->getTemplatePath();
        $this->className = $tile->getClassName();
        $this->article = $tile->getArticle();
    }
}