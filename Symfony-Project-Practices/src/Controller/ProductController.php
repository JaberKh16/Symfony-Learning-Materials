<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository; // add the ProductRepository class here
use App\Traits\FlashMessageTrait;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
// use Symfony\Component\Validator\Validator\ValidatorInterface;


#[Route("/products")]
class ProductController extends AbstractController
{

    // use traits
    use FlashMessageTrait;

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
    #[Route("/{id}", methods: ['GET'], name: "product_show", requirements: ["id" => "\d+"])]
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
    #[Route("/create", methods: ['GET', 'POST'], name: "product_create")]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        

        // dd($request->request->all(), $form->isSubmitted(), $form->isValid(), $product);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($product); // persist the product entity to the database
            $entityManager->flush(); // flush the changes to the database

            // flash a success message to the session
            $this->addFlash("success", "Product created successfully!");

            return $this->redirectToRoute("product_list");
        }

        return $this->render("product/create.html.twig", [
            'form' => $form->createView(),
        ]);
    }


    // edit an existing product
    #[Route("/edit/{id}", methods: ['GET', 'POST'], name: "product_edit", requirements: ["id" => "\d+"])]
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
    #[Route("/delete/{id}", methods: ['GET', 'DELETE'], name: "product_delete", requirements: ["id" => "\d+"])]
    public function delete(
        Product $product,
        Request $request,
        EntityManagerInterface $em,
    ): Response {

        if($request->isMethod("DELETE")) {
            $em->remove($product);
            $em->flush();

            // flash a success message to the session
            $this->addFlash("success", "Product deleted successfully!");

            return $this->redirectToRoute("product_list");
        }

        // render a confirmation page before deleting the product
        return $this->render("product/index.html.twig", [
            "product" => $product,
        ]);
    }
}
