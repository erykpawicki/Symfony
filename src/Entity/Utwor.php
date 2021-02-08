<?php

namespace App\Entity;

use App\Repository\UtworRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UtworRepository::class)
 */
class Utwor
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
    private $nazwautworu;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $wykonawca;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNazwautworu(): ?string
    {
        return $this->nazwautworu;
    }

    public function setNazwautworu(string $nazwautworu): self
    {
        $this->nazwautworu = $nazwautworu;

        return $this;
    }

    public function getWykonawca(): ?string
    {
        return $this->wykonawca;
    }

    public function setWykonawca(string $wykonawca): self
    {
        $this->wykonawca = $wykonawca;

        return $this;
    }
}
