<?php

declare(strict_types=1);

namespace Bjercke;

use DirectoryIterator;

class FileProvider
{
    private string $path;

    public function __construct(string $path = null)
    {
        $this->path = $path;
    }

    public function getImage($fileName) {
        $image = $this->path . $fileName;
        $imageData = base64_encode(file_get_contents($this->path . $fileName));
        $src = 'data:image/' . pathinfo($image, PATHINFO_EXTENSION) . ';base64,' . $imageData;

        return $src;
    }

    public function getPath(): string
    {
        return $this->path;
    }
}