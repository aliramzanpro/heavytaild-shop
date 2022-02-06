<?php

namespace App\Entity;

use App\Repository\SizeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SizeRepository::class)
 */
class Size
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $S;

    /**
     * @ORM\Column(type="integer")
     */
    private $M;

    /**
     * @ORM\Column(type="integer")
     */
    private $L;

    /**
     * @ORM\Column(type="integer")
     */
    private $XL;

    /**
     * @ORM\Column(type="integer")
     */
    private $XS;

    /**
     * @ORM\Column(type="integer")
     */
    private $XXL;

    /**
     * @ORM\ManyToMany(targetEntity=Product::class, inversedBy="sizes")
     */
    private $product;

    public function __construct()
    {
        $this->product = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getS(): ?int
    {
        return $this->S;
    }

    public function setS(int $S): self
    {
        $this->S = $S;

        return $this;
    }

    public function getM(): ?int
    {
        return $this->M;
    }

    public function setM(int $M): self
    {
        $this->M = $M;

        return $this;
    }

    public function getL(): ?int
    {
        return $this->L;
    }

    public function setL(int $L): self
    {
        $this->L = $L;

        return $this;
    }

    public function getXL(): ?int
    {
        return $this->XL;
    }

    public function setXL(int $XL): self
    {
        $this->XL = $XL;

        return $this;
    }

    public function getXS(): ?int
    {
        return $this->XS;
    }

    public function setXS(int $XS): self
    {
        $this->XS = $XS;

        return $this;
    }

    public function getXXL(): ?int
    {
        return $this->XXL;
    }

    public function setXXL(int $XXL): self
    {
        $this->XXL = $XXL;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProduct(): Collection
    {
        return $this->product;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->product->contains($product)) {
            $this->product[] = $product;
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        $this->product->removeElement($product);

        return $this;
    }
}
