<?php

namespace OpenClassrooms\Tests\UseCase\Application\Services\Event;

use OpenClassrooms\UseCase\Application\Services\Event\EventSender;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class EventSenderSpy implements EventSender
{

    /**
     * @var string
     */
    public $eventName;

    /**
     * @var bool
     */
    public $sent = false;

    /**
     * @var int
     */
    public $sentCount = 0;

    /**
     * @var mixed
     */
    public $event;

    public function send($eventName, $event)
    {
        $this->eventName = $eventName;
        $this->sent = true;
        $this->sentCount++;
        $this->event = $event;
    }

}
