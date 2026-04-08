<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Scategorie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SupprimerScategorieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle', ['attr' => ['class' => 'form-control'], 'label_attr' => ['class' => 'fw-bold text-light']])
            ->add('numero', ['attr' => ['class' => 'form-control'], 'label_attr' => ['class' => 'fw-bold text-light']])
            ->add('categorie', EntityType::class, ['attr' => ['class' => 'btn bg-primary text-white m-4'], 'row_attr' => ['class' => 'text-center text-light'],
                'class' => Categorie::class,
                'choice_label' => 'id',
            ])
            ->add('supprimer', SubmitType::class, ['attr' => ['class' => 'btn bg-primary text-white m-4'], 'row_attr' => ['class' => 'text-center text-light']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'scategories' => [],
        ]);
    }
}
