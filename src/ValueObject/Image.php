<?php
declare(strict_types=1);

namespace App\ValueObject;

class Image implements ImageFactory
{
    private string $path;
    private string $name;
    private string $extension;
    private int $width;
    private int $height;

    /**
     * @param string $path
     * @param string $name
     * @param string $extension
     * @param int    $width
     * @param int    $height
     */
    public function __construct(string $path, string $name, string $extension, int $width, int $height)
    {
        $this->path = $path;
        $this->name = $name;
        $this->extension = $extension;
        $this->width = $width;
        $this->height = $height;
    }

    public static function create(string $path, string $name, string $extension, int $width, int $height): self
    {
        return new self($path, $name, $extension, $width, $height);
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getExtension(): string
    {
        return $this->extension;
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }
}