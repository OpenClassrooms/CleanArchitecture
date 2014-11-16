<?php

namespace OpenClassrooms\Tests\UseCase\Application\Services\Proxy\UseCases;

use OpenClassrooms\Tests\UseCase\BusinessRules\Exceptions\UseCaseException;
use OpenClassrooms\Tests\UseCase\BusinessRules\Requestors\UseCaseRequestStub;
use OpenClassrooms\Tests\UseCase\BusinessRules\Responders\Doubles\UseCaseResponseStub;
use OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\Event\EventUseCaseStub;
use OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\Event\OnExceptionEventUseCaseStub;
use OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\Event\OnlyEventNameEventUseCaseStub;
use OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\Event\PostEventUseCaseStub;
use OpenClassrooms\Tests\UseCase\BusinessRules\UseCases\Event\PreEventUseCaseStub;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class EventUseCaseProxyTest extends AbstractUseCaseProxyTest
{
    const EVENT_PRE_NAME_PREFIX = 'use_case.pre.';

    const EVENT_POST_NAME_PREFIX = 'use_case.post.';

    const EVENT_EXCEPTION_NAME_PREFIX = 'use_case.exception.';

    /**
     * @test
     */
    public function Event_ReturnResponse()
    {
        $this->useCaseProxy->setUseCase(new EventUseCaseStub());

        $response = $this->useCaseProxy->execute(new UseCaseRequestStub());

        $this->assertEvent($response, self::EVENT_POST_NAME_PREFIX . EventUseCaseStub::EVENT_NAME);
        $this->assertEquals(new UseCaseResponseStub(), $this->eventFactory->useCaseResponse);
    }

    private function assertEvent($response, $expectedEventName)
    {
        $this->assertEquals(new UseCaseResponseStub(), $response);
        $this->assertTrue($this->event->sent);
        $this->assertEquals(1, $this->event->sentCount);
        $this->assertEquals($expectedEventName, $this->event->event);
        $this->assertEquals($expectedEventName, $this->event->eventName);
        $this->assertEquals(new UseCaseRequestStub(), $this->eventFactory->useCaseRequest);
    }

    /**
     * @test
     */
    public function OnlyEventName_ReturnResponse()
    {
        $this->useCaseProxy->setUseCase(new OnlyEventNameEventUseCaseStub());

        $response = $this->useCaseProxy->execute(new UseCaseRequestStub());

        $this->assertEvent($response, self::EVENT_POST_NAME_PREFIX . OnlyEventNameEventUseCaseStub::EVENT_NAME);
        $this->assertEquals(new UseCaseResponseStub(), $this->eventFactory->useCaseResponse);
    }

    /**
     * @test
     */
    public function PreEvent_ReturnResponse()
    {
        $this->useCaseProxy->setUseCase(new PreEventUseCaseStub());

        $response = $this->useCaseProxy->execute(new UseCaseRequestStub());

        $this->assertEvent($response, self::EVENT_PRE_NAME_PREFIX . PreEventUseCaseStub::EVENT_NAME);
        $this->assertNull($this->eventFactory->useCaseResponse);

    }

    /**
     * @test
     */
    public function PostEvent_ReturnResponse()
    {
        $this->useCaseProxy->setUseCase(new PostEventUseCaseStub());

        $response = $this->useCaseProxy->execute(new UseCaseRequestStub());

        $this->assertEvent($response, self::EVENT_POST_NAME_PREFIX . PostEventUseCaseStub::EVENT_NAME);
        $this->assertEquals(new UseCaseResponseStub(), $this->eventFactory->useCaseResponse);
    }

    /**
     * @test
     */
    public function OnException_ReturnResponse()
    {
        try {
            $this->useCaseProxy->setUseCase(new OnExceptionEventUseCaseStub());

            $this->useCaseProxy->execute(new UseCaseRequestStub());
        } catch (UseCaseException $e) {
            $this->assertTrue($this->event->sent);
            $this->assertEquals(1, $this->event->sentCount);
            $expectedEventName = self::EVENT_EXCEPTION_NAME_PREFIX . OnExceptionEventUseCaseStub::EVENT_NAME;
            $this->assertEquals($expectedEventName, $this->event->eventName);
            $this->assertEquals($expectedEventName, $this->event->event);
            $this->assertEquals(new UseCaseRequestStub(), $this->eventFactory->useCaseRequest);
            $this->assertNull($this->eventFactory->useCaseResponse);
            $this->assertEquals(new UseCaseException(), $this->eventFactory->exception);
        }
    }
}
