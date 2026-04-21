<?php

namespace App\Controller;

use App\Entity\Student;
use App\Entity\Course;
use App\Entity\Status;
use App\Repository\StudentRepository;
use App\Repository\StatusRepository;
use App\Repository\CourseRepository;
use App\Repository\CourseBlockRepository;
use App\Repository\AddressRepository;

use App\Form\StudentType;
use App\Form\CourseType;
use App\Checker\CourseBlockCheckerCollection;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class StudentController extends AbstractController
{
    private StudentRepository $studentRepository;

    private CourseBlockCheckerCollection $courseChecker;
// there is one direct Dependency (studentRepository) and another one (cbRepository) wh is indirect
    public function __construct( StudentRepository $studentRepository, CourseBlockRepository $cbRepository) {
       $this->studentRepository = $studentRepository;
       $this->courseChecker = new CourseBlockCheckerCollection('CYC9101', $cbRepository);
    }

    #[Route('/student', name: 'student.indexall', methods: ['GET', 'HEAD'])]
    public function indexall(): Response
    {
	$students = $this->studentRepository->findAll();

        return $this->render('student/indexall.html.twig', [
            'students' => $students,
        ]);
    }

    #[Route('/student/status/{statusid}', name: 'student.indexstatus', methods: ['GET', 'HEAD'])]
    public function indexstatus(string $statusid): Response
    {
	$students = $this->studentRepository->findByStatusId($statusid);
// we keep the same view because it contains hyperlinks on particular entries
	return $this->render('student/indexall.html.twig', [
		'students' => $students,
	]);
    }

    #[Route('/student/{id}', name: 'student.show', methods: ['GET','HEAD'])]
    public function show(int $id, StatusRepository $statusRepository): Response
    {
	$student = $this->studentRepository->findOneById($id);
        $status = $statusRepository->findOneById($student->getStatus());
        return $this->render('student/show.html.twig', [
		'student' => $student,
		'status' => $status,
        ]);
    }

    #[Route('/student/student/create', name: 'student.create', methods: ['GET', 'POST'])]
    public function create(StatusRepository $statusRepository, CourseRepository $courseRepository, AddressRepository $addressRepository, Request $request, EntityManagerInterface $em): Response
    {
	  
	$student = new Student();
//	$status = $statusRepository->findOneById(1);
//	$student->setStatus($status);
//	
//	$course1 = $courseRepository->findOneByCodeNAF('NSY102');
//	$student->addCourse($course1);

	$address1 = $addressRepository->findOneByCity('Fenouillet');
	$student->addAddress($address1);
	$address2 = $addressRepository->findOneByCity('Quint Fonsegrives');
	$student->addAddress($address2);
	// dd($address1); // debug

	$course2 = $courseRepository->findOneByCodeNAF('SEC102');
	$student->addCourse($course2);

        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);	
	if ($form->isSubmitted() && $form->isValid()) {
		
		// fred TODO: refresh the $course in foreach $courses : $course, from QueryCodeNAF(..)
		/*
		$courses = $student->getCourses();
		
		$result = $courses->first();
		if ($result != null) {
		  $course1 = new Course($result->getCodeNAF());
		  // refresh
		  $student->removeCourse($course1);
		  $course1 = $courseRepository->findOneByCodeNAF($course1->getCodeNAF());
		  $student->addCourse($course1);
		}

		// address
		$adresses = $student->getAddress();
		$address1 = $adresses->first();
		if ($adress1 != null) {
		   $address2 = new Address($address1->getCity());
		   // refresh
		   $student->removeAddress($address1);
		   $address2 = $addressRepository->findOneByCity($address1->getCity());
		   $student->addAddress($course2);
		}
 */
		
               // dd($student); //debug
		$em->persist($student);
		$em->flush();
		return $this->redirectToRoute('student.indexall');
	}

	return $this->render('student/create.html.twig', [
	    'form' => $form,
            'student' => $student,
        ]);
    }


   #[Route('/student/{id}/edit', name: 'student.edit', methods: ['GET', 'POST'])]
    public function edit(int $id, StatusRepository $statusRepository, CourseRepository $courseRepository, AddressRepository $addressRepository, Request $request, EntityManagerInterface $em): Response
    {
		$student = $this->studentRepository->findOneById($id);
		//dd($student);
		if (empty($student->getAddress()->first())) {
	   		//dd($student);
	   		$address1 = $addressRepository->findOneByCity('Pin Balma');
	   		$student->addAddress($address1);
		} else {
            $address1 = $student->getAddress()->first();
		}
	    $form = $this->createForm(StudentAddressSelectType::class, $student);
        $form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
            //    dd($student); //debug
			$em->persist($student);
			$em->flush();
			return $this->redirectToRoute('student.indexall');
		}	
	return $this->render('student/editaddr.html.twig', [
	    'form' => $form,
            'student' => $student,
        ]);

    }

    #[Route('/student/{id}/editaddr', name: 'student.editaddr', methods: ['GET', 'POST'])]
    public function editaddr(int $id, StatusRepository $statusRepository, CourseRepository $courseRepository, AddressRepository $addressRepository, Request $request, EntityManagerInterface $em): Response
    { 
	$student = $this->studentRepository->findOneById($id);
	//dd($student);
	if (empty($student->getAddress()->first())) {
	   //dd($student);
	   $address1 = $addressRepository->findOneByCity('Pin Balma');
	   $student->addAddress($address1);
	}
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);	
	if ($form->isSubmitted() && $form->isValid()) {
            //    dd($student); //debug
		$address1 = $student->getAddress()->first();
		if (!empty($student->getAddress()->get(2))) {
			$address2 = $student->getAddress()->get(2);
			$sampAddress2 = $addressRepository->findOneByCity($address2->getCity());
			if (!($sampAddress2 == null)) {
				$student->removeAddress($address2);
				//$address2 = new Address($address2->getCity(), $address2->getZipcode());
				//$em->persist($address2);
				$student->addAddress($sampAddress2);
			} else {
				//TBC
			}
		}
		$em->persist($student);
		$em->flush();
		return $this->redirectToRoute('student.indexall');
	}
	return $this->render('student/edit.html.twig', [
	    'form' => $form,
            'student' => $student,
        ]);

    }

    // the only difference with the edit and create methods is that check performs a validation after insert (flush) on database and display a message
    #[Route('/student/{id}/check', name: 'student.check', methods: ['GET', 'POST'])]
    public function check(int $id, StatusRepository $statusRepository, CourseRepository $courseRepository, AddressRepository $addressRepository, Request $request, EntityManagerInterface $em): Response
    {
	$student = $this->studentRepository->findOneById($id);

        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);	
	if ($form->isSubmitted() && $form->isValid()) {
	    $csvalid = $this->courseChecker->hasCourseFromRNCP($student->getCourses(), 'A1');
            if ($csvalid) { 
                //dd($student); //debug
		$em->persist($student);
		$em->flush();
		return $this->redirectToRoute('student.indexall');
	    }
	}

	return $this->render('student/edit.html.twig', [
	    'form' => $form,
	    'student' => $student,
	    'check' => $this->courseChecker,
        ]);

    }


}
