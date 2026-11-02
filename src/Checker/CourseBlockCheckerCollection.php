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

   private string $codeRNCP;  // code of study's path, property of this instance
   private CourseBlockRepository $courseBlockRepository;
   private CourseBlockRefCodeNAFValidator $courseBlockValidator;

   private string $message;

   public function __construct( $codeRNCP, 
                        CourseBlockRepository $courseBlockRepository,
                        CourseBlockRefCodeNAFValidator $courseBlockValidator) {
      $this->codeRNCP = $codeRNCP;
      $this->courseBlockRepository = $courseBlockRepository;
      $this->courseBlockValidator = $courseBlockValidator;
    }
// we go in two step:
//  first step: when this class method below is called, it return a boolean but also sets and call the validator courseBlockValidator
//    array of codeNAF, so that the method validate of this validator can operate and return the same bool but also firing the message
//  second step: no second step! except that this class must be autowired in StudentController
   public function hasCourseFromRNCP(ArrayCollection $courses, String $detailRNCP) : bool 
   {
       $foundCourseMembersRNCP = compareCourseFromRNCP($courses, $detailRNCP);
       $courseBlockValidator.setFoundMembersCodeRNCP($foundCourseMemberRNCP);
       $courseBlockValidator->validate();
       return true; // always now the job is done by the validator
   }

   public function compareCourseFromRNCP(ArrayCollection $courses, String $detailRNCP) : array  {
	   // checker that a list of courses contains at least one course from another, mandatory, list of codeNAF's references of courses
       $foundCourseMembersRNCP = [];
       $fullRNCP = $codeRNCP.$detailRNCP; // eg: CYC9101+A1=CYC9101A1
       $courseBlock = $this->courseBlockRepository->findByCodeRNCP($fullRNCP);
       $course_mendate = $courseBlock->first();
       while ($course_mendate != null) {
           foreach ($courses as $course) {
		        if ($course->getCodeNAF() === $course_mendate->codeNAF()) {
	                $this->message = "course selection is valid";
                    // return true;
                      $foundCourseMembersRNCP.add($course->getCodeNAF());
	            }
	        }
	        $course_mendate = $courseBlock->next();
       }
       // then return an arra like: NO
       // $check_res = ['IMO' => $validIMO, 'ISI' => $validISI];
       $this->message = "course selection does not satisfy mandatory course";
       return $foundCourseMembersRNCP;
   }

}

