<?php

namespace App\Repository;

use App\Entity\Airport;
use App\Entity\AirportRunway;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AirportRunway>
 *
 * @method AirportRunway|null find($id, $lockMode = null, $lockVersion = null)
 * @method AirportRunway|null findOneBy(array $criteria, array $orderBy = null)
 * @method AirportRunway[]    findAll()
 * @method AirportRunway[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AirportRunwayRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AirportRunway::class);
    }

    public function save(AirportRunway $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AirportRunway $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return AirportRunway[] Returns an array of AirportRunway objects
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

//    public function findOneBySomeField($value): ?AirportRunway
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function updateRunway(array $row)
    {
        $runway = $this->findOneBy(['external_id' => $row[0]]);
        if (!$runway) {
            $runway = new AirportRunway();
            $runway->setExternalId($row[0]);
            $airport = $this->getEntityManager()->getRepository(Airport::class)->findOneBy(['external_id' => $row[1]]);
            if (!$airport) {
                return;
            }
            $runway->setAirport($airport);
        }
        $runway->setLenghtFt($row[3]);
        $runway->setWidthFt($row[4]);
        $runway->setSurface($row[5]);
        $runway->setLighted($row[6] == 1);//intentional
        $runway->setLeIdent($row[8]);
        $runway->setHeIdent($row[14]);
        $this->save($runway, true);
    }
}
