<?php

namespace App\Repository;

use App\Entity\Airport;
use App\Entity\AirportFrequency;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AirportFrequency>
 *
 * @method AirportFrequency|null find($id, $lockMode = null, $lockVersion = null)
 * @method AirportFrequency|null findOneBy(array $criteria, array $orderBy = null)
 * @method AirportFrequency[]    findAll()
 * @method AirportFrequency[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AirportFrequencyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AirportFrequency::class);
    }

    public function save(AirportFrequency $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AirportFrequency $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return AirportFrequency[] Returns an array of AirportFrequency objects
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

//    public function findOneBySomeField($value): ?AirportFrequency
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    public function updateFrequency(array $row)
    {
        $frequency = $this->findOneBy(['external_id' => $row[0]]);
        if (!$frequency) {
            $frequency = new AirportFrequency();
            $frequency->setExternalId($row[0]);
            $airport = $this->getEntityManager()->getRepository(Airport::class)->findOneBy(['external_id' => $row[1]]);
            if (!$airport) {
                return;
            }
            $frequency->setAirport($airport);
        }
        $frequency->setType($row[3]);
        $frequency->setDescription($row[4]);
        $frequency->setFrequency($row[5]);
        $this->save($frequency, true);
    }
}
