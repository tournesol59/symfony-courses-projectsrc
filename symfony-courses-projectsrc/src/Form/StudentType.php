<?php

namespace App\Form;

use App\Entity\Student;
use App\Entity\Status;
use App\Entity\Course;
use App\Entity\Address;
use App\Form\AddressType;
use App\Repository\CourseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
// use App\Form\AddressType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class StudentType extends AbstractType
{
    private CourseRepository $courseRepository;

    //private Collection $courses;
    private array $courses;
    
    public function __construct(CourseRepository $courseRepository) {
	$this->courseRepository = $courseRepository;
	$this->courses = $this->courseRepository->findItemsLetterNAF();
	//$course1 = array_pop($this->courses); //debug
	//dd($course1->getCodeNAF());
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
	//dd(new Course('NSY104')); //debug
        $builder
            ->add('lastname')
	    ->add('email')
            ->add('status', ChoiceType::class, [
		    'choices' => [ 
			    new Status('general-student'),
			    new Status('apprentice-student'),
		    ],	    
		    // 'name' is a property path, meaning Symfony will look for a public property
		   'choice_value' => 'name',
		   // a callback to return the label for a given choice
		   'choice_label' => function(?Status $status): string {
			 
                         return $status? strtoupper($status->getName()): '';
		   },
	           // returns the html attributes for each option input (may be radio/checkbox)
	           'choice_attr' => function (?Status $status): array {
			   return $status? ['class' => 'status_'.strtolower($status->getName())] : [];
		   },
	    ])
	    //->add('address', CollectionType::class, [
	    	 //// each entry in the array will be an "address" field
            //	 'entry_type' => ChoiceType::class,
		 //// these options are passed to each "address" type
	    //'entry_options' => [
	    // ... i cannot ...
	    ->add('address', CollectionType::class, [
		    'entry_type' => ChoiceType::class,
		    'entry_options' => [
		        'choices' => [ 
				'Fenouillet' => new Address('Fenouillet', 31150),
				'Puteaux' => new Address('Puteaux', 92800),
				'Pin-Balma' => new Address('Pin Balma', 31130),
				'Quint-Fontsegrives' => new Address('Quint-Fonsegrives', 31130),
		        ],
		    ],
		    'allow_add' => 'true',
	     ])
		 // 
	    /* // dont work for ManyToMany: need a CollectionType:
	    ->add('courses', ChoiceType::class, [
		    // 'choices' => $this->courses,
		    'choices' => [
			    new Course('NSY103'),
			    new Course('NSY104'),
		    ],
		    'choice_value' => 'codeNAF',
		    'choice_label' => function(?Course $course): string {
			    dd($course); //debug
			    return $course? strtoupper($course->getCodeNAF()): '';
		    },
		    'choice_attr' => function (?Course $course): array {
			    dd($course); //debug
			    return $course? ['class' => 'course_'.strtolower($course->getCodeNAF())] : [];
		    },
	    ])  */
	    ->add('save' , SubmitType::class, [
	      'label' => "Envoyer"
	    ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
