<?php

namespace App\Form\Type\Dropzone;

use App\Entity\Img;
use App\Repository\ImgRepository;
use Symfony\Component\Form\DataTransformerInterface;

class DropzoneTransformer implements DataTransformerInterface
{
    public function __construct(
        private ImgRepository $imgRepository,
        private array $options
    ) {
    }

    public function transform(mixed $value)
    {
        //dd($value);
    }

    public function reverseTransform(mixed $value): array|Img|null
    {
        if ($this->options['maxFiles'] === 1) {
            return $this->imgRepository->findOneBy(['id' => $value['dropzone']]);
        }

        return $this->imgRepository->findBy(['id' => $value['dropzone']]);
    }
}