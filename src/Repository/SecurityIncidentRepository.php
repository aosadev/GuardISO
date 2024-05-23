<?php

namespace App\Repository;

use App\Entity\SecurityIncident;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SecurityIncident>
 *
 * @method SecurityIncident|null find($id, $lockMode = null, $lockVersion = null)
 * @method SecurityIncident|null findOneBy(array $criteria, array $orderBy = null)
 * @method SecurityIncident[]    findAll()
 * @method SecurityIncident[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SecurityIncidentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SecurityIncident::class);
    }

//    /**
//     * @return SecurityIncident[] Returns an array of SecurityIncident objects
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

//    public function findOneBySomeField($value): ?SecurityIncident
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
