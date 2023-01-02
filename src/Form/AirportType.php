<?php

namespace App\Form;

use App\Entity\Airport;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AirportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ident')
            ->add('type')
            ->add('name')
            ->add('latitude')
            ->add('longitude')
            ->add('elevation_ft')
            ->add('scheduled_service')
            ->add('icao')
            ->add('iata')
            ->add('external_id');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Airport::class,
        ]);
    }
}
