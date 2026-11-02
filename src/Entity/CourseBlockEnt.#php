<?php

namespace App\Entity;

use App\Repository\CourseBlockRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Validator\CourseBlockCodeNAFValidator as BlockCodeNAFAssert;

#[ORM\Entity(repositoryClass: CourseBlockEntRepository::class)]
class CourseBlockEnt
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $codeRNCP = null;

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
}
?>
