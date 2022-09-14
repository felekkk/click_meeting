<?php
declare(strict_types=1);

namespace App\ValueObject;

interface ImageFactory
{
    public static function create(string $path, string $name, string $extension, int $width, int $height);

    public function getPath(): string;

    public function getName(): string;

    public function getExtension(): string;

    public function getWidth(): int;

    public function getHeight(): int;
}