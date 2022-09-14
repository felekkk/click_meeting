<?php
declare(strict_types=1);

namespace App\Service;

use App\ValueObject\Image;
use Symfony\Component\Finder\Finder;

class ImageFinderService extends AbstractImageService
{
    public function findImages(): array
    {
        $imagesFound = [];

        $finder = new Finder();
        $finder->files()->in($this->rootPath . $this->imageDirectory);

        foreach ($finder as $file) {
            $imageNameWithPath = $file->getRealPath();

            [
                0 => $imageWidth,
                1 => $imageHeight,
                'mime' => $imageMime
            ] = getimagesize($imageNameWithPath);

            $imagesFound[] = Image::create(
                $file->getRealPath(),
                $file->getRelativePathname(),
                $imageMime,
                $imageWidth,
                $imageHeight
            );
        }

        return $imagesFound;
    }
}