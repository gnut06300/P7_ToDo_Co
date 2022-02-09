<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
class Task
{
    public const ANONYMOUS_AUTHOR = 'Anonyme';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime_immutable')]
    private $createdAt;

    #[ORM\Column(type: 'string', length: 255)]
    #[NotBlank(message:'Le titre ne peut être vide.')]
    private $title;

    #[ORM\Column(type: 'text')]
    #[NotBlank(message:'Le contenu ne peut être vide.')]
    private $content;

    #[ORM\Column(type: 'boolean')]
    private $isDone;

    /**
     * @param bool $isDone
     * @return void
     */
    public function toggle(bool $isDone): void
    {
        $this->isDone = $isDone;
    }

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'tasks')]
    #[ORM\JoinColumn(nullable: true)]
    private $author;

    public function __construct()
    {
        $this->createdAt =new \DateTimeImmutable();
        $this->isDone = false;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getIsDone(): ?bool
    {
        return $this->isDone;
    }

    public function setIsDone(bool $isDone): self
    {
        $this->isDone = $isDone;

        return $this;
    }

    public function isDone(): bool
     {
         return $this->getIsDone() === true;
     }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }
    public function getDisplayUsername()
    {
        return $this->getAuthor() !== null ? $this->getAuthor()->getUsername() : self::ANONYMOUS_AUTHOR;
    }
}
