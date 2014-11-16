<?php

namespace OpenClassrooms\Tests\UseCase\Application\Services\Proxy\UseCases;

use Doctrine\Common\Annotations\AnnotationReader;
use OpenClassrooms\Tests\UseCase\Application\Services\Cache\CacheSpy;
use OpenClassrooms\Tests\UseCase\Application\Services\Event\EventFactorySpy;
use OpenClassrooms\Tests\UseCase\Application\Services\Event\EventSenderSpy;
use OpenClassrooms\Tests\UseCase\Application\Services\Security\SecuritySpy;
use OpenClassrooms\Tests\UseCase\Application\Services\Transaction\TransactionSpy;
use OpenClassrooms\Tests\UseCase\BusinessRules\Requestors\UseCaseRequestStub;
use OpenClassrooms\Tests\UseCase\BusinessRules\Responders\Doubles\UseCaseResponseStub;
use OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\Cache\OnlyCacheUseCaseStub;
use OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\Event\OnlyEventNameEventUseCaseStub;
use OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\Security\OnlyRoleSecurityUseCaseStub;
use OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\Transaction\OnlyTransactionUseCaseStub;
use OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\Workflow\AllAnnotationsUseCaseStub;
use OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\Impl\UseCaseProxyBuilderImpl;
use OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\UseCaseProxyBuilder;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class UseCaseProxyBuilderTest extends \PHPUnit_Framework_TestCase
{
    const USE_CASE_PROXY_CLASS = 'OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\UseCaseProxy';

    /**
     * @var UseCaseProxyBuilder
     */
    private $builder;

    /**
     * @test
     * @expectedException \OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\Exceptions\ReaderIsNotDefinedException
     */
    public function WithoutReader_Build_ThrowException()
    {
        $this->builder->create(new AllAnnotationsUseCaseStub())->build();
    }

    /**
     * @test
     * @expectedException \OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\Exceptions\SecurityIsNotDefinedException
     */
    public function WithoutSecurityUseCaseWithSecurityAnnotation_Build_ThrowException()
    {
        $this->builder
            ->create(new OnlyRoleSecurityUseCaseStub())
            ->withReader(new AnnotationReader())
            ->build();

    }

    /**
     * @test
     */
    public function WithSecurityUseCaseWithSecurityAnnotation_Build_ReturnUseCaseProxy()
    {
        $proxy = $this->builder
            ->create(new OnlyRoleSecurityUseCaseStub())
            ->withReader(new AnnotationReader())
            ->withSecurity(new SecuritySpy())
            ->build();

        $this->assertInstanceOf(self::USE_CASE_PROXY_CLASS, $proxy);
        $this->assertEquals(new OnlyRoleSecurityUseCaseStub(), $proxy->getUseCase());
        $this->assertEquals(new UseCaseResponseStub(), $proxy->execute(new UseCaseRequestStub()));
    }

    /**
     * @test
     * @expectedException \OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\Exceptions\CacheIsNotDefinedException
     */
    public function WithoutCacheUseCaseWithCacheAnnotation_Build_ThrowException()
    {
        $this->builder
            ->create(new OnlyCacheUseCaseStub())
            ->withReader(new AnnotationReader())
            ->build();
    }

    /**
     * @test
     */
    public function WithCacheUseCaseWithCacheAnnotation_Build_ReturnUseCaseProxy()
    {
        $proxy = $this->builder
            ->create(new OnlyCacheUseCaseStub())
            ->withReader(new AnnotationReader())
            ->withCache(new CacheSpy())
            ->build();

        $this->assertInstanceOf(self::USE_CASE_PROXY_CLASS, $proxy);
        $this->assertEquals(new OnlyCacheUseCaseStub(), $proxy->getUseCase());
        $this->assertEquals(new UseCaseResponseStub(), $proxy->execute(new UseCaseRequestStub()));
    }

    /**
     * @test
     * @expectedException \OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\Exceptions\TransactionIsNotDefinedException
     */
    public function WithoutTransactionUseCaseWithTransactionAnnotation_Build_ThrowException()
    {
        $this->builder
            ->create(new OnlyTransactionUseCaseStub())
            ->withReader(new AnnotationReader())
            ->build();
    }

    /**
     * @test
     */
    public function WithTransactionUseCaseWithTransactionAnnotation_Build_ReturnUseCaseProxy()
    {
        $proxy = $this->builder
            ->create(new OnlyTransactionUseCaseStub())
            ->withReader(new AnnotationReader())
            ->withTransaction(new TransactionSpy())
            ->build();

        $this->assertInstanceOf(self::USE_CASE_PROXY_CLASS, $proxy);
        $this->assertEquals(new OnlyTransactionUseCaseStub(), $proxy->getUseCase());
        $this->assertEquals(new UseCaseResponseStub(), $proxy->execute(new UseCaseRequestStub()));
    }

    /**
     * @test
     * @expectedException \OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\Exceptions\EventIsNotDefinedException
     */
    public function WithoutEventUseCaseWithEventAnnotation_Build_ThrowException()
    {
        $this->builder
            ->create(new OnlyEventNameEventUseCaseStub())
            ->withReader(new AnnotationReader())
            ->build();
    }

    /**
     * @test
     * @expectedException \OpenClassrooms\UseCase\Application\Services\Proxy\UseCases\Exceptions\EventFactoryIsNotDefinedException
     */
    public function WithoutEventFactoryUseCaseWithEventAnnotation_Build_ThrowException()
    {
        $this->builder
            ->create(new OnlyEventNameEventUseCaseStub())
            ->withReader(new AnnotationReader())
            ->withEvent(new EventSenderSpy())
            ->build();
    }

    /**
     * @test
     */
    public function WithEventUseCaseWithEventAnnotation_Build_ReturnUseCaseProxy()
    {
        $proxy = $this->builder
            ->create(new OnlyEventNameEventUseCaseStub())
            ->withReader(new AnnotationReader())
            ->withEvent(new EventSenderSpy())
            ->withEventFactory(new EventFactorySpy())
            ->build();

        $this->assertInstanceOf(self::USE_CASE_PROXY_CLASS, $proxy);
        $this->assertEquals(new OnlyEventNameEventUseCaseStub(), $proxy->getUseCase());
        $this->assertEquals(new UseCaseResponseStub(), $proxy->execute(new UseCaseRequestStub()));
    }

    /**
     * @test
     */
    public function Build_ReturnUseCaseProxy()
    {
        $proxy = $this->builder
            ->create(new AllAnnotationsUseCaseStub())
            ->withReader(new AnnotationReader())
            ->withCache(new CacheSpy())
            ->withEvent(new EventSenderSpy())
            ->withEventFactory(new EventFactorySpy())
            ->withSecurity(new SecuritySpy())
            ->withTransaction(new TransactionSpy())
            ->build();

        $this->assertInstanceOf(self::USE_CASE_PROXY_CLASS, $proxy);
        $this->assertEquals(new AllAnnotationsUseCaseStub(), $proxy->getUseCase());
        $this->assertEquals(new UseCaseResponseStub(), $proxy->execute(new UseCaseRequestStub()));
    }

    protected function setUp()
    {
        $this->builder = new UseCaseProxyBuilderImpl();
    }

}
