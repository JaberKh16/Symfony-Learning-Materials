<?php 

namespace App\Traits;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;


trait HandleSubmissionRequestTrait
{
    protected function handleSubmissionRequest(Request $request, FormInterface $form, EntityManagerInterface $entityManager, array $options = [])
    {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // get the form data
            $data = $form->getData();
            
            // process the data (e.g. save to database)
            $user = new User();
            $user->setUsername($data['username']);
            $user->setEmail($data['email']);
            $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);
            $user->setPassword($hashedPassword);
            $entityManager->persist($user);
            $entityManager->flush();

            return [
                'success' => true,
                'message' => $options['message'] ?? 'Form submitted successfully!',
                'data' => [
                    'data' => $data,
                    'user' => $user,
                ],
                'status' => $options['status'] ?? 200,
            ];

        }
        return null;
    }
}