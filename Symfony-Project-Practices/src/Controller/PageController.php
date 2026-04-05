<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PageController extends AbstractController
{
    #[Route("/home", name: "app_home")]
    public function index(): Response
    {
        $randomText = "Welcome to the Symfony World";
        return $this->render("page/index.html.twig", [
            "controller_name" => "HomeController",
            "title" => $randomText,
        ]);
    }

    #[Route("/about", name: "app_about")]
    public function about(): Response
    {
        $title = "About Us";
        return $this->render("page/about.html.twig", [
            "title" => $title,
        ]);
    }

    #[Route("/contact", name: "app_contact")]
    public function contact(): Response
    {
        $title = "Contact Us";
        return $this->render("page/contact.html.twig", [
            "title" => $title,
        ]);
    }
    # define named routes
    #[Route("/items", name: "page_items")]
    public function list(): Response
    {
        $title = "List of Items";
        $items = ["Item 1", "Item 2", "Item 3"];
        return $this->render("page/list.html.twig", [
            "title" => $title,
            "items" => $items,
        ]);
    }

    #[Route("/page/{slug}", name: "app_page_show")]
    public function show($slug): Response
    {
        return new Response("You are viewing the page: " . $slug);
    }
}
