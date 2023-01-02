<?php

namespace App\Repository;

use App\Entity\AircraftPosition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AircraftPosition>
 *
 * @method AircraftPosition|null find($id, $lockMode = null, $lockVersion = null )
 * @method AircraftPosition|null findOneBy(array $criteria, array $orderBy = null )
 * @method AircraftPosition[]    findAll()
 * @method AircraftPosition[]    findBy( array $criteria, array $orderBy = null, $limit = null, $offset = null )
 */
class AircraftPositionRepository extends ServiceEntityRepository
{

    private $em;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $em)
    {
        parent::__construct($registry, AircraftPosition::class);
        $this->em = $em;
    }

    public function save(AircraftPosition $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove( AircraftPosition $entity, bool $flush = false ): void {
        $this->getEntityManager()->remove( $entity );

        if ( $flush ) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return AircraftPosition[] Returns an array of AircraftPosition objects
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

//    public function findOneBySomeField($value): ?AircraftPosition
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    /**
     * @throws \Exception
     */
    public function deleteOldPositions(int $days)
    {
        $query = $this->em->createQuery(
            'DELETE FROM App\Entity\AircraftPosition p WHERE p.position_at < :cutoff'
        );

        $cutoff = new \DateTime();
        $cutoff->sub(new \DateInterval(sprintf('P%dD', $days)));

        $query->setParameter('cutoff', $cutoff);

        return $query->execute();
    }

    public function getLastPosition(string $icao)
    {
        try {
            return $this->createQueryBuilder('p')
                ->andWhere('p.icao = :icao')
                ->setParameter('icao', $icao)
                ->orderBy('p.position_at', 'DESC')
                ->setMaxResults(1)
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            return null;
        }
    }
}
