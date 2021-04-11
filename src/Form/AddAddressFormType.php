<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddAddressFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    final public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'city',
                TextType::class,
                [
                    'label' => 'city',
                    'required' => true,
                ]
            )
            ->add(
                'street',
                TextType::class,
                [
                    'label' => 'street',
                    'required' => true,
                ]
            )
            ->add(
                'house',
                TextType::class,
                [
                    'label' => 'house',
                    'required' => true,
                ]
            )
            ->add(
                'postal_code',
                IntegerType::class,
                [
                    'label' => 'postal_code',
                    'required' => true,
                ]
            )
            ->add(
                'phone',
                TextType::class,
                [
                    'label' => 'phone',
                    'required' => true,
                ]
            )
            ->add(
                'submit',
                SubmitType::class,
                [
                    'label' => 'address.add',
                ]
            );;
    }

    /**
     * @param OptionsResolver $resolver
     */
    final public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => Address::class,
            ]
        );
    }
}
