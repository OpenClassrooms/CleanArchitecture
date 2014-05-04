<?php

namespace OpenClassrooms\Tests\CleanArchitecture\Application\Services\Proxy\Strategies\Requestors;

use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Impl\ProxyStrategyBagFactoryImpl;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class ProxyStrategyBagFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @expectedException \OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Exceptions\UnSupportedAnnotationException
     */
    public function UnsupportedAnnotation_Make_ThrowException()
    {
        $factory = new ProxyStrategyBagFactoryImpl();
        $factory->make('unsupported annotation');
    }
}