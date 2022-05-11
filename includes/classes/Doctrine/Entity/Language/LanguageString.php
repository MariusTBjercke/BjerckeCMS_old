<?php

declare(strict_types=1);

namespace Bjercke\Entity\Language;

use Bjercke\Entity\User;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

/**
 * @Entity
 * @Table(name="language_strings")
 */
class LanguageString {
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    private int $id;

    /**
     * @Column(type="string", length=255, nullable=true)
     */
    private string $alias;

    /**
     * @Column(type="string", length=255, options={"default": ""})
     */
    private string $no;

    /**
     * @Column(type="string", length=255, options={"default": ""})
     */
    private string $en;

    public function __construct(string $no, string $en, string $alias = null) {
        $this->no = $no;
        $this->en = $en;
        $this->alias = $alias;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Post
     */
    public function setId(int $id): Post
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAlias(): ?string
    {
        return $this->alias;
    }

    /**
     * @param string|null $alias
     * @return Post
     */
    public function setAlias(?string $alias): Post
    {
        $this->alias = $alias;
        return $this;
    }

    /**
     * @return string
     */
    public function getNo(): string
    {
        return $this->no;
    }

    /**
     * @param string $no
     * @return Post
     */
    public function setNo(string $no): Post
    {
        $this->no = $no;
        return $this;
    }

    /**
     * @return string
     */
    public function getEn(): string
    {
        return $this->en;
    }

    /**
     * @param string $en
     * @return Post
     */
    public function setEn(string $en): Post
    {
        $this->en = $en;
        return $this;
    }
}