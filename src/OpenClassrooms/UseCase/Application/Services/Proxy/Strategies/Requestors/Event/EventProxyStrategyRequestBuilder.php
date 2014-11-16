<?php

namespace OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\Event;

use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\Event\Exceptions\EventNameMustBeDefinedException;
use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\UseCase\BusinessRules\Responders\UseCaseResponse;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
interface EventProxyStrategyRequestBuilder
{
    /**
     * @return EventProxyStrategyRequestBuilder
     */
    public function create();

    /**
     * @return EventProxyStrategyRequestBuilder
     */
    public function withEventName($eventName);

    /**
     * @return EventProxyStrategyRequestBuilder
     */
    public function withUseCaseRequest(UseCaseRequest $useCaseRequest);

    /**
     * @return EventProxyStrategyRequestBuilder
     */
    public function withUseCaseResponse(UseCaseResponse $useCaseResponse);

    /**
     * @return EventProxyStrategyRequestBuilder
     */
    public function withException(\Exception $exception);

    /**
     * @return EventProxyStrategyRequest
     * @throws EventNameMustBeDefinedException
     */
    public function build();
}
