<?php

namespace App\Form\User;

use App\Entity\User\Profile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Ваше имя',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'attr' => [
                    'class' => 'form-control'
                ],
                'row_attr' => [
                    'class' => 'mb-3'
                ],
            ])
            ->add('secondname', TextType::class, [
                'label' => 'Ваша фамилия',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'attr' => [
                    'class' => 'form-control'
                ],
                'row_attr' => [
                    'class' => 'mb-3'
                ],
            ])
            ->add('birthday', DateType::class, [
                'label' => 'Дата рождения',
                'label_attr' => [
                    'class' => 'form-label',
                ],
                'html5' => false,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                ],
                'row_attr' => [
                    'class' => 'mb-3'
                ]
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Сохранить',
                'attr' => [
                    'class' => 'btn btn-primary'
                ],
                'row_attr' => [
                    'class' => 'w-100 text-center',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Profile::class,
            'attr' => [
                'class' => 'container-sm justify-content-center',
            ]
        ]);
    }
}
