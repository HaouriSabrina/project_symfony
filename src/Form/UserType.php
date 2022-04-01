<?php

namespace App\Form;

use App\Entity\User;
use App\Repository\PlayerRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\Length;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $options["data"]; // je récupère la variable User qui est liée au formulaire dans le contrôleur dans la méthode createForm()
        $builder
            ->add('pseudo', TextType::class, [
                "constraints" =>[
                    new NotNull(['message' =>'Veuillez saisir un pseudo pour vous connecter']),
                    new Length([
                    "min"           => 4,
                    "minMessage"    => "Le pseudo doit comporter au moins 4 caractères"
                ])
                ]
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Administrateur'    => 'ROLE_ADMIN',
                    'Joueurs'           => 'ROLE_PLAYER',
                    'Arbitre'           => 'ROLE_REFEREE',
                    'Utilisateur'       => 'ROLE_USER'

                ],
                'multiple' => true,
                'expanded' => true
            ])
            ->add('email', EmailType::class,[
                'mapped'        => false,
                'label'         => 'E-mail',
                'constraints'   => [
                    new NotNull(['message' =>"L'email ne peut pas être vide"])
                ]
                
            ])
            ->add('password', TextType::class, [
                'mapped' => false,
                'required' => $user->getId() ? false : true // Si l'id n'est pas null, le champ password n'est pas requis (edit) sinon il l'est (new).
                                                            // Autre façon de le noter : 'required' => !user->getId()
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
