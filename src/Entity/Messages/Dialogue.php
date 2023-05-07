<?php

namespace App\Entity\Messages;

use App\Repository\Messages\DialogueRepository;
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
    private ?int $from_u_id = null;

    #[ORM\Column]
    private ?int $to_u_id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $sended = null;

    #[ORM\Column]
    private ?int $message_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFromUid(): ?int
    {
        return $this->from_u_id;
    }

    public function setFromUid(int $from_u_id): self
    {
        $this->from_u_id = $from_u_id;

        return $this;
    }

    public function getToUid(): ?int
    {
        return $this->to_u_id;
    }

    public function setToUid(int $to_u_id): self
    {
        $this->to_u_id = $to_u_id;

        return $this;
    }

    public function getSended(): ?\DateTimeInterface
    {
        return $this->sended;
    }

    public function setSended(\DateTimeInterface $sended): self
    {
        $this->sended = $sended;

        return $this;
    }

    public function getMessageId(): ?int
    {
        return $this->message_id;
    }

    public function setMessageId(int $message_id): self
    {
        $this->message_id = $message_id;

        return $this;
    }
}
