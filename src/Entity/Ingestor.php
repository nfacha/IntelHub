<?php

namespace App\Entity;

use App\Enum\MessageProtocol;
use App\Enum\SourceType;
use App\Repository\IngestorRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IngestorRepository::class)]
class Ingestor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $protocol = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pull_ip = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pull_port = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $push_port = null;

    #[ORM\Column]
    private ?int $source_type = null;

    #[ORM\Column]
    private ?int $active = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pending_command = null;

    #[ORM\Column(nullable: true, options: ['default' => 0])]
    private ?int $processed_messages = null;

    #[ORM\Column(nullable: true, options: ['default' => 0])]
    private ?int $total_processed_messages = null;

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable $last_message_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getProtocol(): ?int
    {
        return $this->protocol;
    }

    public function setProtocol(int $protocol): self
    {
        $this->protocol = $protocol;

        return $this;
    }

    public function getPullIp(): ?string
    {
        return $this->pull_ip;
    }

    public function setPullIp(?string $pull_ip): self
    {
        $this->pull_ip = $pull_ip;

        return $this;
    }

    public function getPullPort(): ?string
    {
        return $this->pull_port;
    }

    public function setPullPort(?string $pull_port): self
    {
        $this->pull_port = $pull_port;

        return $this;
    }

    public function getPushPort(): ?string
    {
        return $this->push_port;
    }

    public function setPushPort(?string $push_port): self
    {
        $this->push_port = $push_port;

        return $this;
    }

    public function getSourceType(): ?int
    {
        return $this->source_type;
    }

    public function setSourceType(int $source_type): self
    {
        $this->source_type = $source_type;

        return $this;
    }

    public function getActive(): ?int
    {
        return $this->active;
    }

    public function setActive(int $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getPendingCommand(): ?string
    {
        return $this->pending_command;
    }

    public function setPendingCommand(?string $pending_command): self
    {
        $this->pending_command = $pending_command;

        return $this;
    }

    public function getProcessedMessages(): ?int
    {
        return $this->processed_messages;
    }

    public function setProcessedMessages(int $processed_messages): self
    {
        $this->processed_messages = $processed_messages;

        return $this;
    }

    public function getTotalProcessedMessages(): ?int
    {
        return $this->total_processed_messages;
    }

    public function setTotalProcessedMessages(int $total_processed_messages): self
    {
        $this->total_processed_messages = $total_processed_messages;

        return $this;
    }

    public function getLastMessageAt(): ?DateTimeImmutable
    {
        return $this->last_message_at;
    }

    public function setLastMessageAt(?DateTimeImmutable $last_message_at): self
    {
        $this->last_message_at = $last_message_at;

        return $this;
    }

    public function getTypeLabel()
    {
        return MessageProtocol::getLabel()[$this->protocol];
    }

    public function getSourceTypeLabel()
    {
        return SourceType::getLabel()[$this->source_type];
    }
}
