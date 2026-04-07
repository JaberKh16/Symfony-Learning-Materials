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
        $commonInputClass = 'mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm shadow-sm 
        focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition';

        $builder
            ->add("name", TextType::class, [
                "label" => "Product Name",
                "label_attr" => [
                    "class" => "block text-sm font-medium text-gray-700"
                ],
                "attr" => [
                    'class' => $commonInputClass,
                    "placeholder" => "Enter product name",
                ],
            ])

            ->add("sku", TextType::class, [
                "label" => "SKU",
                "label_attr" => [
                    "class" => "block text-sm font-medium text-gray-700"
                ],
                "attr" => [
                    'class' => $commonInputClass,
                    "placeholder" => "Enter product SKU",
                ],
            ])

            ->add("price", NumberType::class, [
                "label" => "Price",
                "label_attr" => [
                    "class" => "block text-sm font-medium text-gray-700"
                ],
                "attr" => [
                    'class' => $commonInputClass,
                    "placeholder" => "Enter product price",
                ],
            ])

            ->add("entry_date", DateTimeType::class, [
                "label" => "Entry Date",
                "label_attr" => [
                    "class" => "block text-sm font-medium text-gray-700"
                ],
                "widget" => "single_text", 
                'required' => true,
                'input' => 'datetime',
                "attr" => [
                    'class' => $commonInputClass,
                ],
            ])

            ->add("status", ChoiceType::class, [
                "label" => "Status",
                "label_attr" => [
                    "class" => "block text-sm font-medium text-gray-700"
                ],
                "choices" => [
                    "Active" => 1,
                    "Inactive" => 0,
                ],
                "placeholder" => "Select status",
                "attr" => [
                    'class' => $commonInputClass,
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
