<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\Student;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Event\PreSetDataEvent;
use Symfony\Component\Form\FormEvents;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            //->add('city') // fred: commented here to apply a new 
                            // feature with PRE_SET_DATA events: only a non existing zip code
                            // will trigger the field 'city'
            ->add('zipcode')
            //->add('students', EntityType::class, [
            //    'class' => Student::class,
            //    'choice_label' => 'id',
            //    'multiple' => true,
            // ])
        ;

        // implement the new feature: see documentation "Showing Fields Only for New Entities
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (PreSetData $event): void {
                $address = $event->getData();
                $form = $event->getForm();

                $isNew = !($address) || null===$address->getZipCode();
                if (!$isNew) {
                    $city = $addressRepository->findOneByZipCode($address->getZipCode());
                    $isNew = (null===$city);
                }
                if ($isNew) {
                    $form->add('city', TextType::class, [
                    'help' => 'cannot be changed after creation',
                    ]);
                }
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
