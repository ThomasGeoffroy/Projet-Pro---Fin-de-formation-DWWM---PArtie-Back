<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                "label" => "Nom du produit",
                "attr"  => [
                    "placeholder" => "Nom du produit"
                ]
            ])
            ->add('picture', UrlType::class,[
                "label" => "Image",
                "attr" => [
                    "placeholder" => "URL de l'image"
                ]
            ])
            ->add('status', ChoiceType::class,[
                "choices" =>  [
                    "actif" => true,
                    "inactif" => false
                ] 
            ])
            ->add('size', TextType::class,[
                "label" => "Taille du produit *",
                "attr"  => [
                    "placeholder" => "ex: 250ml, 100g, etc"
                ],
                "help" => "Ce champ peut être laissé vide."
            ])
            ->add('price', MoneyType::class,[
                "divisor" => 100,
                "label" => "Prix du produit",
                "attr" => [
                    "placeholder" => "Prix du produit"
                ]
            ])
            ->add('description', TextareaType::class,[
                "label" => "Description du produit",
                "attr" => [
                    "placeholder" => "Ajouter la description du produit"
                ],
            ])
            ->add('ingredients', TextareaType::class,[
                "label" => "Ingrédients *",
                "attr" => [
                    "placeholder" => "Ajouter la liste des ingrédients"
                ],
                "help" => "Ce champ peut être laissé vide."
            ])
            ->add('advice', TextareaType::class,[
                "label" => "Conseils *",
                "attr" => [
                    "placeholder" => "Ajouter un ou des conseils d'utilisation du produit"
                ],
                "help" => "Ce champ peut être laissé vide."
            ])
            ->add('type', EntityType::class,[
                "class" => Type::class,
                "label" => "Sous-catégorie",
                "constraints" => [new NotBlank()],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
