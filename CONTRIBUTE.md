#Contribuer au projet ToDoList

Pour contribuer au projet, il est demandé de respecter les normes de qualités telles que les PSR-4 (PHP Standards Recommendations).
Le projet est hébergé sur Github à l’adresse suivante : https://github.com/gnut06300/P7_ToDo_Co .

Il est donc nécessaire de savoir comment utiliser Git pour contribuer au projet.
Pour en apprendre plus sur Git, vous pouvez vous référer à la documentation officielle :
https://docs.github.com/en/get-started

Le workflow (cheminement à suivre) pour contribuer au projet est le suivant.

###1) Consulter les issues déjà existantes

   Si vous avez constaté un problème sur l’application ou si vous avez une idée de nouvelle fonctionnalité pour l’améliorer,vérifiez que celui-ci n’a pas déjà été relevé et/ou résolu.

###2) Créer une issue

   Si le problème n’a pas été relevé ou si votre idée d’amélioration n’est pas présente, créez un nouvelle issue en précisant de manière claire et concise le but de cette issue (bug, nouvelle fonctionnalité etc.).

###3) Cloner le projet

   Il vous faudra ensuite cloner le projet en local grâce à la commande suivante :
   git clone https://github.com/gnut06300/P7_ToDo_Co.git
   Rendez-vous dans le dossier contenant le projet cloné avec un terminal et lancez un composer install afin d’installer les différentes librairies utilisées dans le projet.
   Configurez le fichier .env pour y paramétrer votre base de données.
   Puis exécutez les commandes suivante afin de créer la base de données :
- php bin/console doctrine:database:create .
- php bin/console doctrine:migrations:migrate .


###4) Créer une branche

   Créez une nouvelle branche avec un nom explicite.
   Exemple : Fix-problème-remarqué en cas de bug à réparer;
   Feature-nom-nouvelle-fonction pour une amélioration du projet.
   Pour cela, assurez-vous d’être sur la branche main du projet, et utiliser la commande git checkout -b <Feature-branch-name> .

###5) Développer

   Développez ce que vous souhaitez mettre en place.
   Sachez que votre travail ne sera pas accepté s’il ne respecte pas les règles de bonne pratiques en vigueurs.
- Les différentes PSR (1, 2, 4, 12) : https://symfony.com/doc/current/contributing/code/standards.html
- Les conventions de code de Symfony : https://symfony.com/doc/current/contributing/code/conventions.html
- Les bonnes pratiques de symfony : https://symfony.com/doc/current/best_practices.html .
- La structure des fichiers mis en place et la logique de l’application.

###6) La mise en place de tests

   Une fois le développent terminé, vérifiez que votre travail n’ait pas cassé l’application.
   Pour cela, il faut utiliser PHPUnit avec la commande : php bin/phpunit .
   Si les résultats des tests relèvent des erreurs, corrigez les sans quoi votre contribution ne pourra être mise en place dans le projet.

###7) Soumettre la pull request

   Si vos tests ont été réalisé avec succès, vous pouvez pousser votre travail sur le repository.
   Faites ensuite une demande de pull request afin de fusionner (merge) votre branche sur main.
   Seul le responsable du projet peut valider le merge.