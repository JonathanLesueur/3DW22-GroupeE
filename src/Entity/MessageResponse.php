<?php

namespace App\Entity;

use App\Repository\MessageResponseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MessageResponseRepository::class)
 */
class MessageResponse
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Message::class, inversedBy="messageRep_id")
     * @ORM\JoinColumn(nullable=false)
     */
    private $messageBase_id;

    /**
     * @ORM\ManyToOne(targetEntity=Message::class, inversedBy="messageResponses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $messageRep_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessageBaseId(): ?Message
    {
        return $this->messageBase_id;
    }

    public function setMessageBaseId(?Message $messageBase_id): self
    {
        $this->messageBase_id = $messageBase_id;

        return $this;
    }

    public function getMessageRepId(): ?Message
    {
        return $this->messageRep_id;
    }

    public function setMessageRepId(?Message $messageRep_id): self
    {
        $this->messageRep_id = $messageRep_id;

        return $this;
    }
}
