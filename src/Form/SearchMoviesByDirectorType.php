<?php

namespace App\Form;

use App\Entity\Film;
use App\Entity\Realisateur;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class SearchMoviesByDirectorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('realisateur', EntityType::class, [
                'class' => Realisateur::class,
                // Tri par ordre alphabétique des réalisateurs avec au moins un film enregistré dans la base
                'query_builder' => function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('r')
                        ->leftJoin(
                            Film::class,
                            'f',
                            Join::WITH,
                            'f.realisateur = r.id'
                        )
                        ->andWhere('f.realisateur IS NOT NULL')
                        ->orderBy('r.nom', 'ASC')
                        ;
                },
                'choice_label' => 'nom',
                'placeholder' => 'Choisir un réalisateur',
                'label' => false,
                'required' => true,
            ])

            ->add('chercher', SubmitType::class, [
                'label' => 'Chercher les films de ce réalisateur'
            ])
        ;
    }
}