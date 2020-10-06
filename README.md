Apprendre Symfony 5
===================

Ce projet de site web didactique sert à la fois à démontrer les capacités de son auteur sur Symfony 5, de pense-bête, et de ressource pour tout développeur souhaitant apprendre les fondamentaux de ce framework.

Concept
-------

Chaque page traite d'un sujet précis qui fait l'objet d'un exemple d'application sur la page courante. Il est donc possible d'apprendre sur un sujet en lisant une page est analysant le code du projet lié à celle-ci.

Installation & Lancement
------------------------

Pour installer et lançer le projet il convient de s'assurer que les éléments suivants sont installés sur votre machine :

* Un IDE ([PHP Storm](https://www.jetbrains.com/fr-fr/phpstorm/download) ou [Visual Studio Code](https://code.visualstudio.com/download))
* [PHP & MariaDB](https://www.apachefriends.org/download.html)
* [Symfony CLI](https://symfony.com/download)
* [Composer](https://getcomposer.org/download/)
* [Node.js](https://nodejs.org/en/download/)
* [Yarn](https://classic.yarnpkg.com/en/docs/install/#windows-stable)

Une fois que tout est installé, ouvrir la ligne de commande de votre IDE ou celle que vous préferez est exécuter la commande :
`symfony check:requirements`

Si aucun message d'erreur ne s'affiche, se mettre à la racine du projet au niveau de la ligne de commande : (exemple) *D:\apprendre-symfony-5-master*

Lancer la commande `composer update` pour mettre à jour les dépendances.

Lancer le serveur PHP avec la commande `symfony serve -d`

Lancer le task runner avec la commande `yarn watch`

Créer la base de données avec la commande `symfony console doctrine:database:create`

Créer les différentes tables avec la commande `symfony console doctrine:migrations:make`

Remplir la base de données en copiant le code ci-dessous dans l'onglet SQL de PhpMyAdmin en s'assurant d'avoir sélectionné au préalable la base *learning_symfony* dans la colonne de gauche :


    --
    -- Déchargement des données de la table `acteur`
    --

    INSERT INTO `acteur` (`id`, `nom`) VALUES
    (1, 'Bruce Willis'),
    (2, 'Dolf Lundgren'),
    (3, 'Sylvester Stallone'),
    (4, 'Michael J. Fox'),
    (5, 'Christopher Lloyd'),
    (6, 'Uma Thurman'),
    (7, 'John Travolta'),
    (8, 'Elijah Wood'),
    (9, 'Ian McKellen'),
    (10, 'Arnold Schwarzenegger');

    --
    -- Déchargement des données de la table `film`
    --

    INSERT INTO `film` (`id`, `realisateur_id`, `titre`) VALUES
    (1, 2, 'Expendables 2'),
    (2, 1, 'Les Maîtres de l\'Univers'),
    (3, 1, 'Piège de Cristal'),
    (4, 3, 'Rambo'),
    (5, 3, 'Rocky IV');

    --
    -- Déchargement des données de la table `film_acteur`
    --

    INSERT INTO `film_acteur` (`film_id`, `acteur_id`) VALUES
    (1, 1),
    (1, 2),
    (1, 3),
    (2, 2),
    (3, 1),
    (4, 3),
    (5, 2),
    (5, 3);

    --
    -- Déchargement des données de la table `hashtag`
    --

    INSERT INTO `hashtag` (`id`, `film_id`, `terme`) VALUES
    (1, 1, '#Action'),
    (2, 1, '#GrosCasting'),
    (3, 2, '#Années80'),
    (4, 2, '#LiveAction'),
    (5, 5, '#Boxe'),
    (6, 5, '#GuerreFroide');

    --
    -- Déchargement des données de la table `realisateur`
    --

    INSERT INTO `realisateur` (`id`, `nom`) VALUES
    (1, 'John McTiernan'),
    (2, 'Simon West'),
    (3, 'Ted Kotcheff'),
    (4, 'Peter Jackson'),
    (5, 'Steven Spielberg'),
    (6, 'George Lucas'),
    (7, 'Robert Zemeckis'),
    (8, 'Quentin Tarantino'),
    (9, 'James Cameron');
    






