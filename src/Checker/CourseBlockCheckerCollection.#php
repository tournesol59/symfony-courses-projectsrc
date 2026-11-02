<?php

namespace App\Checker;

use App\Checker\CourseBlockChecker;
use App\Entity\CourseBlock;
use App\Repository\CourseBlockRepository;
use App\Entity\Course;
use App\Repository\CourseRepository;
use Doctrine\ORM\EntityManagerInterface;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

final class CourseBlockCheckerCollection extends CourseBlockChecker { // may be an interface 

   private String $codeRNCP;  // code of study's path, property of this instance
   private CourseBlockRepository $courseBlockRepository;

   private string $message;

   public function __construct( $codeRNCP, CourseBlockRepository $courseBlockRepository) {
      $this->codeRNCP = $codeRNCP;
      $this->courseBlockRepository = $courseBlockRepository;

    }

   public function hasCourseFromRNCP(ArrayCollection $courses, String $detailRNCP) : bool  {
	   // checker that a list of courses contains at least one course from another, mandatory, list of codeNAF's references of courses
       
       $fullRNCP = $codeRNCP.$detailRNCP; // eg: CYC9101+A1=CYC9101A1
       $courseBlock = $this->courseBlockRepository->findByCodeRNCP($fullRNCP);
       $course_mendate = $courseBlock->first();
       while ($course_mendate != null) {
           foreach ($courses as $course) {
		        if ($course->getCodeNAF() === $course_mendate->codeNAF()) {
	                $this->message = "course selection is valid";
                    return true;
	            }
	        }
	        $course_mendate = $courseBlock->next();
       }
       // then return an arra like: NO
       // $check_res = ['IMO' => $validIMO, 'ISI' => $validISI];
       $this->message = "course selection does not satisfy mandatory course";
       return false;
   }
}

