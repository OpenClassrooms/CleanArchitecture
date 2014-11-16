<?php

namespace OpenClassrooms\Tests\UseCase\Application\Services\Proxy\Strategies\Requestors;

use OpenClassrooms\Tests\UseCase\BusinessRules\Exceptions\UseCaseException;
use OpenClassrooms\Tests\UseCase\BusinessRules\Requestors\UseCaseRequestStub;
use OpenClassrooms\Tests\UseCase\BusinessRules\Responders\Doubles\UseCaseResponseStub;
use OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\UseCaseStub;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Impl\ProxyStrategyRequestFactoryImpl;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class ProxyStrategyRequestFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @expectedException \OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Exceptions\UnSupportedAnnotationException
     */
    public function UnsupportedAnnotation_CreatePreExecuteRequest_ThrowException()
    {
        $factory = new ProxyStrategyRequestFactoryImpl();
        $factory->createPreExecuteRequest('unsupported annotation', new UseCaseStub(), new UseCaseRequestStub());
    }

    /**
     * @test
     * @expectedException \OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Exceptions\UnSupportedAnnotationException
     */
    public function UnsupportedAnnotation_CreatePostExecuteRequest_ThrowException()
    {
        $factory = new ProxyStrategyRequestFactoryImpl();
        $factory->createPostExecuteRequest(
            'unsupported annotation',
            new UseCaseStub(),
            new UseCaseRequestStub(),
            new UseCaseResponseStub()
        );
    }

    /**
     * @test
     * @expectedException \OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Exceptions\UnSupportedAnnotationException
     */
    public function UnsupportedAnnotation_CreateOnExceptionRequest_ThrowException()
    {
        $factory = new ProxyStrategyRequestFactoryImpl();
        $factory->createOnExceptionRequest(
            'unsupported annotation',
            new UseCaseStub(),
            new UseCaseRequestStub(),
            new UseCaseException()
        );
    }
}
