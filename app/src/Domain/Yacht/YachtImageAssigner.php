<?php

declare(strict_types=1);

namespace App\Domain\Yacht;

use App\Entity\Yacht;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

final class YachtImageAssigner
{

    public function __construct(private string $yachtImagesDirectory, private SluggerInterface $slugger)
    {
    }

    public function assign(Yacht $yacht, File $image): void
    {
        $name = $image instanceof UploadedFile ? $image->getClientOriginalName() : $image->getFilename();
        $originalFilename = pathinfo($name, PATHINFO_FILENAME);

        $safeFilename = $this->slugger->slug($originalFilename);
        $newFilename = $safeFilename . '-' . uniqid('', true) . '.' . $image->guessExtension();

        try {
            $image->move(
                $this->yachtImagesDirectory,
                $newFilename
            );
        } catch (FileException $e) {
            var_dump($e);
            die();
        }

        $yacht->addImage($newFilename);
    }

    public function unassign(Yacht $yacht, int $imageIndex): void
    {
        if ($imageIndex > 0 && ($filename = $yacht->getImageFilenames()[$imageIndex] ?? null) !== null) {
            unlink("$this->yachtImagesDirectory/$filename");
            $yacht->removeImage($filename);
        }
    }
}
