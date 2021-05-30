<?php

namespace App\Entity;

use App\Repository\ImgToProductRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ImgToProductRepository::class)
 */
class ImgToProduct
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\OneToOne(targetEntity=Img::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private Img $img;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="images")
     * @ORM\JoinColumn(nullable=false)
     */
    private Product $product;

    public function getId(): int
    {
        return $this->id;
    }

    public function getImg(): Img
    {
        return $this->img;
    }

    public function setImg(Img $img): self
    {
        $this->img = $img;

        return $this;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): self
    {
        $this->product = $product;

        return $this;
    }
}
