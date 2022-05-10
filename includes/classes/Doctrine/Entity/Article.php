<?php

declare(strict_types=1);

namespace Bjercke\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

/**
 * @Entity
 * @Table(name="articles")
 */
class Article {
    /**
     * @Column(type="integer")
     * @Id
     * @GeneratedValue
     */
    private string $id;

    /**
     * @Column(type="string")
     */
    private string $title;

    /**
     * @Column(type="text")
     */
    private string $content;

    /**
     * @Column(type="string", name="background_image", nullable=true)
     */
    private string $backgroundImage;

    /**
     * @ManyToOne(targetEntity="\Bjercke\Entity\User", inversedBy="forumPosts")
     */
    private User $author;

    /**
     * @Column(type="string")
     */
    private string $date;

    /**
     * @OneToMany(targetEntity="\Bjercke\Entity\Tile", mappedBy="article")
     */
    private mixed $tiles;

    /**
     * @return string
     */
    public function getId(): string {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Article
     */
    public function setId(string $id): Article {
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
     * @return Article
     */
    public function setTitle(string $title): Article {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string {
        return $this->content;
    }

    /**
     * @param string $content
     * @return Article
     */
    public function setContent(string $content): Article {
        $this->content = $content;

        return $this;
    }

    /**
     * @return User
     */
    public function getAuthor(): User {
        return $this->author;
    }

    /**
     * @param User $author
     * @return Article
     */
    public function setAuthor(User $author): Article {
        $this->author = $author;

        return $this;
    }

    /**
     * @param string $date
     * @return Article
     */
    public function setDate(string $date): Article {
        $this->date = $date;

        return $this;
    }

    /**
     * @return string
     */
    public function getDate(): string {
        return date("Y-m-d h:i:s", (int)$this->date);
    }

    /**
     * @return string
     */
    public function getTimeAgo(): string {
        return $this->get_time_ago($this->date);
    }

    public function get_time_ago($time) {
        $time_difference = time() - $time;

        if ($time_difference < 1) {
            return 'less than 1 second ago';
        }
        $condition = array(12 * 30 * 24 * 60 * 60 => 'year',
                           30 * 24 * 60 * 60      => 'month',
                           24 * 60 * 60           => 'day',
                           60 * 60                => 'hour',
                           60                     => 'minute',
                           1                      => 'second'
        );

        foreach ($condition as $secs => $str) {
            $d = $time_difference / $secs;

            if ($d >= 1) {
                $t = round($d);

                return 'about ' . $t . ' ' . $str . ($t > 1 ? 's' : '') . ' ago';
            }
        }
    }

    /**
     * @return Tile
     */
    public function getTiles(): Tile
    {
        return $this->tiles;
    }

    /**
     * @param Tile $tiles
     * @return Article
     */
    public function setTiles(Tile $tiles): Article
    {
        $this->tiles = $tiles;
        return $this;
    }
}