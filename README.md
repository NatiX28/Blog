# Documentation installation VM

Commencer par installer un serveur linux (à savoir que cette doc a été faite par rapport à une VM debian 11 donc pas sûr que ça marche exactement pareil sur une autre version).
  
Faire un `apt update` ainsi qu’un `apt upgrade` pour être sûr d’avoir son système à jour.


## Php

Il faut installer php 8.2 or cette version est manquante dans les packages, il faut donc les mettre à jour grâce aux commandes suivantes :

    sudo apt install lsb-release apt-transport-https ca-certificates software-properties-common -y
    
    sudo wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
    
    sudo sh -c 'echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list'

Puis mettez à jour le système avec `apt update` et vous pouvez installer php avec `sudo apt install php8.2`

Nous aurons également besoin de certaines extensions php :

    sudo apt-get install php8.2-{dom,zip,mysql,xml,fpm,bz2,mbstring,intl}
   
Enfin activer le module fpm avec apache : `sudo a2enconf php8.2-fpm`

## Symfony

**Composer**
Pour installer Symfony nous aurons d'abord besoins de composer :

    sudo apt-get install wget php-cli php-xml php-zip php-mbstring unzip -y
    
    sudo wget -O composer-setup.php https://getcomposer.org/installer

    sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer

Vérifier que vous avez réussi l'installation avec : `composer --version`

**Symfony**
Ensuite installez Symfony 6 :
`sudo curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | sudo -E bash` (vous aurez peut-être besoin d'installer curl : `sudo apt-get install curl`)

Puis : `sudo apt install symfony-cli`

Enfin vérifier l'installation avec `symfony -V`

## Git

Nous allons ensuite avoir besoin d'installer git : 

    sudo apt install git

Vous pouvez vérifier avec `git --version`

## Apache

Commençons par installer apache :  `sudo apt install apache2`

Installez ensuite la librairie php pour apache : `sudo apt install libapache2-mod-php8.2`et activer la `sudo a2enmod php8.2`

Rendez vous dans le dossier /var/www (dossier auquel Apache va accéder) puis clonez le projet : `sudo git clone https://github.com/NatiX28/Blog.git`

Allez ensuite dans le dossier que vous venez d'exporter et faite la commande `sudo composer install` et `sudo composer require symfony/apache-pack`. Cela permet d'installer tous les composants nécessaires à Symfony.

Rendez-vous ensuite dans /etc/apache2/sites-available et modifier le fichier 000-default.conf et rajouter ceci :
```
DocumentRoot /var/www/project/public
    <Directory /var/www/project/public/>
        AllowOverride None
        Require all granted
        FallbackResource /index.php
    </Directory>
```
Faite ensuite un `sudo systemctl restart apache2`

## Base de donnée

Comme il est mieux de faire sa base de donnée dans une DMZ, il vaut mieux la faire sur un autre serveur Linux (mais bon je vais pas vous apprendre votre cours de cybersécurité).

Donc sur une 2nd serveur installez mariadb : `sudo apt install mariadb-server`

Allez dans mariadb avec la commande `mariadb` puis créez un utilisateur avec un mot de passe et donner lui tous les privilèges : 

    CREATE USER 'username'@'%' IDENTIFIED BY 'password';
    GRANT ALL PRIVILEGES ON *.* TO 'prenom'@'%' IDENTIFIED BY 'MOTDEPASSE';
    FLUSH PRIVILEGES;
 
Allez ensuite dans /etc/mysql/mariadb.conf.d puis `sudo nano 50-server` et changer la bind-address pour 0.0.0.0

Ensuite connecter vous à mariadb avec votre nouvelle utilisateur `mariadb -u [username] -p` puis créez une base de données avec `create database [database_name] ;`

  
Après il va falloir configurer symfony pour changer le chemin d’accès vers votre BDD. 
Allez dans /var/www/Blog puis modifier le fichier .env avec `sudo nano .env` puis changer la ligne « DATABASE_URL » ainsi :

    "mysql://[username]:[password]@[ip]:3306/[database_name]?serverVersion=10.11.2-MariaDB&charset=utf8mb4"

 Ensuite pour migrer la base donnée du code vers votre base de donnée nouvellement crée faite `php bin/console make:migration` puis `php bin/console doctrine:migrations:migrate`

Pour remplir la base de donnée, vous pouvez faire `php bin/console doctrine:fixtures:load`, cela va remplir la base de donnée d'éléments aléatoire mais vous pouvez aussi rajouter des éléments manuellement.

**Ensuite vous devriez pouvoir accéder au blog via votre IP dans votre dans un navigateur.**
