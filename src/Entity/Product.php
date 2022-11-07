<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Integer;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 75)]
    private $nomination;

    #[ORM\Column(length: 75)]
    private $produit;

    #[ORM\Column(length: 75)]
    private $fournisseur;

    #[ORM\Column(length: 45)]
    private $reference;

    #[ORM\Column(length: 75)]
    private $rangement;

    #[ORM\Column(length: 75)]
    private $numeroDeLot;

    #[ORM\Column(length: 75)]
    private $peremption;

    #[ORM\Column(length: 75, nullable: true)]
    private $defalcation;

    #[ORM\Column(nullable: true)]
    private ?int $stockMin = null;

    #[ORM\Column]
    private ?int $stockReel = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?int $preleve = null;

    /**
     * @throws \Exception
     */
    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable("now", new \DateTimeZone('Europe/Paris'));
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomination(): ?string
    {
        return $this->nomination;
    }

    public function setNomination(string $nomination): self
    {
        $this->nomination = $nomination;

        return $this;
    }

    public function getProduit(): ?string
    {
        return $this->produit;
    }

    public function setProduit(string $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    public function getFournisseur(): ?string
    {
        return $this->fournisseur;
    }

    public function setFournisseur(string $fournisseur): self
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getRangement(): ?string
    {
        return $this->rangement;
    }

    public function setRangement(string $rangement): self
    {
        $this->rangement = $rangement;

        return $this;
    }

    public function getNumeroDeLot(): ?string
    {
        return $this->numeroDeLot;
    }

    public function setNumeroDeLot(string $numeroDeLot): self
    {
        $this->numeroDeLot = $numeroDeLot;

        return $this;
    }

    public function getPeremption(): ?string
    {
        return $this->peremption;
    }

    public function setPeremption(string $peremption): self
    {
        $this->peremption = $peremption;

        return $this;
    }

    public function getDefalcation(): ?string
    {
        return $this->defalcation;
    }

    public function setDefalcation(string $defalcation): self
    {
        $this->defalcation = $defalcation;

        return $this;
    }

    public function getStockMin(): ?int
    {
        return $this->stockMin;
    }

    public function setStockMin(?int $stockMin): self
    {
        $this->stockMin = $stockMin;

        return $this;
    }

    public function getStockReel(): ?int
    {
        return $this->stockReel;
    }

    public function setStockReel(int $stockReel): self
    {
        $this->stockReel = $stockReel;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getPreleve(): ?int
    {
        return $this->preleve;
    }

    public function setPreleve(?int $preleve): self
    {
        $this->preleve = $preleve;

        return $this;
    }
}
