<?php

namespace Bjercke\Entity;

use Bjercke\Language\Language;
use Bjercke\Site;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

/**
 * @Entity
 * @Table(name="pages")
 */
class Page {
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    private int $id;

    /**
     * @Column(type="string")
     */
    private string $name;

    /**
     * @Column(type="string")
     */
    private string $title;

    /**
     * @Column(type="string")
     */
    private string $description;

    /**
     * @Column(type="string")
     */
    private string $icon;

    /**
     * @Column(type="string")
     */
    private string $url;

    /**
     * @Column(type="string")
     */
    private string $template;

    /**
     * @Column(type="string", name="tile_class")
     */
    private string $class;

    /**
     * @Column(type="boolean")
     */
    private bool $navigation;

    /**
     * @Column(type="boolean", name="requires_login", options={"default":false})
     */
    private bool $requiresLogin;

    /**
     * @Column(type="boolean", name="hide_when_logged_in")
     */
    private bool $hideWhenLoggedIn;

    /**
     * @Column(type="simple_array", name="tile_order", nullable=true)
     */
    private array $tileOrder;

    public function __construct(
        string $name, string $title, string $description, string $icon, string $url, string $template, string $class,
        bool   $navigation, bool $requiresLogin = false, bool $hideWhenLoggedIn = false, array $tileOrder = []
    ) {
        $this->name = $name;
        $this->title = $title;
        $this->description = $description;
        $this->icon = $icon;
        $this->url = $url;
        $this->template = $template;
        $this->class = $class;
        $this->navigation = $navigation;
        $this->requiresLogin = $requiresLogin;
        $this->hideWhenLoggedIn = $hideWhenLoggedIn;
        $this->tileOrder = $tileOrder;
    }

    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Page
     */
    public function setId(int $id): Page {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getTitle(): string {
        return $this->title;
    }

    public function getTitleString(): string {
        $language = new Language();
        return $language->getString($this->title);
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
    public function getDescription(): string {
        return $this->description;
    }

    public function getDescriptionString(): string {
        $language = new Language();
        return $language->getString($this->description);
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getIcon(): string {
        return $this->icon;
    }

    /**
     * @param string $icon
     */
    public function setIcon(string $icon): void {
        $this->icon = $icon;
    }

    /**
     * @return string
     */
    public function getUrl(): string {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getTemplate(): string {
        return $this->template;
    }

    /**
     * @param string $template
     */
    public function setTemplate(string $template): void {
        $this->template = $template;
    }

    /**
     * Get name of tile class. Can later be used to resolve the class.
     *
     * @return string
     */
    public function getClass(): string {
        return $this->class;
    }

    /**
     * @param string $class
     */
    public function setClass(string $class): void {
        $this->class = $class;
    }

    /**
     * @return bool
     */
    public function getNavigation(): bool {
        return $this->navigation;
    }

    /**
     * @param bool $navigation
     */
    public function setNavigation(bool $navigation): void {
        $this->navigation = $navigation;
    }

    /**
     * @return bool
     */
    public function getRequiresLogin(): bool {
        return $this->requiresLogin;
    }

    /**
     * @param bool $requiresLogin
     */
    public function setRequiresLogin(bool $requiresLogin): void {
        $this->requiresLogin = $requiresLogin;
    }

    /**
     * @return array
     */
    public function getTileOrder(): array {
        return $this->tileOrder;
    }

    /**
     * @param array $tileOrder
     * @return Page
     */
    public function setTileOrder(array $tileOrder): Page {
        $this->tileOrder = $tileOrder;

        return $this;
    }

    /**
     * @return bool
     */
    public function getHideWhenLoggedIn(): bool {
        return $this->hideWhenLoggedIn;
    }

    /**
     * @param bool $hideWhenLoggedIn
     * @return Page
     */
    public function setHideWhenLoggedIn(bool $hideWhenLoggedIn): Page {
        $this->hideWhenLoggedIn = $hideWhenLoggedIn;

        return $this;
    }
}