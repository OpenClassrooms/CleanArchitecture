<?php

namespace OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Impl\Cache;

use OpenClassrooms\Cache\Cache\Cache;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Impl\DTO\ProxyStrategyResponseDTO;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\Cache\CacheProxyStrategyRequest;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\PostExecuteProxyStrategy;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\PreExecuteProxyStrategy;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\ProxyStrategy;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\ProxyStrategyRequest;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Responders\ProxyStrategyResponse;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class CacheProxyStrategy implements PreExecuteProxyStrategy, PostExecuteProxyStrategy
{

    /**
     * @var mixed
     */
    private $data;

    /**
     * @var Cache
     */
    private $cache;

    /**
     * @var bool
     */
    private $postExecute = true;

    /**
     * @return string
     */
    public function getType()
    {
        return ProxyStrategy::CACHE;
    }

    /**
     * @return ProxyStrategyResponse
     */
    public function preExecute(ProxyStrategyRequest $proxyStrategyRequest)
    {
        /** @var CacheProxyStrategyRequest $proxyStrategyRequest */
        $this->data = $this->cache->fetchWithNamespace(
            $proxyStrategyRequest->getId(),
            $proxyStrategyRequest->getNamespaceId()
        );

        if ($this->responseIsInCache()) {
            $stopExecution = true;
            $this->postExecute = false;
        } else {
            $stopExecution = false;
        }
        $response = new ProxyStrategyResponseDTO($this->data, $stopExecution);

        return $response;
    }

    /**
     * @return bool
     */
    private function responseIsInCache()
    {
        return $this->data;
    }

    /**
     * @return ProxyStrategyResponse
     */
    public function postExecute(ProxyStrategyRequest $proxyStrategyRequest)
    {
        /** @var CacheProxyStrategyRequest $proxyStrategyRequest */
        $saved = $this->cache->saveWithNamespace(
            $proxyStrategyRequest->getId(),
            $proxyStrategyRequest->getData(),
            $proxyStrategyRequest->getNamespaceId(),
            $proxyStrategyRequest->getLifeTime()
        );
        $response = new ProxyStrategyResponseDTO($saved, false);

        return $response;
    }

    /**
     * @return boolean
     */
    public function isPostExecute()
    {
        return $this->postExecute;
    }

    public function setCache(Cache $cache)
    {
        $this->cache = $cache;
    }
}
