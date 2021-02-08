<?php

namespace App\Entity;

use App\Repository\RodzajRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RodzajRepository::class)
 */
class Rodzaj
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nazwa;

    /**
     * @ORM\OneToMany(targetEntity=Sampel::class, mappedBy="rodzaj")
     */
    private $sampels;

    public function __construct()
    {
        $this->sampels = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNazwa(): ?string
    {
        return $this->nazwa;
    }

    public function setNazwa(string $nazwa): self
    {
        $this->nazwa = $nazwa;

        return $this;
    }


    public function __toString()
    {
        return $this->nazwa;
    }

    /**
     * @return Collection|Sampel[]
     */
    public function getSampels(): Collection
    {
        return $this->sampels;
    }

    public function addSampel(Sampel $sampel): self
    {
        if (!$this->sampels->contains($sampel)) {
            $this->sampels[] = $sampel;
            $sampel->setRodzaj($this);
        }

        return $this;
    }

    public function removeSampel(Sampel $sampel): self
    {
        if ($this->sampels->removeElement($sampel)) {
            // set the owning side to null (unless already changed)
            if ($sampel->getRodzaj() === $this) {
                $sampel->setRodzaj(null);
            }
        }

        return $this;
    }
}
