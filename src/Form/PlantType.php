<?php

namespace App\Form;

use App\Entity\Plant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PlantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('region', TextType::class,[
                'label' => 'Région',
            ])
            ->add('prefecture', TextType::class,[
                'label' => 'Préfecture',
            ])
            ->add('locality', TextType::class,[
                'label' => 'Localité',
            ])
            ->add('image_1', FileType::class, [
                'mapped' => false,
                'label' => 'Ajoutez une photo',
                'required'   => true,
            ])

            // À rajouter lors de la seconde série
            // ->add('image_2', FileType::class, [
            //     'mapped' => false,
            //     'label' => 'Add a picture',
            //     'required'   => false,
            // ])
            ->add('nb_plants', IntegerType::class, [
                'label' => 'Combien de plants ont été plantés ?',
                'required' => true,
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Plant::class,
        ]);
    }
}
