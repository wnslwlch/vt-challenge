<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'required' => true,
                'label' => 'Votre adresse e-mail*'
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'label' => 'Votre mot de passe',
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir un mot de passe.',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit faire au moins {{ limit }} caractères.',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ])
                ]
            ])
            ->add('status', ChoiceType::class, [
                'choices' => $this->getChoices(),
                'label' => 'Votre statut'
            ])
            ->add('organization', TextType::class, [
                'label' => 'Nom de votre organisation (si applicable)',
                'required' => false
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Votre prénom',
                'required' => false
            ])
            ->add('name', TextType::class, [
                'label' => 'Votre nom',
                'required' => false
            ])
            ->add('gender', ChoiceType::class, [
                'label' => 'Vous êtes :',
                'required' => false,
                'choices' => [
                    'Un homme' => 0,
                    'Une femme' => 1
                ]
            ])
            ->add('phone', TextType::class, [
                'label' => 'À quel numéro pouvons-nous vous joindre ?',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

    public function getChoices() {
        $choices = User::STATUS;

        $output = [];

        foreach($choices as $k => $v) {
            $output[$v] = $k;
        }

        return $output;
    }
}
