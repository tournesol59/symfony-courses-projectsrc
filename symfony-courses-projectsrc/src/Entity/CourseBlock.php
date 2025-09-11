<?php

namespace App\Entity;

use App\Repository\CourseBlockRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Validator\CourseBlockCodeNAFValidator as BlockCodeNAFAssert;

#[ORM\Entity(repositoryClass: CourseBlockRepository::class)]
class CourseBlock
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $codeRNCP = null;

    #[ORM\Column(length: 255)]
    #[BlockCodeNAFAssert\CourseBlockCodeNAFValidator]
    private ?string $codeNAF = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[BlockCodeNAFAssert\CourseBlockCodeNAFValidator]
    private ?string $precedeNAF = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeRNCP(): ?string
    {
        return $this->codeRNCP;
    }

    public function setCodeRNCP(string $codeRNCP): static
    {
        $this->codeRNCP = $codeRNCP;

        return $this;
    }

    public function getCodeNAF(): ?string
    {
        return $this->codeNAF;
    }

    public function setCodeNAF(string $codeNAF): static
    {
        $this->codeNAF = $codeNAF;

        return $this;
    }

    public function getPrecedeNAF(): ?string
    {
        return $this->precedeNAF;
    }

    public function setPrecedeNAF(?string $precedeNAF): static
    {
        $this->precedeNAF = $precedeNAF;

        return $this;
    }
}
