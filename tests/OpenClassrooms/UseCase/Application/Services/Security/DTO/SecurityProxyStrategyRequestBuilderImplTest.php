<?php

namespace OpenClassrooms\Tests\UseCase\Application\Services\Security\DTO;

use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Impl\Security\DTO\SecurityProxyStrategyRequestBuilderImpl;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class SecurityProxyStrategyRequestBuilderImplTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @expectedException \OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\Security\Exceptions\AttributesMustBeDefinedException
     */
    public function WithoutAttributes_Build_ThrowException()
    {
        $builder = new SecurityProxyStrategyRequestBuilderImpl();
        $builder
            ->create()
            ->build();
    }
}
