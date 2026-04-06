<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    // defult form builder
    // public function buildForm(FormBuilderInterface $builder, array $options): void
    // {
    //     $builder
    //         ->add('field_name')
    //     ;
    // }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // add form fields here
        // $builder
        //     ->add("name")
        //     ->add("sku")
        //     ->add("price")
        //     ->add("entry_date")
        //     ->add("status");

        // customize form fields
        $builder
            ->add("name", TextType::class, [
                "label" => "Product Name",
                "attr" => [
                    'class' => 'bg-transparent border border-gray-300 rounded-md p-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent',
                    "placeholder" => "Enter product name",
                ],
            ])
            ->add("sku", TextType::class, [
                "label" => "SKU",
                "attr" => [
                    'class' => 'bg-transparent border border-gray-300 rounded-md p-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent',
                    "placeholder" => "Enter product SKU",
                ],
            ])
            ->add("price", NumberType::class, [
                "label" => "Price",
                "attr" => [
                    'class' => 'bg-transparent border border-gray-300 rounded-md p-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent',
                    "placeholder" => "Enter product price",
                ],
            ])
            ->add("entry_date", DateTimeType::class, [
                "label" => "Entry Date",
                "attr" => [
                    'class' => 'bg-transparent border border-gray-300 rounded-md p-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent',
                ],
            ])
            ->add("status", ChoiceType::class, [
                "label" => "Status",
                "choices" => [
                    "Active" => 1,
                    "Deactive" => 0,
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'data_class' => Product::class, // Uncomment this line if you want to bind the form to the Product entity
        ]);
    }
}
