<?php

namespace App\Form\Messages;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SendingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('message', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Сообщение...',
                ],
                'row_attr' => [
                    'class' => 'w-75 me-2'
                ],
            ])
            ->add('vis', HiddenType::class)
            ->add('send', SubmitType::class, [
                'label' => 'Отправить',
                'attr' => [
                    'class' => 'btn btn-outline-dark w-100'
                ],
                'row_attr' => [
                    'class' => 'w-25'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'method' => 'POST',
            'attr' => [
                'class' => 'd-flex flex-row'
            ],
            // Configure your form options here
        ]);
    }
}
