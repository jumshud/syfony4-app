<?php

namespace App\Service;

use App\Entity\Moderation\Moderation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @property EntityManagerInterface $entityManager entity manager for constellation connection
 * @property UserInterface $user logged in user
*/
class Constellations
{
    private $entityManager;
    private $user;

    /**
     * Constellations constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param UserInterface $user
     */
    public function __construct(EntityManagerInterface $entityManager, UserInterface $user)
    {
        $this->entityManager = $entityManager;
        $this->user = $user;
    }

    /**
     * @param int $limit
     * @param int $offset
     * @param string $term
     * @return array|null list of constellation
     */
    public function getConstellationListByUser(int $limit = 20, int $offset = 0, ?string $term = ''): ?array
    {
        $res = [];
        $repo = $this->entityManager->getRepository(Moderation::class);
        $constellations = $repo->findAllByUserId($this->user->getId(), $limit, $offset, $term); // @TODO replace 1 with $this->>user->getId()
        foreach ($constellations as $c) {
            $updateDate = $c['updatedAt']?: $c['createdAt'];
            $res[] = [
                'id' => $c['id'],
                'name' => $c['businessName'],
                'cid' => $c['cid'],
                'account' => $c['publishAccount'],
                'placeId' => $c['placeId'],
                'updatedAt' => $updateDate->format('Y-m-d H:i:s'),
                'image' => $this->getPanoThumbByModeration($c)
            ];
        }
        return [
            'items' => $res,
            'totalCount' => $this->getTotalCount($this->user->getId(), $term)
        ];
    }

    /**
     * @param int $userId moderation user_id
     * @param string $term according cid or business name
     *
     * @return int
     */
    public function getTotalCount(int $userId, string $term = ''): int
    {
        $term = filter_var($term, FILTER_SANITIZE_STRING);
        $injectedParams = ['userId' => $userId];
        $query = $this->entityManager->createQueryBuilder()
            ->select('count(m.id) as count')
            ->from('App\Entity\Moderation\Moderation', 'm')
            ->where('m.userId = :userId');
        if (strlen($term) > 1) {
            $query = $query->andWhere('m.businessName LIKE :term OR m.cid LIKE :term');
            $injectedParams['term'] = '%'.$term . '%';
        }

        return $query->setParameters($injectedParams)
            ->getQuery()
            ->getArrayResult()[0]['count'];
    }

    public function getPanoThumbByModeration(array $moderation)
    {
        $panorama = isset($moderation['panoramas'][0]) ? $moderation['panoramas'][0] : [];
        if (!$panorama) {
            $panorama = $this->entityManager->createQueryBuilder()
                ->select('p')
                ->from('App\Entity\Moderation\Panoramas', 'p')
                ->andWhere('p.moderation = :moderationId')
                ->setParameters(['moderationId' => $moderation['id']])
                ->setMaxResults(1)
                ->orderBy('p.folderId', 'ASC')
                ->getQuery()
                ->getArrayResult();
            $panorama = $panorama ? $panorama[0] : [];
        }

        if ($panorama && $panorama['thumbLocalPath']) {
            $sVersionAppend = '00000';
            if($panorama['version']>9) {
                $sVersionAppend = '0000';
            }
            $sThumbUrl = str_replace('/var/www/html/google/moderation/','https://img.gothru.org/', trim($panorama['thumbLocalPath']).'?resize=350x175&save=optimize&pad=bg:'.$sVersionAppend.$panorama['version']);
        }else {
            $sThumbUrl = 'https://gothru.co/img/no_images.jpg';
        }

        return $sThumbUrl;
    }
}