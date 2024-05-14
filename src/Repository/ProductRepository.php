<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Mapping\Id;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function add(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findRandom(){

        $conn = $this->getEntityManager()->getConnection();
        $sql = "
            SELECT * FROM product
            ORDER BY RAND()
            LIMIT 4
        ";
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();

         return $resultSet->fetchAllAssociative();
    }

    /**
     * 
     * @return Product[] Returns an array of product objects ordered by name
     */
    public function findAllOrderByNameSearch($needle = null){

        return $this->createQueryBuilder('p')
            ->orderBy("p.name")
            ->where("p.name LIKE :needle")
            ->setParameter("needle","%$needle%")
            ->getQuery()
            ->getResult();
    }

    public function productsMainBackOffice(){

        $conn = $this->getEntityManager()->getConnection();
        $sql = "
            SELECT * FROM product
            LIMIT 5
        ";
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();

         return $resultSet->fetchAllAssociative();
    }

   /**
    * @return Product[] Returns an array of product objects from a given category
    */
    public function getAllProductsByCategory(Category $category): array
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.type','t')
            ->innerJoin('t.category', 'c')
            ->where("c.id = :id")
            ->setParameter("id", $category->getId())
            ->getQuery()
            ->getResult()
        ;
    }
}
