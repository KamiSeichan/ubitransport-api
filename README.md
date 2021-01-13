# ubitransport-api


Environnement

- php7.4
- Symfony: 5.2
- sqlite 3

Installation

- Assurez vous d'avoir installer le client symfony (https://symfony.com/download) ou d'avoir un server web (nginx, wamp, etc...)
- Lancez composer install --no-interaction
- Créez un fichier .env.local et ajoutez y DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db" ou la base de votre choix
- Lancez composer load-fixture pour créer la base et insérer des données
- La commande run-test permet de lancer les tests

Route et documentation

- Une documentation est disponible sur /api/doc
- Les routes peuvent être testées avec postman. 
