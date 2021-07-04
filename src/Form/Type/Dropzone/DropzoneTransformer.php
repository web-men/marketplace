<?php

namespace App\Form\Type\Dropzone;

use App\Repository\ImgRepository;
use Symfony\Component\Form\DataTransformerInterface;

class DropzoneTransformer implements DataTransformerInterface
{
    public function __construct(
        private ImgRepository $imgRepository
    ) {
    }

    public function transform(mixed $value)
    {
        //dd($value);
    }

    public function reverseTransform(mixed $value): array
    {
        return $this->imgRepository->findBy(['id' => $value['dropzone']]);
    }
}