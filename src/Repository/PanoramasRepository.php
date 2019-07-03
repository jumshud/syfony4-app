<?php

namespace App\Repository;

use App\Entity\Moderation\Panoramas;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Panoramas|null find($id, $lockMode = null, $lockVersion = null)
 * @method Panoramas|null findOneBy(array $criteria, array $orderBy = null)
 * @method Panoramas[]    findAll()
 * @method Panoramas[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PanoramasRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Panoramas::class);
    }

    // /**
    //  * @return Moderation[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
