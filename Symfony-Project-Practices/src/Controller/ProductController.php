<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository; // add the ProductRepository class here
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Builder\Method;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


#[Route("/products")]
final class ProductController extends AbstractController
{
   

    // list all products
    #[Route("/index", methods: ['GET'], name: "product_list")]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Implementation for listing products
        $repository = $entityManager->getRepository(Product::class);
        $products = $repository->findAll();

        if(!$products) {
            throw $this->createNotFoundException("No products found");
        }


        return $this->render("product/index.html.twig", [
            "products" => $products,
        ]);
    }

    // view a single product
    #[Route("/{id}", methods: ['GET'], name: "product_show")]
    public function show($id, ManagerRegistry $managerRegistry): Response
    {
        $repository = $managerRegistry->getRepository(Product::class);
        $product = $repository->find($id);

        if (!$product) {
            throw $this->createNotFoundException("Product not found");
        }

        return $this->render("product/show.html.twig", [
            "product" => $product,
        ]);
    }



    // create a new product via entity manager, and handle form submission
    #[Route("/create", methods: ['GET'], name: "product_create")]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {        $product = new Product();
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

    // edit an existing product
    #[Route("/{id}/edit", methods: ['GET', 'POST'], name: "product_edit")]
    public function edit(
        Product $product,
        Request $request,
        EntityManagerInterface $em,
    ): Response {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute("product_list");
        }

        return $this->render("product/edit.html.twig", [
            "form" => $form->createView(),
        ]);
    }

    // delete a product
    #[Route("/{id}/delete", methods: ['GET', 'DELETE'], name: "product_delete")]
    public function delete(
        Product $product,
        EntityManagerInterface $em,
    ): Response {
        $em->remove($product);
        $em->flush();

        return $this->redirectToRoute("product_list");
    }
}
