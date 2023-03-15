<?php

namespace App\Entity;

use App\Repository\MessagesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessagesRepository::class)]
class Messages
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $user_sender = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $message = null;

    #[ORM\Column]
    private ?int $dialogue_id = null;

    #[ORM\Column(nullable: true)]
    private ?int $attachment_id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $send_time = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserSender(): ?int
    {
        return $this->user_sender;
    }

    public function setUserSender(int $user_sender): self
    {
        $this->user_sender = $user_sender;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getDialogueId(): ?int
    {
        return $this->dialogue_id;
    }

    public function setDialogueId(int $dialogue_id): self
    {
        $this->dialogue_id = $dialogue_id;

        return $this;
    }

    public function getAttachmentId(): ?int
    {
        return $this->attachment_id;
    }

    public function setAttachmentId(int $attachment_id): self
    {
        $this->attachment_id = $attachment_id;

        return $this;
    }

    public function getSendTime(): ?\DateTimeInterface
    {
        return $this->send_time;
    }

    public function setSendTime(\DateTimeInterface $send_time): self
    {
        $this->send_time = $send_time;

        return $this;
    }
}
