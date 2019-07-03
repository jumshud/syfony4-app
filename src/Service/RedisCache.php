<?php

namespace App\Service;

use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;

class RedisCache
{
    /**
     * @var CacheItemPoolInterface
     */
    private $cache;

    public function __construct(CacheItemPoolInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @param string $key
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     */
    public function get(string $key)
    {
        $cachedItem = $this->cache->getItem(md5($key));

        if (false === $cachedItem->isHit()) {
            return null;
        }

        return $cachedItem->get();
    }

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return void
     *
     * @throws InvalidArgumentException
     */
    public function set(string $key, $value)
    {
        $cachedItem = $this->cache->getItem(md5($key));
        $cachedItem->set($value);
        $this->cache->save($cachedItem);
    }
}