<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LivreurRepository")
 * @ORM\Table(name="t_livreur")
 */
class Livreur
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="NomLivr" ,type="string", length=255)
     */
    private $NomLivr;

    /**
     * @ORM\Column(name="PrenomLivr" ,type="string", length=255)
     */
    private $PrenomLivr;

    /**
     * @ORM\Column(name="DatEmbauchLivr" , type="date", nullable=true)
     */
    private $DatEmbauchLivr;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomLivr(): ?string
    {
        return $this->NomLivr;
    }

    public function setNomLivr(string $NomLivr): self
    {
        $this->NomLivr = $NomLivr;

        return $this;
    }

    public function getPrenomLivr(): ?string
    {
        return $this->PrenomLivr;
    }

    public function setPrenomLivr(string $PrenomLivr): self
    {
        $this->PrenomLivr = $PrenomLivr;

        return $this;
    }

    public function getDatEmbauchLivr(): ?\DateTimeInterface
    {
        return $this->DatEmbauchLivr;
    }

    public function setDatEmbauchLivr(?\DateTimeInterface $DatEmbauchLivr): self
    {
        $this->DatEmbauchLivr = $DatEmbauchLivr;

        return $this;
    }
}
