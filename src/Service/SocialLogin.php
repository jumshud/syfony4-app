<?php
/**
 * Created by PhpStorm.
 * User: jumshud
 * Date: 12/4/18
 * Time: 10:07 AM
 */

namespace App\Service;

use App\Entity\Main\User;
use App\Entity\Main\UserTokens;
use App\Utils\StringUtil;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Adapters\FacebookAdapter;
use App\Adapters\GoogleAdapter;
use App\Adapters\Social;
use GuzzleHttp\Client;

/**
 * Class SocialLogin
 * @package App\Components
 *
 * @property Social $adapter
 */
class SocialLogin
{
    const TYPE_FB = 'fb';
    const TYPE_GOOGLE = 'google';

    private $adapter;
    private $entityManager;
    private $params;
    private $logger;

    public function __construct(ParameterBagInterface $params, EntityManagerInterface $entityManager, LoggerInterface $logger)
    {
        $this->params = $params;
        $this->entityManager = $entityManager;
        $this->logger = $logger;
    }

    public function setAdapter(string $socialType, string $token)
    {
        $client = new Client();

        switch ($socialType) {
            case self::TYPE_FB:
                $this->adapter = new FacebookAdapter($client, $this->params->get('fb.graph.url'));
                break;
            case self::TYPE_GOOGLE:
                $this->adapter = new GoogleAdapter($client, $this->params->get('google.oauth2.url'));
                break;
            default:
                throw new \InvalidArgumentException('invalid adapter');
        }

        $this->adapter->setToken($token);
    }

    public function login()
    {
        if (!($this->adapter instanceof Social)) {
            throw new \InvalidArgumentException('invalid adapter');
        }
        $sUser = $this->adapter->me();

        $repository = $this->entityManager->getRepository(User::class);
        $user = $repository->findOneBy(['email' => $sUser->getEmail()]);

        $token = StringUtil::generateRandomString(64);
        if ($user instanceof User) {
            $userToken = $user->getUserToken();
        } else {
            $user = New User();
            $user->setEmail($sUser->getEmail());
            $user->setUsername($sUser->getEmail());
            $user->setFirstName($sUser->getFirstName());
            $user->setLastName($sUser->getLastName());
            $user->setGender($sUser->getGender());
            $user->setIsActive(User::IS_ACTIVE);
            $user->setPicture($sUser->getPicture());
            $this->entityManager->persist($user);
            $this->entityManager->flush();
            //$image = substr(sha1(uniqid() . rand(1000, 9999) . time()), 0, 16) . '.jpg';
            //$this->saveImage($user->getId(), $sUser->getPicture(), $image);

            $this->logger->info('new user created', ['id' => $user->getId(), 'email' => $user->getEmail()]);
        }

        if (empty($userToken)) {
            $userToken = new UserTokens();
            $userToken->setUser($user);
        }

        $userToken->setToken($token);
        $this->entityManager->persist($userToken);
        $this->entityManager->flush();

        return [
            'user' => [
                'id' => $user->getId(),
                'name' => $user->getFullName(),
                'picture' => $user->getPicture()
            ],
            'token' => $userToken->getToken(),
            'expired_at' => $userToken->getExpiredAt()->format('Y-m-d H:i:s')
        ];
    }

    /**
     * @param int $userId
     * @param string $imageUrl social image url
     * @param string $image new image name
     */
    private function saveImage(int $userId, string $imageUrl, string $image)
    {
        $dir = '/data/moderation/' . $userId . '/';
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        file_put_contents($dir.$image, file_get_contents($imageUrl));

    }
}