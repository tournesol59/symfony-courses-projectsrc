<?php

namespace App\Controller;

use App\Entity\Course;
use App\Repository\CourseRepository;
use App\Form\CourseType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final class CourseController extends AbstractController
{
    private CourseRepository $courseRepository;

    public function __construct( CourseRepository $courseRepository) {
      $this->courseRepository = $courseRepository;
    }

    #[Route('/course', name: 'course.indexall', methods: ['GET', 'HEAD'])]
    public function indexall(Request $request): Response
    {	  
	$courses = $this->courseRepository->findAll();

	return $this->render('course/indexall.html.twig', [
		'courses' => $courses,
	]);
    }

    #[Route('/course/{id}', name: 'course.show', methods: ['GET', 'HEAD'])]
    public function show(int $id): Response
    {
	$course = $this->courseRepository->findOneById($id);

        return $this->render('course/show.html.twig', [
            'course' => $course,
        ]);
    }

    #[Route('/course/course/create', name: 'course.create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
	$course = new Course();
	$form = $this->createForm(CourseType::class, $course);
	$form->handleRequest($request);
	if ($form->isSubmitted() && $form->isValid()) {

		$em->persist($course);
		$em->flush();
		return $this->redirectToRoute('course.indexall');
	}
        return $this->render('course/create.html.twig', [
		'form' => $form,
		'course' => $course,
	]);
    }


    #[Route('/course/{id}/edit', name: 'course.edit', methods: ['GET', 'POST'])]
    public function edit(int $id, Request $request, EntityManagerInterface $em): Response
    {
        $course = $this->courseRepository->findOneById($id);
        $form->handleRequest($request);
	if ($form->isSubmitted() && $form->isValid()) {
	   $em->persist($course);
	   $em->flush();
	   return $this->redirectToRoute('course.indexall');

	}
	return $this->render('course/edit.html.twig', [
		'course' => $course,
		'form' => $form ]);
    }
}
