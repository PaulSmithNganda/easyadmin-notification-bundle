<?php

namespace PaulLab\NotificationBundle\Entity;

use Doctrine\DBAL\Types\Types;
use PaulLab\NotificationBundle\Repository\NotificationRepository;
use PaulLab\NotificationBundle\ValueObject\NotificationLevel;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotificationRepository::class)]
class Notification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: false)]
    private ?DateTimeInterface $send_at = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $source = null;

    #[ORM\Column(type: "notification_level")]
    private NotificationLevel $level;

    #[ORM\Column(type: Types::TEXT)]
    private string $message = '';

    #[ORM\Column(nullable: true)]
    private ?DateTimeInterface $read_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSendAt(): ?DateTimeInterface
    {
        return $this->send_at;
    }

    public function setSendAt(?DateTimeInterface $date): self
    {
        $this->send_at = $date;

        return $this;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(?string $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function getLevel(): ?NotificationLevel
    {
        return $this->level;
    }

    public function setLevel(NotificationLevel $level): self
    {
        $this->level = $level;

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

    public function getReadAt(): ?DateTimeInterface
    {
        return $this->read_at;
    }

    public function setReadAt(?DateTimeInterface $read_at): self
    {
        $this->read_at = $read_at;

        return $this;
    }

    public function markRead(DateTimeInterface $readAt): self
    {
        if (null === $this->read_at) {
            $this->read_at = $readAt;
        }
        return $this;
    }

    public function __toString(): string
    {
        if (empty($this->source)) {
            return $this->message;
        }
        return sprintf('%s: %s', $this->source, $this->message);
    }
}
