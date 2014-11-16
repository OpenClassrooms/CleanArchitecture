<?php

namespace OpenClassrooms\Tests\UseCase\Application\Services\Event;

use OpenClassrooms\Tests\UseCase\Application\Services\Security\Exceptions\AccessDeniedException;
use OpenClassrooms\UseCase\Application\Services\Event\EventFactory;
use OpenClassrooms\UseCase\Application\Services\Event\Exceptions\InvalidEventNameException;
use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\UseCase\BusinessRules\Responders\UseCaseResponse;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class EventFactorySpy implements EventFactory
{
    const INVALID_EVENT_NAME = 'invalid_event_name';

    /**
     * @var UseCaseRequest
     */
    public $useCaseRequest;

    /**
     * @var UseCaseResponse
     */
    public $useCaseResponse;

    /**
     * @var \Exception
     */
    public $exception;

    /**
     * @return mixed
     * @throws InvalidEventNameException
     */
    public function make(
        $eventName,
        UseCaseRequest $useCaseRequest = null,
        UseCaseResponse $useCaseResponse = null,
        \Exception $exception = null
    )
    {
        $this->useCaseRequest = $useCaseRequest;
        $this->useCaseResponse = $useCaseResponse;
        $this->exception = $exception;

        if (self::INVALID_EVENT_NAME === $eventName) {
            throw new InvalidEventNameException($eventName);
        }

        if ($exception instanceof AccessDeniedException) {
            throw $exception;
        }

        return $eventName;
    }

}
