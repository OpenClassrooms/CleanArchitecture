<?php

namespace OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors;

use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Responders\ProxyStrategyResponse;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
interface PreExecuteProxyStrategy extends ProxyStrategy
{
    /**
     * @return ProxyStrategyResponse
     */
    public function preExecute(ProxyStrategyRequest $proxyStrategyRequest);
}
