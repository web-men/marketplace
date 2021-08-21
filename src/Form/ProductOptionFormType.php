<?php

namespace App\Form;

use App\Entity\ProductOption;
use App\Form\Type\Dropzone\DropzoneType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductOptionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('add', ButtonType::class, [
                'attr' => [
                    'class' => 'option_add',
                ],
                'label_html' => true,
                'label' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="16"></line>
                                <line x1="8" y1="12" x2="16" y2="12"></line>
                            </svg>',
            ])
            ->add('img', DropzoneType::class, [
                'label' => 'img.add',
                'attr' => [
                    //Уникальный id нужен будет для загрузки изоброжений
                    'id' => 'imgProductOption',
                ],
                'maxFiles' => 1,
                'addRemoveLinks' => true,
            ])
            ->add('name', TextType::class, [
                'label' => 'product.name',
            ])
            ->add('count', IntegerType::class, [
                'label' => 'product.count',
            ])
            ->add('description', TextType::class, [
                'label' => 'product.description',
            ])
            ->add('productPrice', ProductPriceFormType::class, [
                'label' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProductOption::class,
        ]);
    }
}
