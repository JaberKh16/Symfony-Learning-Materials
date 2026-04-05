<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProductRepository; // add the ProductRepository class here
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Product;
use App\Form\ProductType;

final class ProductController extends AbstractController
{
    // #[Route("/product", name: "app_product")]
    // public function index(): Response
    // {
    //     // lead to an error because repository needs an argument thus can directly use as service container
    //     // $repository = new ProductRepository();

    //     return $this->render("product/index.html.twig", [
    //         "controller_name" => "ProductController",
    //     ]);
    // }

    // #[Route("/product", name: "app_product")]
    // public function index(ProductRepository $repository): Response
    // {
    //     // lead to an error because repository needs an argument thus can directly use as service container
    //     // $repository = new ProductRepository();

    //     // find all
    //     $products = $repository->findAll();
    //     dump($products);
    //     // dd($products);

    //     return $this->render("product/index.html.twig", [
    //         "products" => $products,
    //     ]);
    // }

    // list all products
    #[Route("/products", name: "product_list")]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Implementation for listing products
        $repository = $entityManager->getRepository(Product::class);
        $products = $repository->findAll();

        return $this->render("product/index.html.twig", [
            "products" => $products,
        ]);
    }

    // view a single product
    #[Route("/product/{id}", name: "product_show")]
    public function show($id): Response
    {
        $repository = $this->getDoctrine()->getRepository(Product::class);
        $product = $repository->find($id);

        if (!$product) {
            throw $this->createNotFoundException("Product not found");
        }

        return $this->render("product/show.html.twig", [
            "product" => $product,
        ]);
    }

    // create a new product
    #[Route("/product/new", name: "product_new")]
    public function create(Request $request): Response
    {
        $product = new Product();
        // $product->setCreatedAt(new \DateTimeImmutable());
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute("product_list");
        }

        return $this->render("product/new.html.twig", [
            "form" => $form->createView(),
        ]);
    }

    // edit an existing product
    #[Route("/products/{id}/edit", name: "product_edit")]
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
    #[Route("/products/{id}/delete", name: "product_delete")]
    public function delete(
        Product $product,
        EntityManagerInterface $em,
    ): Response {
        $em->remove($product);
        $em->flush();

        return $this->redirectToRoute("product_list");
    }
}
