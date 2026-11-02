<?php

namespace App\Controller;


use App\Entity\Student;
use App\Entity\Address;
use App\Repository\StudentRepository;
use App\Repository\AddressRepository;
use App\Form\StudentType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class StudentAddressController extends AbstractController
{
    #[Route('/student/{id}/showaddr', name: 'student.showaddr', methods: ['GET', 'HEAD']    )]
    public function indexaddr(int $id, ): Response
    {
        return $this->render('student_address/indexaddr.html.twig', [
            'controller_name' => 'StudentAddressController',
        ]);
    }

    #[Route('/student/{id}/editaddr', name: 'student.editaddr', methods: ['GET', 'POST'])]
    public function editaddr(int $id, StatusRepository $statusRepository, 
				CourseRepository $courseRepository, AddressRepository $addressRepository, 
				Request $request, EntityManagerInterface $em): Response
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
                    // refresh the address2 with the one in database to avoid duplicates
					$student->removeAddress($address2);
					//$address2 = new Address($address2->getCity(), $address2->getZipcode());
					//$em->persist($address2);
					$student->addAddress($sampAddress2);
				} else {
				//do nothing
				}
			}
			$em->persist($student); // will persist the new address if it is not already in database, otherwise with the existing one
			$em->flush();
			return $this->redirectToRoute('student.indexall');
		}
		return $this->render('student/editaddr.html.twig', [
	    	'form' => $form,
            'student' => $student,
        ]);
    }

}
