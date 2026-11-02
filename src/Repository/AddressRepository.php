<?php

namespace App\Repository;

use App\Entity\Address;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Address>
 */
class AddressRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Address::class);
    }

    //    /**
    //     * @return Address[] Returns an array of Address objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Address
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    //

        public function findAll(): array
        {
	    return $this->createQueryBuilder('a')
                ->orderBy('a.id', 'ASC')
                ->setMaxResults(10)
                ->getQuery()
                ->getResult()
            ;
	    }

        public function findFirstThreeOnes(): array
        {
            return $this->createQueryBuilder('a')
                ->orderBy('a.id', 'ASC')
                ->setMaxResults(3)
                ->getQuery()
                ->getResult();
        }

        public function findOneById($value): ?Address
        {
            return $this->createQueryBuilder('a')
                ->andWhere('a.id = :val')
                ->setParameter('val', $value)
                ->getQuery()
                ->getOneOrNullResult()
            ;
        }

        public function findOneByZipCode($value): ?Address
        {
            return $this->createQueryBuilder('a')
                ->andWhere('a.zipcode = :val')
                ->setParameter('val', $value)
                ->getQuery()
                ->getOneOrNullResult()
            ;
        }

        public function findOneByCity($value): ?Address
        {
            return $this->createQueryBuilder('a')
                ->andWhere('a.city = :val')
                ->setParameter('val', $value)
                ->getQuery()
                ->getOneOrNullResult()
            ;
        }
}
