<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Factory\ActeurFactory;
use App\Factory\FilmFactory;
use App\Factory\HashtagFactory;
use App\Factory\RealisateurFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Création de l'utilisateur Admin
        $user = new User();
        $user->setEmail('admin@email.fr');
        $user->setRoles(['role' => 'ROLE_ADMIN']);
        $user->setPassword('$argon2i$v=19$m=65536,t=4,p=1$d3BkUWxDaUt4Znd5RXQ2RQ$nTJvJOA41LHQfLKlh8KgCpqChwiPm3ABeLSl8cODqUM');
        $user->setEnable(true);
        $manager->persist($user);

        // On crée 40 acteurs pour en associer entre 1 et 5 au hasard pour chaque film
        ActeurFactory::new()->many(40)->create();

        // On crée 20 réalisateurs pour en associer 1 au hasard pour chaque film
        RealisateurFactory::new()->many(20)->create();

        // On crée 50 films films aux caractéristiques différentes
        FilmFactory::new()->createMany(50, function() {
            return [
                // On crée entre 0 et 3 hashtag pour chaque film
                'hashtags' => HashtagFactory::new()->many( rand(0,3) ), // OneToMany
                // On associe 1 réalisateur au hasard parmi les 20 créés
                'realisateur' => RealisateurFactory::random(), // ManyToOne
                // On associe entre 1 et 5 acteurs au hasard parmi les 40 créés
                'acteurs' => ActeurFactory::randomRange(1, 5), // ManyToMany
            ];
        });

        $manager->flush();
    }
}
