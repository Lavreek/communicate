<?php

namespace App\Form\User;

use App\Entity\User\Account;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email адрес',
                'attr' => [
                    'id' => 'floatingInput',
                    'class' => 'form-control',
                    'style' => 'order: 1;',
                    'placeholder' => 'name@example.com',
                ],
                'row_attr' => [
                    'class' => 'form-floating'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Пожалуйста впишите email.',
                    ]),
                ]
            ])
            ->add('username', TextType::class, [
                'label' => 'Имя пользователя',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Имя пользователя',
                ],
                'row_attr' => [
                    'class' => 'form-floating py-2',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Пожалуйста впишите имя пользователя.',
                    ]),
                ]
            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Пароль',
                'mapped' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Имя пользователя',
                    'autocomplete' => 'new-password'
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Account::class,
        ]);
    }
}
