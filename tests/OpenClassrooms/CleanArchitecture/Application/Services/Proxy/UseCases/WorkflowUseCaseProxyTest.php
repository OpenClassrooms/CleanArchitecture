<?php

namespace OpenClassrooms\Tests\CleanArchitecture\Application\Services\Proxy\UseCases;

use
    OpenClassrooms\Tests\CleanArchitecture\Application\Services\Security\Exceptions\AccessDeniedException;
use OpenClassrooms\Tests\CleanArchitecture\BusinessRules\Exceptions\UseCaseException;
use OpenClassrooms\Tests\CleanArchitecture\BusinessRules\Requestors\UseCaseRequestStub;
use OpenClassrooms\Tests\CleanArchitecture\BusinessRules\Responders\UseCaseResponseStub;
use OpenClassrooms\Tests\CleanArchitecture\BusinessRules\UseCases\UseCaseStub;
use
    OpenClassrooms\Tests\CleanArchitecture\BusinessRules\UseCases\Workflow\AllAnnotationsNotAuthorizedUseCaseStub;
use
    OpenClassrooms\Tests\CleanArchitecture\BusinessRules\UseCases\Workflow\AllAnnotationsUseCaseStub;
use
    OpenClassrooms\Tests\CleanArchitecture\BusinessRules\UseCases\Workflow\ExceptionAllAnnotationsUseCaseStub;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class WorkflowUseCaseProxyTest extends UseCaseProxyTest
{
    /**
     * @test
     */
    public function UseCase_Execute_ReturnResponse()
    {
        $this->useCaseProxy->setUseCase(new UseCaseStub());
        $response = $this->useCaseProxy->execute(new UseCaseRequestStub());

        $this->assertEquals(new UseCaseResponseStub(), $response);
    }

    /**
     * @test
     */
    public function SecurityException_ThrowException()
    {
        try {
            $this->useCaseProxy->setUseCase(new AllAnnotationsNotAuthorizedUseCaseStub());
            $this->useCaseProxy->execute(new UseCaseRequestStub());
            $this->fail();
        } catch (AccessDeniedException $ade) {
            $this->assertCacheWasNotCalled();
            $this->assertTransactionWasCalledOnUnAuthorizedException();
            $this->assertEventWasNotCalled();
        }
    }

    private function assertCacheWasNotCalled()
    {
        $this->assertFalse($this->cache->fetched);
        $this->assertFalse($this->cache->saved);
    }

    private function assertTransactionWasCalledOnUnAuthorizedException()
    {
        $this->assertFalse($this->transaction->transactionBegin);
        $this->assertFalse($this->transaction->committed);
        $this->assertTrue($this->transaction->rollBacked);
    }

    private function assertEventWasNotCalled()
    {
        $this->assertFalse($this->event->sent);
        $this->assertNull($this->event->event);
        $this->assertEquals(0, $this->event->sentCount);
    }

    /**
     * @test
     */
    public function AllAnnotation_ReturnResponse()
    {
        $this->useCaseProxy->setUseCase(new AllAnnotationsUseCaseStub());
        $response = $this->useCaseProxy->execute(new UseCaseRequestStub());
        $this->assertEquals(new UseCaseResponseStub(), $response);
        $this->assertCacheSaveWasCalled();
        $this->assertTransactionWasCalled();
        $this->assertEventWasCalled();
    }

    private function assertCacheSaveWasCalled()
    {
        $this->assertTrue($this->cache->fetched);
        $this->assertTrue($this->cache->saved);
    }

    private function assertTransactionWasCalled()
    {
        $this->assertTrue($this->transaction->transactionBegin);
        $this->assertTrue($this->transaction->committed);
        $this->assertFalse($this->transaction->rollBacked);
    }

    private function assertEventWasCalled()
    {
        $this->assertTrue($this->event->sent);
        $this->assertNotNull($this->event->event);
        $this->assertEquals(2, $this->event->sentCount);
    }

    /**
     * @test
     */
    public function Cached_ReturnResponse()
    {
        $this->useCaseProxy->setUseCase(new AllAnnotationsUseCaseStub());
        $response = $this->useCaseProxy->execute(new UseCaseRequestStub());
        $this->resetCache();
        $this->resetTransaction();
        $this->resetEvent();
        $this->useCaseProxy->execute(new UseCaseRequestStub());
        $this->assertEquals(new UseCaseResponseStub(), $response);
        $this->assertCacheWasCalled();
        $this->assertTransactionWasNotCalled();
        $this->assertEventWasCalled();
    }

    private function resetCache()
    {
        $this->cache->fetched = false;
        $this->cache->saved = false;
    }

    private function resetTransaction()
    {
        $this->transaction->transactionBegin = false;
        $this->transaction->committed = false;
        $this->transaction->rollBacked = false;
    }

    private function resetEvent()
    {
        $this->event->sent = false;
        $this->event->sentCount = 0;
        $this->event->event = null;
    }

    private function assertCacheWasCalled()
    {
        $this->assertTrue($this->cache->fetched);
        $this->assertFalse($this->cache->saved);
    }

    private function assertTransactionWasNotCalled()
    {
        $this->assertFalse($this->transaction->transactionBegin);
        $this->assertFalse($this->transaction->committed);
        $this->assertFalse($this->transaction->rollBacked);
    }

    /**
     * @test
     */
    public function AllAnnotationException_ThrowException()
    {
        try {
            $this->useCaseProxy->setUseCase(new ExceptionAllAnnotationsUseCaseStub());
            $this->useCaseProxy->execute(new UseCaseRequestStub());
            $this->fail();
        } catch (UseCaseException $e) {
            $this->assertCacheSaveWasNotCalled();
            $this->assertTransactionWasCalledOnException();
            $this->assertEventWasCalledOnException();
        }
    }

    private function assertCacheSaveWasNotCalled()
    {
        $this->assertTrue($this->cache->fetched);
        $this->assertFalse($this->cache->saved);
    }

    private function assertTransactionWasCalledOnException()
    {
        $this->assertTrue($this->transaction->transactionBegin);
        $this->assertFalse($this->transaction->committed);
        $this->assertTrue($this->transaction->rollBacked);
    }

    private function assertEventWasCalledOnException()
    {
        $this->assertTrue($this->event->sent);
        $this->assertNotNull($this->event->event);
        $this->assertEquals(2, $this->event->sentCount);
    }
}