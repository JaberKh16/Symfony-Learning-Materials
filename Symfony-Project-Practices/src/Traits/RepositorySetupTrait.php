<?php

namespace App\Traits;

trait RepositorySetupTrait
{
    protected function getRepository($entityClass)
    {
        return $this->getRegistry()->getRepository($entityClass);
    }


    // public function index(): Response
    // {
    //     // lead to an error because repository needs an argument thus can directly use as service container
    //     // $repository = new ProductRepository();

    //     return $this->render("product/index.html.twig", [
    //         "controller_name" => "ProductController",
    //     ]);
    // }


    // create via repoisitory setup 
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


}