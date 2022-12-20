<?php

namespace App\Form;

use App\Entity\CentresMariages;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;



class CentresMariagesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prix')
            ->add('photo', FileType::class, [
                'label' => 'choisir votre image ',
                'mapped' => false
            ])
            ->add('nom')
            ->add('pack')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CentresMariages::class,
        ]);
    }
}