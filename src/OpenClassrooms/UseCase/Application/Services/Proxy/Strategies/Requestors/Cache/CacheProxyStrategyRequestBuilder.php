<?php

namespace OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\Cache;

use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\Cache\Exceptions\CacheIdMustBeDefinedException;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
interface CacheProxyStrategyRequestBuilder
{
    /**
     * @return CacheProxyStrategyRequestBuilder
     */
    public function create();

    /**
     * @return CacheProxyStrategyRequestBuilder
     */
    public function withNamespaceId($namespaceId);

    /**
     * @return CacheProxyStrategyRequestBuilder
     */
    public function withId($id);

    /**
     * @return CacheProxyStrategyRequestBuilder
     */
    public function withData($data);

    /**
     * @return CacheProxyStrategyRequestBuilder
     */
    public function withLifeTime($lifeTime);

    /**
     * @return CacheProxyStrategyRequest
     * @throws CacheIdMustBeDefinedException
     */
    public function build();

}
