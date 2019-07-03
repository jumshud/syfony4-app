<?php
/**
 * Created by PhpStorm.
 * User: jumshud
 * Date: 4/25/18
 * Time: 1:42 PM
 */

namespace App\Adapters;

use App\Components\SocialUser;
use GuzzleHttp\Client;

/**
 * Class Social - used to implement social adapters
 *
 * @package App\Components\Adapters
 *
 * @property Client $client
 * @property array $data
 */
abstract class Social
{
    /**
     * @var string
     */
    protected $token;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var Client $client
     */
    protected $client;

    /**
     * @var aray $data
     */
    protected $data;

    /**
     * Social constructor.
     * @param Client $client
     * @param string $url
     */
    public function __construct(Client $client, string $url)
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException('$url property must be valid');
        }
        $this->client = $client;
        $this->url = $url;
    }

    /**
     * @return SocialUser
     */
    public abstract function me(): SocialUser;

    /**
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }
}