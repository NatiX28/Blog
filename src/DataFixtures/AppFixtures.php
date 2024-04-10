<?php


namespace App\DataFixtures;


use App\Entity\Article;
use App\Entity\Utilisateur;
use App\Entity\Categorie;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;



class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $categ = ["Animation", "Science-fiction","Action"];
        $titre = ["Shrek","Star Wars","Avengers"];

        for ($i=0; $i<3; $i++)
        {
            $utilisateur = new Utilisateur();
            $utilisateur->setPseudo($faker->name());
            $utilisateur->setMdp($faker->password());
            $utilisateur->setMail($faker->email());

            $manager->persist($utilisateur);
            

            $categorie = new Categorie();
            $categorie->setLibelle($categ[$i]);
            $categorie->setSlug($categ[$i]);

            $manager->persist($categorie);


            $article = new Article();
            $article->setTitre($titre[$i]);
            $article->setContenu($faker->text());
            $article->setDate($faker->dateTime());
            $article->setCategorie($categorie);
            $article->setDescription($faker->text());
            $article->setSlug($titre[$i]);
            $article->setUtilisateur($utilisateur);

            
            $manager->persist($article);

            $manager->flush();
        }
    }
}
