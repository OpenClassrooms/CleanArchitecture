<?php

namespace OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\Cache;

use OpenClassrooms\Tests\UseCase\BusinessRules\Requestors\UseCaseRequestStub;
use OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\UseCaseStub;
use OpenClassrooms\UseCase\Application\Annotations\Cache;
use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCaseRequest;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class NamespaceCacheUseCaseStub extends UseCaseStub
{
    const NAMESPACE_PREFIX = 'namespace_prefix';

    const NAMESPACE_ATTRIBUTE = UseCaseRequestStub::FIELD_VALUE;

    /**
     * @Cache (namespacePrefix = "namespace_prefix", namespaceAttribute= "field")
     */
    public function execute(UseCaseRequest $useCaseRequest)
    {
        return parent::execute($useCaseRequest);
    }
}
