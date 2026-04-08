<?php

namespace App\Controller;

// use App\Entity\User;
use App\Traits\BuildCustomFormBuilderTrait;
use App\Traits\BuildPlainRegisterFormTrait;
use App\Traits\FlashMessageTrait;
use App\Traits\HandleSubmissionRequestTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
// use Symfony\Component\Validator\Constraints as Assert;


final class RegistrationController extends AbstractController
{
    use BuildCustomFormBuilderTrait;
    use BuildPlainRegisterFormTrait;
    use FlashMessageTrait;
    use HandleSubmissionRequestTrait;


    #[Route('/register', name: 'app_register')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        // setup a form with form builder
        $form = $this->buildPlainRegisterForm(); // using plain form builder trait

        // using custom form builder trait with options
        // $form = $this->buildCustomRegisterForm(null, [
        //     'include_username' => true,
        //     'include_password' => true,
        //     'submit_label' => 'Sign Up',
        // ]);


        // handle form submission
        $result = $this->handleSubmissionRequest($request, $form, $entityManager, [
            'message' => 'Registration successful! You can now log in.',
        ]);
        if ($result && $result['status'] === 200) {
            $this->addFlash('success', $result['message']);
            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
