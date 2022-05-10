<?php

declare(strict_types=1);

namespace Bjercke\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

/**
 * @Entity
 * @Table(name="tiles")
 */
class Tile {
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    private int $id;

    /**
     * @Column(type="string")
     */
    private string $title;

    /**
     * @Column(type="string", name="template_path")
     */
    private string $templatePath;

    /**
     * @Column(type="string", name="class_name")
     */
    private string $className;

    /**
     * @ManyToOne(targetEntity="\Bjercke\Entity\Article", inversedBy="tiles")
     */
    private mixed $article;

    /**
     * @Column(type="json", name="options")
     */
    private array $options;

    /**
     * @param string $title The title of the tile
     * @param string $templatePath The path to the template file (Example: Article/articledisplay.html.twig)
     * @param string $className The class name of a tile from the Bjercke\Tile namespace (Example: ArticleTile)
     */
    public function __construct(string $title, string $templatePath, string $className, array $options = []) {
        $this->title = $title;
        $this->templatePath = $templatePath;
        $this->className = $className;
        $this->options = $options;
    }

    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Tile
     */
    public function setId(int $id): Tile {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Tile
     */
    public function setTitle(string $title): Tile {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getTemplatePath(): string {
        return $this->templatePath;
    }

    /**
     * @param string $templatePath
     * @return Tile
     */
    public function setTemplatePath(string $templatePath): Tile {
        $this->templatePath = $templatePath;

        return $this;
    }

    /**
     * @return string
     */
    public function getClassName(): string {
        return $this->className;
    }

    /**
     * @param string $className
     * @return Tile
     */
    public function setClassName(string $className): Tile {
        $this->className = $className;

        return $this;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param array $options
     * @return Tile
     */
    public function setOptions(array $options): Tile
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getArticle(): mixed
    {
        return $this->article;
    }

    /**
     * @param Article|null $article
     * @return Tile|null
     */
    public function setArticle(Article|null $article): Tile|null
    {
        $this->article = $article;
        return $this;
    }
}