<?php

namespace App\Repository;

use App\Entity\Student;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr\Join as Join;

/**
 * @extends ServiceEntityRepository<Student>
 */
class StudentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Student::class);
    }

//    /**
//     * @return Student[] Returns an array of Student objects
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
    public function findAll(): array
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

//    public function findOneBySomeField($value): ?Student
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function findOneById($value): ?Student
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findByStatusName($statusName): ?array
    {
	return $this->createQueryBuilder('s')
	     ->leftJoin('student.status', 'status.id')
	     ->andWhere('status.name LIKE :searchStatus')
	     ->setParameter('searchStatus', '%'.$statusName.'%')
	     ->addOrderBy('student.lastname', 'ASC')
             ->getQuery()
             ->getResult();
    }

    public function findByStatusId($statusid): ?array
    {
	    return $this->createQueryBuilder('student')
	      ->leftJoin('student.status', 'status', Join::WITH, 'status.id=:searchStatus')
	     //->leftJoin('student.status', 'status.id')
	     //->andWhere('status.id LIKE :searchStatus')
	     ->setParameter('searchStatus', '%'.$statusid.'%')
	     ->addOrderBy('student.lastname', 'ASC')
             ->getQuery()
             ->getResult();
    }
}
