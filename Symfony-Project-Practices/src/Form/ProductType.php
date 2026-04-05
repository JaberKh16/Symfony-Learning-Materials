<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    // public function buildForm(FormBuilderInterface $builder, array $options): void
    // {
    //     $builder
    //         ->add('field_name')
    //     ;
    // }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("name")
            ->add("sku")
            ->add("price")
            ->add("entry_date")
            ->add("status");
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            // 'data_class' => Product::class, // Uncomment this line if you want to bind the form to the Product entity
        ]);
    }
}
