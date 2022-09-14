<?php
declare(strict_types=1);

namespace App\Service;

use App\ValueObject\Image;

class ImageResizerService extends AbstractImageService
{
    private DropboxConnectService $dropboxConnectService;
    private string $dropboxDirectory;

    public function __construct(
        string $rootPath,
        string $imageDirectory,
        string $dropboxDirectory,
        DropboxConnectService $dropboxConnectService
    ) {
        parent::__construct($rootPath, $imageDirectory);

        $this->dropboxDirectory = $dropboxDirectory;
        $this->dropboxConnectService = $dropboxConnectService;
    }

    public function resizeAndSave(Image $image, int $width, int $height): string
    {
        switch ($image->getExtension()) {
            case 'image/png':
                return $this->resizePngImage($image, $width, $height);
            case 'image/jpeg':
                return $this->resizeJpgImage($image, $width, $height);
            default:
                return 'Not found expected extension for file in path: ' . $image->getPath();
        }
    }

    private function resizeJpgImage(Image $image, int $width, int $height): string
    {
        $src = imagecreatefromjpeg($image->getPath());
        $dst = imagecreatetruecolor($width, $height);

        imagecopyresampled(
            $dst,
            $src,
            0,
            0,
            0,
            0,
            $width,
            $height,
            $image->getWidth(),
            $image->getHeight()
        );
        imagejpeg($dst, $this->rootPath . $this->imageDirectory . $image->getName());

        $this->dropboxConnectService->save(
            $this->dropboxDirectory . $image->getName(),
            file_get_contents($this->rootPath . $this->imageDirectory . $image->getName())
        );

        return 'Successfully saved resized image with name: ' . $image->getName() . ' in cloud folder';
    }

    private function resizePngImage(Image $image, int $width, int $height): string
    {
        $src = imagecreatefrompng($image->getPath());
        $dst = imagecreatetruecolor($width, $height);

        imagecopyresampled(
            $dst,
            $src,
            0,
            0,
            0,
            0,
            $width,
            $height,
            $image->getWidth(),
            $image->getHeight()
        );
        imagepng($dst, $this->rootPath . $this->imageDirectory . $image->getName());

        $this->dropboxConnectService->save(
            $this->dropboxDirectory . $image->getName(),
            file_get_contents($this->rootPath . $this->imageDirectory . $image->getName())
        );

        return 'Successfully saved resized image with name: ' . $image->getName() . ' in cloud folder';
    }
}