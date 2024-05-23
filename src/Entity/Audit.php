<?php

namespace App\Entity;

use App\Repository\AuditRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuditRepository::class)]
class Audit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $auditDate = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $findings = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $recommendations = null;

    #[ORM\Column(length: 50)]
    private ?string $status = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuditDate(): ?\DateTimeInterface
    {
        return $this->auditDate;
    }

    public function setAuditDate(\DateTimeInterface $auditDate): static
    {
        $this->auditDate = $auditDate;

        return $this;
    }

    public function getFindings(): ?string
    {
        return $this->findings;
    }

    public function setFindings(string $findings): static
    {
        $this->findings = $findings;

        return $this;
    }

    public function getRecommendations(): ?string
    {
        return $this->recommendations;
    }

    public function setRecommendations(string $recommendations): static
    {
        $this->recommendations = $recommendations;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }
}
