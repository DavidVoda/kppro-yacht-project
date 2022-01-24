<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', HiddenType::class)
            ->add('startTime', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['type' => 'text']
            ])
            ->add('endTime', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['type' => 'text']
            ])
            ->add('user', HiddenType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
                                   'data_class' => Reservation::class,
                               ]);
    }
}
