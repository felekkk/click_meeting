<?php
declare(strict_types=1);

namespace App\Command;

use App\Service\ImageFinderService;
use App\Service\ImageResizerService;
use App\ValueObject\Image;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImageResizerCommand extends Command
{
    private const IMAGE_WIDTH_ARGUMENT = 'width';
    private const IMAGE_HEIGHT_ARGUMENT = 'height';

    private ImageFinderService $imageFinderService;
    private ImageResizerService $imageResizerService;

    public function __construct(ImageFinderService $imageFinderService, ImageResizerService $imageResizerService)
    {
        parent::__construct();

        $this->imageFinderService = $imageFinderService;
        $this->imageResizerService = $imageResizerService;
    }

    protected function configure(): void
    {
        $this
            ->addArgument(
                self::IMAGE_WIDTH_ARGUMENT,
                InputArgument::REQUIRED,
                'Resized image width in pixels.'
            )
            ->addArgument(
                self::IMAGE_HEIGHT_ARGUMENT,
                InputArgument::REQUIRED,
                'Resized image height in pixels.'
            )
            ->setName('app:resize')
            ->setDescription('Resizes all images in documents/images folder and saves it in cloud.')
            ->setHelp('This command allows you to resize a image and save in cloud.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        if ($input->getArgument(self::IMAGE_WIDTH_ARGUMENT) > 150) {
            $output->writeln(
                '<comment>Max width is 150px.</comment>'
            );

            return;
        }

        if ($input->getArgument(self::IMAGE_HEIGHT_ARGUMENT) > 150) {
            $output->writeln(
                '<comment>Max height is 150px.</comment>'
            );

            return;
        }

        $imagesFound = $this->imageFinderService->findImages();

        if (count($imagesFound) === 0) {
            $output->writeln(
                '<comment>No images found in documents/images folder.</comment>'
            );

            return;
        }

        /** @var Image $imageFound */
        foreach ($imagesFound as $imageFound) {
            $output->writeln(
                $this->imageResizerService->resizeAndSave(
                    $imageFound,
                    (int)$input->getArgument(self::IMAGE_WIDTH_ARGUMENT),
                    (int)$input->getArgument(self::IMAGE_HEIGHT_ARGUMENT)
                )
            );
        }
    }
}