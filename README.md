# TodoList

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/cdc06d795e8d4a0caf14de53dc301bc1)](https://app.codacy.com/gh/nixehooked/TodoList?utm_source=github.com&utm_medium=referral&utm_content=nixehooked/TodoList&utm_campaign=Badge_Grade)

# Installation

1. Copier le projet :

<code>https://github.com/nixehooked/TodoList.git</code>

2. Configurer la base de données dans le dossier .env

3.Installer les dépendances :

<code>composer install</code>

4.Créer la base de données :

<code>bin/console doctrine:database:create</code>

5.Migration des tables de la base de données :

<code>bin/console doctrine:schema:create</code>

6.Mise en route du server :

<code>symfony server:start</code>

7.Exécution des tests :

<code>php bin/phpunit</br>ou</br>php bin/phpunit --coverage-html docs/test-coverage</code>
