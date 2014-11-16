<?php

namespace OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Impl\Cache\DTO;

use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\Cache\CacheProxyStrategyRequest;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\Cache\CacheProxyStrategyRequestBuilder;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\Cache\Exceptions\CacheIdMustBeDefinedException;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class CacheProxyStrategyRequestBuilderImpl implements CacheProxyStrategyRequestBuilder
{

    /**
     * @var CacheProxyStrategyRequestDTO
     */
    private $request;

    /**
     * @return CacheProxyStrategyRequestBuilder
     */
    public function create()
    {
        $this->request = new CacheProxyStrategyRequestDTO();

        return $this;
    }

    /**
     * @return CacheProxyStrategyRequestBuilder
     */
    public function withId($id)
    {
        $this->request->id = $id;

        return $this;
    }

    /**
     * @return CacheProxyStrategyRequestBuilder
     */
    public function withData($data)
    {
        $this->request->data = $data;

        return $this;
    }

    /**
     * @return CacheProxyStrategyRequestBuilder
     */
    public function withNamespaceId($namespaceId)
    {
        $this->request->namespaceId = $namespaceId;

        return $this;
    }

    /**
     * @return CacheProxyStrategyRequestBuilder
     */
    public function withLifeTime($lifeTime)
    {
        $this->request->lifeTime = $lifeTime;

        return $this;
    }

    /**
     * @return CacheProxyStrategyRequest
     * @throws CacheIdMustBeDefinedException
     */
    public function build()
    {
        if (null === $this->request->id) {
            throw new CacheIdMustBeDefinedException();
        }

        return $this->request;
    }
}
