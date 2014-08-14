<?php

namespace OpenClassrooms\Tests\UseCase\BusinessRules\UseCases;

use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCase;
use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\UseCase\BusinessRules\Responders\UseCaseResponse;
use OpenClassrooms\Tests\UseCase\BusinessRules\Responders\Doubles\UseCaseResponseStub;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class UseCaseStub implements UseCase
{
    /**
     * @return UseCaseResponse
     */
    public function execute(UseCaseRequest $useCaseRequest)
    {
        return new UseCaseResponseStub();
    }

}
