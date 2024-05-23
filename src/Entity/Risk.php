<?php

namespace App\Entity;

use App\Repository\RiskRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RiskRepository::class)]
class Risk
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $riskDescription = null;

    #[ORM\Column(length: 50)]
    private ?string $likelihood = null;

    #[ORM\Column(length: 50)]
    private ?string $impact = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $mitigationMeasures = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRiskDescription(): ?string
    {
        return $this->riskDescription;
    }

    public function setRiskDescription(string $riskDescription): static
    {
        $this->riskDescription = $riskDescription;

        return $this;
    }

    public function getLikelihood(): ?string
    {
        return $this->likelihood;
    }

    public function setLikelihood(string $likelihood): static
    {
        $this->likelihood = $likelihood;

        return $this;
    }

    public function getImpact(): ?string
    {
        return $this->impact;
    }

    public function setImpact(string $impact): static
    {
        $this->impact = $impact;

        return $this;
    }

    public function getMitigationMeasures(): ?string
    {
        return $this->mitigationMeasures;
    }

    public function setMitigationMeasures(string $mitigationMeasures): static
    {
        $this->mitigationMeasures = $mitigationMeasures;

        return $this;
    }
}
