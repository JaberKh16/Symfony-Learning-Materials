<?php

namespace App\DataFixtures;

use App\Entity\Order;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class OrderFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // for ($i = 1; $i <= 10; $i++) {

        //     $order = new Order();

        //     // Example fields (adjust based on your Order entity)
        //     $order->setOrderNumber("ORD-00$i");
        //     $order->setQuantity(rand(1, 5));
        //     $order->setCreatedAt(new \DateTime());

        //     // Get product reference
        //     $product = $this->getReference(ProductFixture::PRODUCT_REFERENCE . $i);
        //     $order->setProduct($product);

        //     $manager->persist($order);
        // }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ProductFixture::class,
        ];
    }
}