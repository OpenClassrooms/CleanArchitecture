<?php

namespace OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Impl;

use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\ProxyStrategyBag;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class EventProxyStrategyBagImpl extends ProxyStrategyBag
{
    public function setOnException($onException)
    {
        $this->onException = $onException;
    }

    public function setPostExecute($postExecute)
    {
        $this->postExecute = $postExecute;
    }

    public function setPreExecute($preExecute)
    {
        $this->preExecute = $preExecute;
    }
}
