<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('email',EmailType::class,[
            "label" => "Email",
            "attr" => [
                "placeholder" => "Email de l'utilisateur"
            ]
        ])
        ->add('status', ChoiceType::class,[
            "choices"=>[
                "actif" => true,
                "inactif" => false
            ]
        ])
        ->add('roles', ChoiceType::class,[
            "choices"=>[
                    "Manager" => "ROLE_MANAGER",
                    "Administrateur" => "ROLE_ADMIN"
            ],
            "required" => true
        ]);

        $builder->get('roles')
        ->addModelTransformer(new CallbackTransformer(
            function ($rolesArray) {
                // transform the array to a string
                return count($rolesArray)? $rolesArray[0]: null;
            },
            function ($rolesString) {
                // transform the string back to an array
                return [$rolesString];
            }
        ));

        // Using the form options to add a default parameter "edit" to false
        // Hides the password to the edit form of an User
        if(!$options["edit"]){
            $builder
            ->add('password', RepeatedType::class, [
                "type" => PasswordType::class,
                "invalid_message" => "Les deux mots de passes doivent être identiques",
                "first_options" => [
                    "label" => "Mot de passe",
                    "attr" => [
                        "placeholder" => "Mot de passe"
                    ],
                ],
                "second_options" => [
                    "label" => "Confimer le mot de passe",
                    "attr" => [
                        "placeholder" => "Confirmer le mot de passe"
                    ],
                    "constraints" => [
                        new NotBlank([
                            "message" => "Ce champ ne doit pas être vide.",
                        ]),
                    ],                        
                ],
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            "edit" => false
        ]);
    }
}