<?php

namespace App\Entity;

use App\Repository\DialogueRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DialogueRepository::class)]
class Dialogue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $user_initiator = null;

    #[ORM\Column]
    private ?int $user_participant = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $last_message = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserInitiator(): ?int
    {
        return $this->user_initiator;
    }

    public function setUserInitiator(int $user_initiator): self
    {
        $this->user_initiator = $user_initiator;

        return $this;
    }

    public function getUserParticipant(): ?int
    {
        return $this->user_participant;
    }

    public function setUserParticipant(int $user_participant): self
    {
        $this->user_participant = $user_participant;

        return $this;
    }

    public function getLastMessage(): ?\DateTimeInterface
    {
        return $this->last_message;
    }

    public function setLastMessage(\DateTimeInterface $last_message): self
    {
        $this->last_message = $last_message;

        return $this;
    }
}
