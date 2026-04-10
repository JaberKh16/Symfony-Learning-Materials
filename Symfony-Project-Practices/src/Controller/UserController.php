<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

#[Route('/user', name: 'app_user')]
final class UserController extends AbstractController
{
    #[Route('/index', name: '_index', methods: ['GET'])]
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


    #[Route('/create', name: '_create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $user->setUsername('John Doe');
        $user->setEmail('john.doe@example.com');
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('app_user');
    }


    #[Route('/update', name: '_update', methods: ['GET', 'POST'])]
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


    #[Route('/delete', name: '_delete', methods: ['POST'])]
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

    #[Route('/profile', name: '_profile', methods: ['GET'])]
    public function browseProfile(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $entityManager->getRepository(User::class)->findBy([], ['id' => 'DESC'], 1);

        if(is_array($user) && count($user) > 0) {
            $user = $user[0];
        } else {
            $user = null;
        }

        return $this->render('user/profile.html.twig', [
            'user' => $user,
        ]);
    }


    #[Route('/profile_edit', name: '_profile_edit', methods: ['GET', 'POST'])]
    public function profileEdit(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $entityManager->getRepository(User::class)->findBy([], ['id' => 'DESC'], 1);
        $form = $this->createFormBuilder()
            ->add('username')
            ->add('email')
            ->add('save', SubmitType::class, ['label' => 'Update Profile'])
            ->getForm();

        // handle the requets 
        $form->handleRequest($request);

        if(is_array($user) && count($user) > 0) {
            $user = new User();
            $user = $request->request->get('form');
            $entityManager->persist($user);
            $entityManager->flush();
        }

        return $this->render('user/profile_edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
