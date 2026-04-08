<?php

namespace App\Controller;

use App\Entity\User;
use App\Traits\BuildCustomRegisterFormTrait;
use App\Traits\BuildPlainRegisterFormTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
// use Symfony\Component\Validator\Constraints as Assert;


final class RegistrationController extends AbstractController
{
    use BuildPlainRegisterFormTrait, BuildCustomRegisterFormTrait {
        BuildCustomRegisterFormTrait::buildCustomRegisterForm insteadof BuildCustomRegisterFormTrait;
        BuildPlainRegisterFormTrait::buildPlainRegisterForm insteadof BuildPlainRegisterFormTrait;
    }


    #[Route('/register', name: 'app_register')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        // setup a form with form builder
        // $form = $this->buildPlainRegisterForm(); // using plain form builder trait

        // using custom form builder trait with options
        $form = $this->buildCustomRegisterForm(null, [
            'include_username' => true,
            'include_password' => true,
            'submit_label' => 'Sign Up',
        ]);


        // handle form submission
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // process form data
            $data = $form->getData();
            // create a new user entity and save to database
            $user = new User();
            $user->setUsername($data['username']);
            $user->setEmail($data['email']);
            // hash the password before saving
            $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);
            $user->setPassword($hashedPassword);
            $entityManager->persist($user);
            $entityManager->flush();

            // flash a success message to the session
            $this->addFlash('success', 'Registration successful! You can now log in.');
            // redirect to login page
            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
