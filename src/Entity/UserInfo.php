<?php

namespace App\Entity;

use App\Repository\UserInfoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserInfoRepository::class)]
class UserInfo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $BIO = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $birthday = null;

    #[ORM\Column(nullable: true)]
    private ?int $attachment_id = null;

    #[ORM\Column]
    private ?int $user_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBIO(): ?string
    {
        return $this->BIO;
    }

    public function setBIO(string $BIO): self
    {
        $this->BIO = $BIO;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

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

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }
}
