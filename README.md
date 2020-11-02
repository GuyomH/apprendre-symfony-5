Apprendre Symfony 5
===================

Ce projet de site web didactique sert à la fois à démontrer les capacités de son auteur sur Symfony 5, de pense-bête, et de ressource pour tout développeur souhaitant apprendre les fondamentaux de ce framework.

Concept
-------

Chaque page traite d'un sujet précis qui fait l'objet d'un exemple d'application sur la page courante. Il est donc possible d'apprendre sur un sujet en lisant une page et en analysant le code du projet lié à celle-ci.

Installation & Lancement
------------------------

Pour installer et lançer le projet il convient de s'assurer que les éléments suivants sont installés sur votre machine :

* Un IDE ([PHP Storm](https://www.jetbrains.com/fr-fr/phpstorm/download) ou [Visual Studio Code](https://code.visualstudio.com/download) ou celui que vous aimez)
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

Remplir la base de données avec les fixtures `symfony console doctrine:fixtures:load`






