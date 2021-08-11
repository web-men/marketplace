<?php

namespace App\Form;

use App\Entity\ProductOption;
use App\Form\Type\Dropzone\DropzoneType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductOptionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('img', DropzoneType::class, [
                'label' => 'img.add',
                'attr' => [
                    //Уникальный id нужен будет для загрузки изоброжений
                    'id' => 'imgProductOption'
                ],
                'maxFiles' => 1,
                'addRemoveLinks' => true
            ])
            ->add('name', TextType::class, [
                'label' => 'product.name',
            ])
            ->add('count', IntegerType::class, [
                'label' => 'product.count',
            ])
            ->add('description', TextType::class , [
                'label' => 'product.description'
            ])
            ->add('productPrice', ProductPriceFormType::class, [
                'label' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProductOption::class,
        ]);
    }
}
