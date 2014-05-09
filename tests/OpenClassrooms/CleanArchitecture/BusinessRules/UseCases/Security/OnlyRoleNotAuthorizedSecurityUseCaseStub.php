<?php

namespace OpenClassrooms\Tests\CleanArchitecture\BusinessRules\UseCases\Security;

use OpenClassrooms\CleanArchitecture\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\CleanArchitecture\BusinessRules\Responders\UseCaseResponse;
use OpenClassrooms\Tests\CleanArchitecture\BusinessRules\UseCases\UseCaseStub;
use OpenClassrooms\CleanArchitecture\Application\Annotations\Security;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class OnlyRoleNotAuthorizedSecurityUseCaseStub extends UseCaseStub
{
    /**
     * @security (roles = "ROLE_NOT_AUTHORIZED")
     * @return UseCaseResponse
     */
    public function execute(UseCaseRequest $useCaseRequest)
    {
        return parent::execute($useCaseRequest);
    }
}