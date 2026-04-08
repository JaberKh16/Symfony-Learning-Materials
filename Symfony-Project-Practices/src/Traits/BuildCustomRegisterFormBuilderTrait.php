<?php

namespace App\Traits;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

trait BuildCustomRegisterFormTrait
{
    protected function buildCustomRegisterForm(
        $data = null,
        array $options = []
    ) {
        // Custom options with defaults
        $includeUsername = $options['include_username'] ?? true;
        $includePassword = $options['include_password'] ?? true;
        $submitLabel     = $options['submit_label'] ?? 'Register';

        // Symfony form options (safe to pass)
        $formOptions = $options['form_options'] ?? [];

        $builder = $this->createFormBuilder($data, $formOptions);

        // Username field (optional)
        if ($includeUsername) {
            $builder->add('username', null, [
                'label' => 'Username',
                'attr' => ['placeholder' => 'Enter your username'],
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Username is required',
                    ]),
                ],
            ]);
        }

        // Email field
        $builder->add('email', null, [
            'label' => 'Email',
            'attr' => ['placeholder' => 'Enter your email address'],
            'constraints' => [
                new Assert\NotBlank([
                    'message' => 'Email is required',
                ]),
                new Assert\Email([
                    'message' => 'Invalid email address.',
                ]),
                new Assert\Length([
                    'max' => 255,
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
        ]);

        // Password field (optional)
        if ($includePassword) {
            $builder->add('password', RepeatedType::class, [
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
                    new Assert\Regex([
                        'pattern' => '/^(?=.*[A-Z])(?=.*\d).+$/',
                        'message' => 'Password must contain at least one uppercase letter and one number.',
                    ]),
                ],
            ]);
        }

        // Submit button
        $builder->add('submit', SubmitType::class, [
            'label' => $submitLabel,
            'attr' => [
                'class' => 'mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded'
            ],
        ]);

        return $builder->getForm();
    }
}