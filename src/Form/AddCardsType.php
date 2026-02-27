<?php

namespace App\Form;

use App\Entity\Cartes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class AddCardsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
    
            ->add('prix',NumberType::class,[
                'attr'=>['style'=>'width:4em']
                
            ])
            ->add('etat',ChoiceType::class,[
                'choices'=>[
                    'Mint'=> 'M',
                    'Near_Mint'=>'NM',
                    'Excellent'=>'EXC',
                    'Good'=>'GOOD',
                    'Light_Played'=>'LP',
                    'Played'=>'P',
                    'Poor'=>'POOR'
                ],
                

            ])
            ->add('quantite',ChoiceType::class,[
                'choices'=>[
                    '1'=>'1',
                    '2'=>'2',
                    '3'=>'3',
                    '4'=>'4'
                ]
            ])

            ->add('cardId',HiddenType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cartes::class,
        ]);
    }
}
