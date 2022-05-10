<?php

namespace Bjercke;

class FileUpload {
    private string $fileName;
    private string $fileType;
    private string $fileTmpName;
    private int $fileSize;
    private string $fileError;
    private string $fileExtension;
    private string $fileNewName;

    public function __construct(array $file) {
        $this->fileName = $file['name'];
        $this->fileType = $file['type'];
        $this->fileTmpName = $file['tmp_name'];
        $this->fileExtension = strtolower(pathinfo($this->fileName, PATHINFO_EXTENSION));
        $this->fileSize = $file['size'];
        $this->fileError = $file['error'];
    }

    public function upload($path, $useNewName = true): bool {
        if ($useNewName) {
            $this->fileNewName = $this->generateNewName();
        } else {
            $this->fileNewName = $this->fileName;
        }
        if (move_uploaded_file($this->fileTmpName, $path . $this->fileNewName)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * TODO: Add Imagick support
     */
    public function resizeImage($newSize, $path, $newPath): bool {
//        $image = new Imagick($path . $this->fileNewName);
//        $image->resizeImage($newSize, $newSize, Imagick::FILTER_LANCZOS, 1);
//        $image->writeImage($newPath . $this->fileNewName);
        return true;
    }

    public function generateNewName(): string {
        return $this->fileNewName = uniqid('', true) . '.' . $this->fileExtension;
    }

    /**
     * Check if file is an image.
     *
     * @return bool
     */
    public function imageCheck(): bool {
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $fileExtension = strtolower(pathinfo($this->fileName, PATHINFO_EXTENSION));
        if (!in_array($fileExtension, $allowedExtensions)) {
            return false;
        }

        return true;
    }

    public function sizeCheck(int $maxSize): bool {
        if ($this->fileSize > $maxSize) {
            return false;
        }

        return true;
    }

    /**
     * Check for errors.
     *
     * @return bool Returns false if there are no errors.
     */
    public function errorCheck(): bool {
        if ($this->fileError !== 0) {
            return false;
        }

        return true;
    }

    /**
     * @return string
     */
    public function getFileName(): string {
        return $this->fileName;
    }

    /**
     * @param string $fileName
     */
    public function setFileName(string $fileName): void {
        $this->fileName = $fileName;
    }

    /**
     * @return string
     */
    public function getFileType(): string {
        return $this->fileType;
    }

    /**
     * @param string $fileType
     */
    public function setFileType(string $fileType): void {
        $this->fileType = $fileType;
    }

    /**
     * @return string
     */
    public function getFileTmpName(): string {
        return $this->fileTmpName;
    }

    /**
     * @param string $fileTmpName
     */
    public function setFileTmpName(string $fileTmpName): void {
        $this->fileTmpName = $fileTmpName;
    }

    /**
     * @return int
     */
    public function getFileSize(): int {
        return $this->fileSize;
    }

    /**
     * @param int $fileSize
     */
    public function setFileSize(int $fileSize): void {
        $this->fileSize = $fileSize;
    }

    /**
     * @return string
     */
    public function getFileError(): string {
        return $this->fileError;
    }

    /**
     * @param string $fileError
     */
    public function setFileError(string $fileError): void {
        $this->fileError = $fileError;
    }

    /**
     * @return string
     */
    public function getFileExtension(): string {
        return $this->fileExtension;
    }

    /**
     * @param string $fileExtension
     */
    public function setFileExtension(string $fileExtension): void {
        $this->fileExtension = $fileExtension;
    }

    /**
     * @return string
     */
    public function getFileNewName(): string {
        return $this->fileNewName;
    }

    /**
     * @param string $fileNewName
     */
    public function setFileNewName(string $fileNewName): void {
        $this->fileNewName = $fileNewName;
    }

}