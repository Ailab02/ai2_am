<?php

namespace App\Form;

use App\Entity\Location;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Regex;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('city', null, [
            'constraints' => [
                new NotBlank(['groups' => ['edit', 'new']]),
                new Length(['min' => 2, 'groups' => ['edit', 'new']]),
            ],
        ])
        ->add('country', ChoiceType::class, [
            'choices' => [
                'Poland' => 'PL',
                'Germany' => 'DE',
                'France' => 'FR', 
                'Spain' => 'ES', 
                'Italy' => 'IT',
                'United Kingdom' => 'GB', 
                'United States' => 'US', 
            ],
            'constraints' => [
                new NotNull(['groups' => ['edit', 'new']]),
            ],
        ])
            ->add('latitude',  NumberType::class, [
                'constraints' => [
                    new NotBlank(['groups' => ['edit', 'new']]),
                    new Regex([
                        'pattern' => '/^\d+(\.\d+)?$/',
                        'message' => 'Latitude must be a valid number.',
                        'groups' => ['edit', 'new'],
                    ]),
                ],])
            ->add('longitude')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
            'validation_groups' => ['create', 'update'],
        ]);
    }
}
