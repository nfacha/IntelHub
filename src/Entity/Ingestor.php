<?php

namespace App\Entity;

use App\Repository\IngestorRepository;
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
    private ?int $type = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pull_ip = null;

	#[ORM\Column( length: 255, nullable: true )]
	private ?string $pull_port = null;

	#[ORM\Column( length: 255, nullable: true )]
	private ?string $push_port = null;

	#[ORM\Column]
	private ?int $source_type = null;

	#[ORM\Column]
	private ?int $active = null;

	#[ORM\Column( length: 255, nullable: true )]
	private ?string $pending_command = null;

	public function getId(): ?int {
		return $this->id;
	}

	public function getName(): ?string {
		return $this->name;
	}

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

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

	public function getSourceType(): ?int {
		return $this->source_type;
	}

	public function setSourceType( int $source_type ): self {
		$this->source_type = $source_type;

		return $this;
	}

	public function getActive(): ?int {
		return $this->active;
	}

	public function setActive( int $active ): self {
		$this->active = $active;

		return $this;
	}

	public function getPendingCommand(): ?string {
		return $this->pending_command;
	}

	public function setPendingCommand( ?string $pending_command ): self {
		$this->pending_command = $pending_command;

		return $this;
	}
}
