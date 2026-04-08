<?php

namespace App\Traits;

use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints as Assert;

trait BuildPlainRegisterFormTrait
{
    protected function buildPlainRegisterForm()
    {
        return $this->createFormBuilder()
            ->add('username', null, [
                'label'       => 'Username',
                'attr'        => ['placeholder' => 'Enter your username'],
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Username is required',
                    ]),
                ],
            ])
            ->add('email', null, [
                'label'       => 'Email',
                'attr'        => ['placeholder' => 'Enter your email address'],
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Email is required',
                    ]),
                    new Assert\Email([
                        'message' => 'Invalid email address.',
                    ]),
                    new Assert\Length([
                        'max'        => 255,
                        'maxMessage' => 'Email cannot be longer than {{ limit }} characters',
                    ]),
                    new Assert\Unique([
                        'message' => 'This email is already in use.',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^[a-zA-Z0-9._%+-]+@example\.com$/',
                        'message' => 'Email must be from the example.com domain.',
                    ]),
                ],
            ])
            ->add('password', RepeatedType::class, [
                'type'            => PasswordType::class,
                'first_options'   => ['label' => 'Password'],
                'second_options'  => ['label' => 'Repeat Password'],
                'invalid_message' => 'Passwords do not match.',
                'attr'            => ['placeholder' => 'Enter your password'],
                'constraints'     => [
                    new Assert\NotBlank(),
                    'constraints' => [
                        new Assert\NotBlank(),
                        new Assert\Length([
                            'min'        => 6,
                            'minMessage' => 'Password must be at least 6 characters',
                        ]),
                        new Assert\Regex([
                            'pattern' => '/^(?=.*[A-Z])(?=.*\d).+$/',
                            'message' => 'Password must contain at least one uppercase letter and one number.',
                        ]),
                    ],
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Register',
                'attr'  => ['class' => 'mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded'],
            ])
            ->getForm();
    }
}
