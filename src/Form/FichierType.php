<?php

namespace App\Form;

use App\Entity\Fichier;
use App\Entity\User;
use App\Entity\Scategorie;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; 
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class FichierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomOriginal', TextType::class, ['attr' => ['class' => 'form-control'], 'label_attr' => ['class' =>'fw-bold text-light']])
            ->add('nomServeur', TextType::class, ['attr' => ['class' => 'form-control'], 'label_attr' => ['class' =>'fw-bold text-light']])
            ->add('dateEnvoie', DateType::class, ['attr' => ['class' => 'btn bg-primary text-white m-4'],'row_attr' => ['class' => 'text-center text-light']])
            ->add('extension', TextType::class, ['attr' => ['class' => 'form-control'], 'label_attr' => ['class' =>'fw-bold text-light']])
            ->add('taille', NumberType::class, ['attr'=> ['class'=> 'form-control'], 'label_attr' => ['class'=>'fw-bold text-light']])
            ->add('user', EntityType::class, [
                'attr'=>['class'=> 'form-select'], 'label_attr' => ['class'=>'fw-bold text-light'],
                'class' => User::class,
                'choice_label' => function($user){
                    return $user->getNom().' '.$user->getPrenom();
                },
                'query_builder'=>function(EntityRepository $er){
                    return $er->createQueryBuilder('u')
                    ->orderBy('u.nom','ASC')
                    ->addOrderBy('u.prenom','ASC');
                },
            ])
            ->add('scategories', EntityType::class, [
                'class' => Scategorie::class,
                'choices' => $options['scategories'],
                'choice_label' => 'libelle',
                'expanded' => true,
                'multiple' => true,
                'label' => false, 'mapped' => false])
            ->add('envoyer', SubmitType::class, ['attr' => ['class' => 'btn bg-primary text-white m-4'], 'row_attr' => ['class' => 'text-center text-light']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Fichier::class, 
            'scategories' => []
        ]);
    }
}
