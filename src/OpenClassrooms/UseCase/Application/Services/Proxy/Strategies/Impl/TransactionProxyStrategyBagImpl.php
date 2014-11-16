<?php

namespace OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Impl;

use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\ProxyStrategyBag;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class TransactionProxyStrategyBagImpl extends ProxyStrategyBag
{

    /**
     * @var bool
     */
    protected $preExecute = true;

    /**
     * @var bool
     */
    protected $postExecute = true;

    /**
     * @var bool
     */
    protected $onException = true;

}
