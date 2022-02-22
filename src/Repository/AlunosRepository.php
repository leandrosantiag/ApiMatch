<?php

namespace App\Repository;

use App\Entity\Alunos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Alunos|null find($id, $lockMode = null, $lockVersion = null)
 * @method Alunos|null findOneBy(array $criteria, array $orderBy = null)
 * @method Alunos[]    findAll()
 * @method Alunos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlunosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Alunos::class);
    }

    // /**
    //  * @return Alunos[] Returns an array of Alunos objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Alunos
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
