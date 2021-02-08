<?php

namespace App\Entity;

use App\Repository\SampelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SampelRepository::class)
 */
class Sampel
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nazwa;

    /**
     * @ORM\ManyToOne(targetEntity=Instrument::class, inversedBy="sampels")
     */
    private $instrument;

    /**
     * @ORM\ManyToOne(targetEntity=Rodzaj::class, inversedBy="sampels")
     */
    private $rodzaj;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNazwa(): ?string
    {
        return $this->nazwa;
    }

    public function setNazwa(?string $nazwa): self
    {
        $this->nazwa = $nazwa;

        return $this;
    }

    public function getInstrument(): ?Instrument
    {
        return $this->instrument;
    }

    public function setInstrument(?Instrument $instrument): self
    {
        $this->instrument = $instrument;

        return $this;
    }

    public function getRodzaj(): ?Rodzaj
    {
        return $this->rodzaj;
    }

    public function setRodzaj(?Rodzaj $rodzaj): self
    {
        $this->rodzaj = $rodzaj;

        return $this;
    }


}
