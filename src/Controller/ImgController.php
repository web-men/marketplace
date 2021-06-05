<?php

namespace App\Controller;

use App\Entity\Img;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImgController extends AbstractController
{
    #[Route('/img/upload', name: 'img.upload')]
    public function upload(
        Request $request,
        EntityManagerInterface $em
    ): Response {
        /** @var UploadedFile|null $file */
        $file = $request->files->get('file');
        $config = $this->getParameter('imgConfig');

        if ($file instanceof UploadedFile) {
            $fileName = uniqid('img', true).'.'.$file->guessExtension();

            $originalName = $file->getClientOriginalName();
            $size = $file->getSize();

            $fileUpload = $file->move($config['path'], $fileName);

            $url = $config['url'].$fileUpload->getFilename();
            $path = $fileUpload->getRealPath();
            $mime = $fileUpload->getMimeType();

            $img = (new Img())
                ->setCreatedAt(new DateTimeImmutable())
                ->setName($originalName)
                ->setMime($mime)
                ->setSize($size)
                ->setPath($path)
                ->setUrl($url);

            $em->persist($img);
            $em->flush();

            return $this->json(
                [
                    'success' => true,
                    'id' => $img->getId(),
                ]
            );
        }

        return $this->json(
            [
                'success' => false,
            ]
        );
    }

    #[Route('/img/load/{id<\d+>}', name: 'img.load', methods: ['GET'])]
    public function load(
        Img $img
    ): Response {
        return $this->json(
            [
                'success' => true,
                'data' => [
                    'id' => $img->getId(),
                    'name' => $img->getName(),
                    'url' => $img->getUrl(),
                    'size' => $img->getSize(),
                    'type' => $img->getMime(),
                ],
            ]
        );
    }

    #[Route('/img/delete/{id<\d+>}', name: 'img.delete', methods: ['GET'])]
    public function delete(
        Img $img,
        EntityManagerInterface $em,
        Filesystem $filesystem
    ): Response {
        $path = $img->getPath();
        $em->remove($img);
        $filesystem->remove($path);

        return $this->json(
            [
                'success' => true
            ]
        );
    }
}
