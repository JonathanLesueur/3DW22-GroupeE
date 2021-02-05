<?php

namespace App\Entity;

use App\Repository\DislikeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DislikeRepository::class)
 */
class Dislike
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="dislikes")
     */
    private $userId;

    /**
     * @ORM\ManyToOne(targetEntity=Message::class, inversedBy="dislikes")
     */
    private $messageId;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dislikedAt;

    public function __construct() {
        $this->dislikedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        return $this->userId;
    }

    public function setUserId(?User $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getMessageId(): ?Message
    {
        return $this->messageId;
    }

    public function setMessageId(?Message $messageId): self
    {
        $this->messageId = $messageId;

        return $this;
    }

    public function getDislikedAt(): ?\DateTimeInterface
    {
        return $this->dislikedAt;
    }

    public function setDislikedAt(\DateTimeInterface $dislikedAt): self
    {
        $this->dislikedAt = $dislikedAt;

        return $this;
    }
}
