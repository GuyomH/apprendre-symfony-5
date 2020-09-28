<?php

namespace App\Form;

use App\Entity\Acteur;
use App\Entity\Film;
use App\Entity\Realisateur;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilmType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Titre du film',
                'required' => true,
            ])

            ->add('realisateur', EntityType::class, [
                'class' => Realisateur::class,
                // Tri par ordre alphabétique de la liste des réalisateurs
                'query_builder' => function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('r')
                        ->orderBy('r.nom', 'ASC');
                },
                'choice_label' => 'nom',
                'placeholder' => 'Choisir un réalisateur',
                'label' => 'Nom du réalisateur',
                'required' => true,
            ])

            // On imbrique le formulaire ActeurType
            ->add('acteurs', CollectionType::class, [
                'entry_type' => ActeurType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'by_reference' => false, // force l'appel de la méthode addActeur pour lier les acteurs au film
                'label' => 'LISTE DES ACTEURS :',
            ])

            ->add('soumettre', SubmitType::class, [
                'label' => 'Ajouter ce film',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Film::class,
        ]);
    }
}