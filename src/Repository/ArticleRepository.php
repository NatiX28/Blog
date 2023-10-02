<?php

namespace App\Repository;

use App\Entity\Article;
use App\Entity\Categorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Mapping\Id;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 *
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }


//    /**
//     * @return Article[] Returns an array of Article objects
//     */
   public function findByCategorie(Categorie $categorie): array
   {
       return $this->createQueryBuilder('a')
           ->andWhere('a.categorie = :val')
           ->setParameter('val', $categorie)
           ->orderBy('a.date', 'DESC')
           ->getQuery()
           ->getResult()
       ;
   }

   public function findRecent(): array
   {
    return $this->createQueryBuilder('a')
    ->orderBy('a.id', 'DESC')
    ->setMaxResults(3)
    ->getQuery()
    ->getResult()
;
   }

   public function findBySearch($search): array
    {
        return $this->createQueryBuilder('a')
          ->Where('a.titre LIKE :val ')
          ->orWhere('a.contenu LIKE :val ')
           ->setParameter('val', '%'.$search.'%')
            ->getQuery()
            ->getResult()
        ;
    }



//    public function findOneBySomeField($value): ?Article
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
