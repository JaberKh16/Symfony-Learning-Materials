<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProductRepository; // add the ProductRepository class here

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

    #[Route("/product", name: "app_product")]
    public function index(ProductRepository $repository): Response
    {
        // lead to an error because repository needs an argument thus can directly use as service container
        // $repository = new ProductRepository();

        // find all
        $products = $repository->findAll();
        dump($products);
        // dd($products);

        return $this->render("product/index.html.twig", [
            "products" => $products,
        ]);
    }
}
