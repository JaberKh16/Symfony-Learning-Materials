<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/user', name: 'app_user')]
final class UserController extends AbstractController
{
    #[Route('/index', name: 'app_user')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        //fetch user
        $user = $entityManager->getRepository(User::class)->findBy([], ['id' => 'DESC'], 1);

        if(is_array($user) && count($user) > 0) {
            $user = $user[0];
        } else {
            $user = null;
        }

        return $this->render('user/index.html.twig', [
            'user' => $user,
        ]);
    }

    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $user->setUsername('John Doe');
        $user->setEmail('john.doe@example.com');
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('app_user');
    }

    public function update(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $entityManager->getRepository(User::class)->findBy([], ['id' => 'DESC'], 1);

        if(is_array($user) && count($user) > 0) {
            $user = $user[0];
            $user->setUsername('Jane Doe');
            $user->setEmail('');
            $entityManager->persist($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user');
    }


    public function delete(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $entityManager->getRepository(User::class)->findBy([], ['id' => 'DESC'], 1);

        if(is_array($user) && count($user) > 0) {
            $user = $user[0];
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user');
    }
}
