<?php

namespace App\Repository;

use App\Entity\Course;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends ServiceEntityRepository<Course>
 */
class CourseRepository extends ServiceEntityRepository
{
    private EntityManagerInterface $entityManager;
    
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Course::class);
        $this->entityManager = $this->getEntityManager();
    }

    //    /**
    //     * @return Course[] Returns an array of Course objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Course
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //     }
    //
    public function findAll(): array
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

        public function findOneById($value): ?Course
        {
            return $this->createQueryBuilder('c')
                ->andWhere('c.id = :val')
                ->setParameter('val', $value)
                ->getQuery()
               ->getOneOrNullResult()
            ;
        }

        public function findOneByTitle($value): ?Course
        {
            return $this->createQueryBuilder('c')
                ->andWhere('c.title = :val')
                ->setParameter('val', $value)
                ->getQuery()
               ->getOneOrNullResult()
            ;
        }

        public function findOneByCodeNAF($value): ?Course
        {
            return $this->createQueryBuilder('c')
                ->andWhere('c.codeNAF = :val')
                ->setParameter('val', $value)
                ->getQuery()
               ->getOneOrNullResult()
            ;
	}

	public function findItemsLetterNAF($prefix): array
	{
	   $items = [];   
	   $allCourses = $this->createQueryBuilder('c')
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
	   foreach ($allCourses as $course) {
		   //if (preg_match('/^'.$value.'([0-9])([0-9])([0-9])$/', $course->getCodeNAF(), $matches)) {
//	      if (preg_match('/^(NSY)([0-9])([0-9])([0-9])$/', $course->getCodeNAF(), $matches)) {  // fred: begin coded hard
	      if (preg_match('/^('.$prefix.')([0-9])([0-9])([0-9])$/', $course->getCodeNAF(), $matches)) {  // fred: begin coded hard

	         array_push($items, $course);
	      } 
	   }
	   return $items;
	}

    public function findAllItemsByCodeRNCP(string $codeRNCP): array
    {
        $entityManager = $this->entityManager;
        $query = $entityManager->createQuery('SELECT c,b
            FROM App\Entity\Course c,
            \App\Entity\CourseBlock b
            LEFT JOIN c.codeNAF = b.codeNAF
            WHERE b.codeRNCP = :codeRNCP')
            ->setParameter('codeRNCP', $codeRNCP);
            
        return $query->getResult();
    }

}
