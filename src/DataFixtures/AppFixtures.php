<?php


namespace App\DataFixtures;


use App\Entity\Article;
use App\Entity\Utilisateur;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;



class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i=0; $i<5; $i++)
        {
            $utilisateur = new Utilisateur();
            $utilisateur->setPseudo($faker->name());
            $utilisateur->setMdp($faker->password());
            $utilisateur->setMail($faker->email());
            
            $manager->persist($utilisateur);


            $article = new Article();
            $article->setTitre($faker->title());
            $article->setContenu($faker->text());
            $article->setDate($faker->dateTime());
            $article->setUtilisateur($utilisateur);


            $manager->persist($article);

            $manager->flush();
        }
    }
}
