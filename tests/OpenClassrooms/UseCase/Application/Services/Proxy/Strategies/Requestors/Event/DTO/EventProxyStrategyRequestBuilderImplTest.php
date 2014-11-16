<?php

namespace OpenClassrooms\Tests\UseCase\Application\Services\Proxy\Strategies\Requestors\Event\DTO;

use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Impl\Event\DTO\EventProxyStrategyRequestBuilderImpl;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class EventProxyStrategyRequestBuilderImplTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @expectedException \OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\Event\Exceptions\EventNameMustBeDefinedException
     */
    public function WithoutEventName_Build_ThrowException()
    {
        $builder = new EventProxyStrategyRequestBuilderImpl();
        $builder->create()->build();
    }
}
