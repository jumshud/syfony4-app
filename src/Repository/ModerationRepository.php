<?php

namespace App\Repository;

use App\Entity\Moderation\Moderation;
use App\Entity\Moderation\Panoramas;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Moderation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Moderation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Moderation[]    findAll()
 * @method Moderation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModerationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Moderation::class);
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

    /**
     * @param int $userId moderation user_id
     * @param int $limit
     * @param int $offset
     * @param string $term according cid or business name
     *
     * @return array|null
     */
    public function findAllByUserId(int $userId, int $limit = 20, int $offset = 0, string $term = ''): ?array
    {
        $term = filter_var($term, FILTER_SANITIZE_STRING);
        $injectedParams = ['userId' => $userId, 'panoType' => Panoramas::PANO_TYPE65];
        $query = $this->createQueryBuilder('m')
            ->select(['m, p'])
            ->leftJoin('m.panoramas', 'p', 'WITH',
                'p.moderation = m.id and p.panoType = :panoType')
            ->where('m.userId = :userId');
        if (strlen($term) > 1) {
            $query = $query->andWhere('m.businessName LIKE :term OR m.cid LIKE :term');
            $injectedParams['term'] = '%'.$term . '%';
        }

        return $query->setParameters($injectedParams)
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->orderBy('m.updatedAt', 'DESC')
            ->getQuery()
            ->getArrayResult();
    }
}
