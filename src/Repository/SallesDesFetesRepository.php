<?php

namespace App\Repository;

use App\Entity\SallesDesFetes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SallesDesFetes>
 *
 * @method SallesDesFetes|null find($id, $lockMode = null, $lockVersion = null)
 * @method SallesDesFetes|null findOneBy(array $criteria, array $orderBy = null)
 * @method SallesDesFetes[]    findAll()
 * @method SallesDesFetes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SallesDesFetesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SallesDesFetes::class);
    }

    public function add(SallesDesFetes $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(SallesDesFetes $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return SallesDesFetes[] Returns an array of SallesDesFetes objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SallesDesFetes
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
