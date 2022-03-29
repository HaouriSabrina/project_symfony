<?php

namespace App\Form;

use App\Entity\Game;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class GameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label'         => "Nom",
                'constraints'   => [
                    new Length([
                        'max' => 30,
                        'maxMessage'=>"Le nom du jeu ne peut pas dépasser 30 caractères",
                        'min' => 2,
                        'minMessage' => "Le nom du jeu doit avoir au moins 2 caractères"
                    ]),
                    new NotBlank(['message' => 'Ce champ ne peut pas être vide'])
                ],
            ])
            ->add('min_players')
            ->add('max_players')
            ->add('enregistrer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);
    }
}


