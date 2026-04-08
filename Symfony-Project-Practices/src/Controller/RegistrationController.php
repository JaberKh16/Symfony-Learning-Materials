<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Constraints as Assert;


final class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        // setup a form with form builder
        $form = $this->createFormBuilder()
            ->add('username', null, [
                'label' => 'Username',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Username is required',
                    ]),
                ],
            ])
            ->add('email', null, [
                'label' => 'Email',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Email is required',
                    ]),
                    new Assert\Email([
                        'message' => 'Invalid email address.',
                    ]),
                ],
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeat Password'],
                'invalid_message' => 'Passwords do not match.',
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length([
                        'min' => 6,
                        'minMessage' => 'Password must be at least 6 characters',
                    ]),
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Register',
                'attr' => ['class' => 'btn btn-primary mt-3'],
            ])
            ->getForm();


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
            'controller_name' => 'RegistrationController',
            'form' => $form->createView(),
        ]);
    }
}
