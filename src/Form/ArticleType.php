<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Length;

class ArticleType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('contenu', TextareaType::class, [
                'required'=> false, 
                'constraints' => [
                    New NotNull([
                        'message' => 'Vous devez ajouter du contenu dans votre article'
                    ]),
                    new Length([
                        'min'=>50,
                        'minMessage' => 'Votre article doit faire au moins {{ limit }} caractères'
                    ])
                ]
            ])
            ->add('categorie')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);

    }
}
