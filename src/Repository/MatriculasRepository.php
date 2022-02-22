<?php

namespace App\Repository;

use App\Entity\Matriculas;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Matriculas|null find($id, $lockMode = null, $lockVersion = null)
 * @method Matriculas|null findOneBy(array $criteria, array $orderBy = null)
 * @method Matriculas[]    findAll()
 * @method Matriculas[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MatriculasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Matriculas::class);
    }

    // /**
    //  * @return Matriculas[] Returns an array of Matriculas objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Matriculas
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
