<?php
declare(strict_types=1);

namespace App\Service;

class AbstractImageService
{
    protected string $rootPath;
    protected string $imageDirectory;

    public function __construct(string $rootPath, string $imageDirectory)
    {
        $this->rootPath = $rootPath;
        $this->imageDirectory = $imageDirectory;
    }
}