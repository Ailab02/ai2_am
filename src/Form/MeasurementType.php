<?php

namespace App\Form;

use App\Entity\Measurement;
use App\Entity\Location;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Form\Extension\Core\Type\NumberType;


class MeasurementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('celsius', NumberType::class, [
            'class' => Location::class,
            'choice_label' => 'city',
            'choice_value' => 'id'])
            ->add('date')
            ->add('celsius', NumberType::class, [
                'constraints' => [
                    new NotBlank(['groups' => ['edit', 'create']]),
                        new Range([
                            'min' => -100,
                            'max' => 60,
                            'minMessage' => 'Wartość musi być większa lub równa -100',
                            'maxMessage' => 'Wartość musi być mniejsza lub równa 60',
                            'groups' => ['edit', 'create']]),],])
            ->add('pressure', null, [
                'constraints' => [
                    new NotBlank(['groups' => ['edit', 'create']]),],])
            ->add('humidity', NumberType::class, [
                'constraints' => [
                    new NotBlank(['groups' => ['edit', 'new']]),
                    new Range([
                        'min' => 0,
                        'minMessage' => 'Humidity cannot be negative.',
                        'groups' => ['edit', 'new'],
                    ]),],])


    ;}

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Measurement::class,
            'validation_groups' => ['create', 'update'],
        ]);
    }
}
