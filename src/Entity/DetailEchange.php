<?php

namespace App\Entity;

use App\Repository\DetailEchangeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DetailEchangeRepository::class)]
class DetailEchange
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;



    #[ORM\Column]
    private ?float $prix_echange = null;

    #[ORM\Column]
    private ?int $nombre_de_cartes = null;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getPrixEchange(): ?float
    {
        return $this->prix_echange;
    }

    public function setPrixEchange(float $prix_echange): static
    {
        $this->prix_echange = $prix_echange;

        return $this;
    }

    public function getNombreDeCartes(): ?int
    {
        return $this->nombre_de_cartes;
    }

    public function setNombreDeCartes(int $nombre_de_cartes): static
    {
        $this->nombre_de_cartes = $nombre_de_cartes;

        return $this;
    }
}
