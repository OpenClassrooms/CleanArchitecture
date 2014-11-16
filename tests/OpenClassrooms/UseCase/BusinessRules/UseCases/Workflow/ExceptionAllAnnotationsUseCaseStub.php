<?php

namespace OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\Workflow;

use OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\ExceptionUseCaseStub;
use OpenClassrooms\UseCase\Application\Annotations\Cache;
use OpenClassrooms\UseCase\Application\Annotations\Event;
use OpenClassrooms\UseCase\Application\Annotations\Security;
use OpenClassrooms\UseCase\Application\Annotations\Transaction;
use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\UseCase\BusinessRules\Responders\UseCaseResponse;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class ExceptionAllAnnotationsUseCaseStub extends ExceptionUseCaseStub
{
    /**
     * @Event (name="event_name", methods="pre, post, onException")
     * @Transaction
     * @Cache
     * @Security (roles = "ROLE_1")
     *
     * @return UseCaseResponse
     */
    public function execute(UseCaseRequest $useCaseRequest)
    {
        return parent::execute($useCaseRequest);
    }
}
