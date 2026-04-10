<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixture extends Fixture
{
    public const PRODUCT_REFERENCE = 'product_';

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; $i++) {

            $product = new Product();
            $product->setName("Product $i");
            $product->setSku("SKU-00$i");
            $product->setPrice(rand(100, 1000));
            $product->setEntryDate(new \DateTime());
            $product->setStatus(1);

            $manager->persist($product);

            // Save reference for OrderFixture
            // $this->addReference(self::PRODUCT_REFERENCE . $i, $product);
        }

        $manager->flush();
    }
}