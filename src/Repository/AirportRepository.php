<?php

namespace App\Repository;

use App\Entity\Airport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Airport>
 *
 * @method Airport|null find($id, $lockMode = null, $lockVersion = null)
 * @method Airport|null findOneBy(array $criteria, array $orderBy = null)
 * @method Airport[]    findAll()
 * @method Airport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AirportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Airport::class);
    }

    public function remove(Airport $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function updateAirport(mixed $row)
    {
        $airport = $this->findOneBy(['icao' => $row[0]]);
        if (!$airport) {
            $airport = new Airport();
            $airport->setExternalId($row[0]);
        }
        $airport->setIdent($row[1]);
        $airport->setType($row[2]);
        $airport->setName($row[3]);
        $airport->setLatitude($row[4]);
        $airport->setLongitude($row[5]);
        $airport->setElevationFt((int)$row[6]);
        $airport->setScheduledService($row[11] === 'yes');
        $airport->setIcao($row[12]);
        $airport->setIata($row[13]);

        $this->save($airport, true);
    }

//    /**
//     * @return Airport[] Returns an array of Airport objects
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

//    public function findOneBySomeField($value): ?Airport
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function save(Airport $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
