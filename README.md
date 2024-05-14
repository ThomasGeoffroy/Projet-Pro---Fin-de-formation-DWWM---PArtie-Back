### Etape de connection API pour nos amis les fronteux

1. Clonage du repo
2. Passez sur la branche DEV
3. Terminal : commmande  => Composer install
4. Configuration de fichier .env ou .env.local avec vos identifiants BDD + renseigner le nom de la bdd
5. Terminal : commmande  => php bin/console doctrine:database:create
6. Terminal : commmande  => php bin/console doctrine:migration:migrate
7. Terminal : commmande  => php bin/console doctrine:fixture:load
8. Ouvrir un serveur sur le localhost : Terminal : commmande  => php -S 0.0.0.0:8000 -t public