<?php

declare(strict_types=1);

namespace Bjercke\Entity\Forum;

use Bjercke\Entity\User;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

/**
 * @Entity
 * @Table(name="forum_posts")
 */
class Post {
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
     * @Column(type="text")
     */
    private string $content;

    /**
     * @ManyToOne(targetEntity="\Bjercke\Entity\User", inversedBy="forumPosts")
     */
    private User $author;

    /**
     * @Column(type="string")
     */
    private string $date;

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): Post {
        $this->id = $id;

        return $this;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function setTitle(string $title): Post {
        $this->title = $title;

        return $this;
    }

    public function getContent(): string {
        return $this->content;
    }

    /**
     * Set post content and strip tags (except from those specified).
     *
     * @param string $content
     * @return $this
     */
    public function setContent(string $content): Post {
        $this->content = strip_tags(
            $content,
            ['br', 'p', 'b', 'i', 'u', 'a', 'img', 'ul', 'ol', 'li', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'style', 'strong']
        );

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
     * @return Post
     */
    public function setAuthor(User $author): Post {
        $this->author = $author;

        return $this;
    }

    public function setDate(string $date): Post {
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
     * @return string
     */
    public function getDateAsUnix(): string {
        return $this->date;
    }
}