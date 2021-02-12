<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MessageRepository::class)
 */
class Message
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
    private $title;

    /**
     * @ORM\Column(type="string", length=2000, nullable=false)
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $visible;

    /**
     * @ORM\OneToMany(targetEntity=MessageResponse::class, mappedBy="messageBase_id")
     */
    private $messageRep_id;

    /**
     * @ORM\OneToMany(targetEntity=MessageResponse::class, mappedBy="messageRep_id")
     */
    private $messageResponses;

    /**
     * @ORM\OneToMany(targetEntity=Like::class, mappedBy="messageId")
     */
    private $likes;

    /**
     * @ORM\OneToMany(targetEntity=Dislike::class, mappedBy="messageId")
     */
    private $dislikes;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="messages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Report::class, mappedBy="message")
     */
    private $reports;

    public function __construct()
    {
        $this->messageRep_id = new ArrayCollection();
        $this->messageResponses = new ArrayCollection();
        $this->likes = new ArrayCollection();
        $this->dislikes = new ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
        $this->visible = 1;
        $this->title = '';
        $this->reports = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getVisible(): ?bool
    {
        return $this->visible;
    }

    public function setVisible(bool $visible): self
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * @return Collection|MessageResponse[]
     */
    public function getMessageRepId(): Collection
    {
        return $this->messageRep_id;
    }

    public function addMessageRepId(MessageResponse $messageRepId): self
    {
        if (!$this->messageRep_id->contains($messageRepId)) {
            $this->messageRep_id[] = $messageRepId;
            $messageRepId->setMessageBaseId($this);
        }

        return $this;
    }

    public function removeMessageRepId(MessageResponse $messageRepId): self
    {
        if ($this->messageRep_id->removeElement($messageRepId)) {
            // set the owning side to null (unless already changed)
            if ($messageRepId->getMessageBaseId() === $this) {
                $messageRepId->setMessageBaseId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|MessageResponse[]
     */
    public function getMessageResponses(): Collection
    {
        return $this->messageResponses;
    }

    public function addMessageResponse(MessageResponse $messageResponse): self
    {
        if (!$this->messageResponses->contains($messageResponse)) {
            $this->messageResponses[] = $messageResponse;
            $messageResponse->setMessageRepId($this);
        }

        return $this;
    }

    public function removeMessageResponse(MessageResponse $messageResponse): self
    {
        if ($this->messageResponses->removeElement($messageResponse)) {
            // set the owning side to null (unless already changed)
            if ($messageResponse->getMessageRepId() === $this) {
                $messageResponse->setMessageRepId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Like[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(Like $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->setMessageId($this);
        }

        return $this;
    }

    public function removeLike(Like $like): self
    {
        if ($this->likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getMessageId() === $this) {
                $like->setMessageId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Dislike[]
     */
    public function getDislikes(): Collection
    {
        return $this->dislikes;
    }

    public function addDislike(Dislike $dislike): self
    {
        if (!$this->dislikes->contains($dislike)) {
            $this->dislikes[] = $dislike;
            $dislike->setMessageId($this);
        }

        return $this;
    }

    public function removeDislike(Dislike $dislike): self
    {
        if ($this->dislikes->removeElement($dislike)) {
            // set the owning side to null (unless already changed)
            if ($dislike->getMessageId() === $this) {
                $dislike->setMessageId(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Report[]
     */
    public function getReports(): Collection
    {
        return $this->reports;
    }

    public function addReport(Report $report): self
    {
        if (!$this->reports->contains($report)) {
            $this->reports[] = $report;
            $report->setMessage($this);
        }

        return $this;
    }

    public function removeReport(Report $report): self
    {
        if ($this->reports->removeElement($report)) {
            // set the owning side to null (unless already changed)
            if ($report->getMessage() === $this) {
                $report->setMessage(null);
            }
        }

        return $this;
    }
}
