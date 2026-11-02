<?php

namespace App\Entity;

use App\Entity\Course;
use App\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
class Student
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\ManyToOne(inversedBy: 'students', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Status $status = null;

/***  fred: added another field manually ***
 *     #[ORM\ManyToOne(inversedBy: 'students', cascade: ['persist'])]
 *     #[ORM\JoinColumn(nullable: false)]
       private ?CourseBlockEnt $courseBlockRNCP = null;

       instead of this: manually added field
       #[ORM\Column(length: 255)]
       private ?string $courseBlockRNCP = null;
 */
       #[ORM\Column(length: 255)]
       private ?string $courseBlockRNCP = null;   

    /**
     * @var Collection<int, Course>
     */
    #[ORM\ManyToMany(targetEntity: Course::class, inversedBy: 'students')]
    private Collection $courses;

    /**
     * @var Collection<int, Address>
     */
    #[ORM\ManyToMany(targetEntity: Address::class, inversedBy: 'students', cascade:  ["persist"])]
    private Collection $address;

    ///**
    // * @var Collection<int, Course>
	    // */
/*
    #[ORM\ManyToMany(targetEntity: Course::class, inversedBy: 'students')]
    private Collection $courses; 
*/

    public function __construct()
    {
       $this->courses = new ArrayCollection();
       $this->address = new ArrayCollection();
    } 
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): static
    {
        $this->status = $status;

        return $this;
    }
	    
    /*** fred getter setters of the temporarily added new field: courseBlockRNCP ***/
    public function getCourseBlockRNCP(): ?string
    {
        return $this->courseBlockRNCP;
    }

    public function setCourseBlockRNCP(?string $courseBlockRNCP): static
    {
        $this->courseBlockRNCP = $courseBlockRNCP;

        return $this;
    }


///**
// * @return Collection<int, Comment>
// */
/*
    public function getCourses(): Course
    {
        return $this->courses;
    }

    public function addCourse(Course $course): static
    {
	if (!$this->courses->contains($course)) {
           $this->courses->add($course);
	   $course->setStudent($this);
	}
        return $this;
    }
    
    public function removeCourse(Course $course): static
    {
        if ($this->courses->removeElement($course)) {
             // set the owning side to null (unless already changed)
            if ($course->getStudent() === $this) {
                $course->setStudent(null);
            }
          }

        return $this;
    }
 */

/**
 * @return Collection<int, Course>
 */
public function getCourses(): Collection
{
    return $this->courses;
}

public function addCourse(Course $course): static
{
    if (!$this->courses->contains($course)) {
        $this->courses->add($course);
    }

    return $this;
}

public function removeCourse(Course $course): static
{
    $this->courses->removeElement($course);

    return $this;
}

/**
 * @return Collection<int, Address>
 */
public function getAddress(): Collection
{
    return $this->address;
}

public function addAddress(Address $address): static
{
    if (!$this->address->contains($address)) {
        $this->address->add($address);
    }

    return $this;
}

public function removeAddress(Address $address): static
{
    $this->address->removeElement($address);

    return $this;
}
}
