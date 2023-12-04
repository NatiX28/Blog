# Documentation installation VM

Commencer par installer un serveur linux
  
Faire un `apt update` ainsi qu’un `apt upgrade` pour être sûr d’avoir son système à jour

Commençons par installer apache :  `sudo apt install apache2`


## Installation php

Il faut installer php 8.2 or cette version est manquante dans les packages, il faut donc les mettre à jour grâce aux commandes suivantes :

    sudo apt install lsb-release apt-transport-https ca-certificates software-properties-common -y
    
    sudo wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
    
    sudo sh -c 'echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list'


Puis mettez à jour avec `apt update` et enfin installez php avec `apt install php8.2`

## Installation Symfony

**Composer**
Pour installer Symfony nous aurons d'abord besoins de composer :

    sudo apt-get install wget php-cli php-xml php-zip php-mbstring unzip -y
    
    sudo wget -O composer-setup.php https://getcomposer.org/installer

    sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer

Vérifier que vous avez réussi l'installation avec : `composer --version`

**Symfony**
Ensuite installez Symfony 6 :
`sudo curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | sudo -E bash` (vous aurez peut-être besoin d'installer curl : `sudo apt-get install curl`)
Puis :

    apt install symfony-cli
Enfin vérifier l'installation avec `symfony -V`

## Git

Nous allons ensuite avoir besoin d'installer git : 

    sudo  apt  install  git

Vous pouvez vérifier avec `git --version`

Ensuite cloner le projet : `sudo git clone https://github.com/NatiX28/Blog.git`



   


