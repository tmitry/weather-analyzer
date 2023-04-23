<?php

declare(strict_types=1);

namespace App\Temperature\Infrastructure\Doctrine\Repository;

use App\Temperature\Domain\Entity\AverageTemperature;
use App\Temperature\Domain\Repository\AverageTemperatureRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @extends ServiceEntityRepository<AverageTemperature>
 *
 * @method AverageTemperature|null find($id, $lockMode = null, $lockVersion = null)
 * @method AverageTemperature|null findOneBy(array $criteria, array $orderBy = null)
 * @method AverageTemperature[]    findAll()
 * @method AverageTemperature[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AverageTemperatureRepository extends ServiceEntityRepository implements AverageTemperatureRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AverageTemperature::class);
    }

    public function save(AverageTemperature $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AverageTemperature $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllByCriteria(): array
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findOneById(Uuid $id): ?AverageTemperature
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.id = :id')
            ->setParameter('id', $id->toBinary())
            ->getQuery()
            ->getOneOrNullResult();
    }

//    /**
//     * @return AverageTemperature[] Returns an array of AverageTemperature objects
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

//    public function findOneBySomeField($value): ?AverageTemperature
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
