<?php

namespace OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\Cache;

use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\ProxyStrategyRequest;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
interface CacheProxyStrategyRequest extends ProxyStrategyRequest
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getData();

    /**
     * @return string
     */
    public function getNamespaceId();

    /**
     * @return int
     */
    public function getLifeTime();
}
