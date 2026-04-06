<?php

namespace App\Traits;

use App\Entity\Product;
use App\Form\ProductType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

trait DataStoreTrait
{
    public function saveEntity($em, $entity)
    {
        $em->persist($entity);
        $em->flush();
    }


    // create a new product via manager registry, and handle form submission
    public function createWithManagerRegistry(Request $request, ManagerRegistry $managerRegistry): Response
    {
        $product = new Product();
        // $product->setCreatedAt(new \DateTimeImmutable());
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $submittedData = $form->getData();
            dump($submittedData);

            $entityManager = $managerRegistry->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute("product_list");
        }

        return $this->render("product/create.html.twig", [
            "form" => $form->createView(),
        ]);
    }

    // create a new product via entity manager, and handle form submission
    public function createWithEntityManager(Request $request, EntityManagerInterface $entityManager): Response
    {   
        $product = new Product();
        // $product->setCreatedAt(new \DateTimeImmutable());
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $submittedData = $form->getData();
            dump($submittedData);
            $entityManager->persist($product);
            $entityManager->flush();
            return $this->redirectToRoute("product_list");
        }
        return $this->render("product/create.html.twig", [
            "form" => $form->createView(),
        ]);
    }


}