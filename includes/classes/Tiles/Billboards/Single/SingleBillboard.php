<?php

declare(strict_types=1);

use Bjercke\Tile;

class SingleBillboard extends Tile {
    /**
     * @param string $imagePath Path to the image to display.
     * @return string Returns the image as HTML.
     */
    public function getImage(string $imagePath): string {
        return $imagePath;
    }

    /**
     * Get article from DB.
     *
     * @return
     */
    public function getArticle($articleId) {
        return '';
    }
}