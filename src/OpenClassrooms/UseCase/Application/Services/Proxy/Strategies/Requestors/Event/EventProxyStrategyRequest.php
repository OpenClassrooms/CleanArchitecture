<?php

namespace OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\Event;

use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\ProxyStrategyRequest;
use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\UseCase\BusinessRules\Responders\UseCaseResponse;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
interface EventProxyStrategyRequest extends ProxyStrategyRequest
{
    /**
     * @return string
     */
    public function getEventName();

    /**
     * @return \Exception
     */
    public function getException();

    /**
     * @return UseCaseRequest
     */
    public function getUseCaseRequest();

    /**
     * @return UseCaseResponse
     */
    public function getUseCaseResponse();
}
