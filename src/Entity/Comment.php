<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 */
class Comment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\BlogPost", inversedBy="comments")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $add_comment_date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getContent(): ?BlogPost
    {
        return $this->content;
    }

    public function setContent(?BlogPost $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getAddCommentDate(): ?\DateTimeInterface
    {
        return $this->add_comment_date;
    }

    public function setAddCommentDate(\DateTimeInterface $add_comment_date): self
    {
        $this->add_comment_date = $add_comment_date;

        return $this;
    }
}
