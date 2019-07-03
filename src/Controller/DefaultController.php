<?php

namespace App\Controller;

use App\Service\RedisCache;
use Psr\Log\LoggerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class DefaultController extends BaseController
{
    /**
     * @Route("/index", name="default_index")
     *
     * @param LoggerInterface $logger
     * @param UserInterface|null $user
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function index(LoggerInterface $logger, UserInterface $user = null)
    {
        $logger->debug('Action fired!');
        return $this->resultJson(['name' => 'Hello world']);
    }

    /**
     * @Route("/users", name="default_users")
     *
     * @param RedisCache $redisCache
     * @return string
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function users(RedisCache $redisCache)
    {
        $users = $redisCache->get('users');
        if (is_null($users)) {
            $data = ['user1', 'user2', 'user3'];
            $redisCache->set('users', json_encode($data));
        } else {
            $data = json_decode($users);
        }

        return $this->json([
            'users' => $data
        ]);
    }
}