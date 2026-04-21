<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\Course;
use App\Entity\Status;
use App\Entity\Student;
use App\Form\AddressType;
use App\Repository\StatusRepository;
use App\Repository\AddressRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentAddressSelectType extends AbstractType
{
    private AddressRepository $addressRepository;
    private StatusRepository $statusRepository;
    private array $addresses;
    private array $statuses;

    public function __construct(AddressRepository $addressRepository, StatusRepository $statusRepository) {
	    $this->addressRepository = $addressRepository;
	    $this->statusRepository = $statusRepository;
	    $this->addresses = $this->addressRepository->findFirstThreeOnes();
        $this->statuses = $this->statusRepository->findAll();
	//$address1 = array_pop($this->addresses); //debug
	//dd($address1->getZipCode());
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname')
            ->add('email')
            ->add('status', ChoiceType::class, [
                //'class' => Status::class,
                'choices' => $this->statuses,
                'choice_value' => 'name',
                'choice_label' => function(?Status $status): string {
                    return $status? strtoupper($status->getName()): '';
                },
                'choice_attr' => function (?Status $status): array {
                    return $status? ['class' => 'status_'.strtolower($status->getName())] : [];
                },
            ])
           // ->add('courses', EntityType::class, [
           //     'class' => Course::class,
           //     'choice_label' => 'id',
           //     'multiple' => true,
           // ])
            ->add('address', CollectionType::class, [
                'entry_type' => AddressType::class,
                'entry_options' => [
                    'label' => false,
                ],
                'allow_add' => true,
                'allow_delete' => false,
            ])
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event): void {
                $address = $event->getData();
                $form = $event->getForm();

                // $address is the Address entity bound to this specific entry
                // in the collection; use it to conditionally add/modify fields
                if ($address && $address->getId()) {
                    $form->add('city', TextType::class, [
                        'disabled' => true,
                    ]);
                } else {
                    $form->add('city', TextType::class);
                }
            })
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
