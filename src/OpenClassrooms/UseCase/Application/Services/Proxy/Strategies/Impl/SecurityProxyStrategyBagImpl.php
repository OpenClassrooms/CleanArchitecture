<?php

namespace OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Impl;

use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\ProxyStrategyBag;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class SecurityProxyStrategyBagImpl extends ProxyStrategyBag
{

    /**
     * @var bool
     */
    protected $preExecute = true;

}
