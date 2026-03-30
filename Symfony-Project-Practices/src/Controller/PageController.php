<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PageController
{
    #[Route("/page", name: "app_page")]
    public function index(): Response
    {
        return new Response("Welcome to the Page Controller!");
    }

    #[Route("/page/{slug}", name: "app_page_show")]
    public function show($slug): Response
    {
        return new Response("You are viewing the page: " . $slug);
    }
}
