<?php

namespace OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Impl;

use OpenClassrooms\UseCase\Application\Annotations\Cache;
use OpenClassrooms\UseCase\Application\Annotations\Event;
use OpenClassrooms\UseCase\Application\Annotations\Security;
use OpenClassrooms\UseCase\Application\Annotations\Transaction;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Exceptions\UnSupportedAnnotationException;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Impl\Cache\CacheProxyStrategy;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Impl\Event\EventProxyStrategy;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Impl\Security\SecurityProxyStrategy;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Impl\Transaction\TransactionProxyStrategy;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\ProxyStrategyBagFactory;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class ProxyStrategyBagFactoryImpl implements ProxyStrategyBagFactory
{

    /**
     * @var CacheProxyStrategy
     */
    private $cacheStrategy;

    /**
     * @var TransactionProxyStrategy
     */
    private $transactionStrategy;

    /**
     * @var SecurityProxyStrategy
     */
    private $securityStrategy;

    /**
     * @var EventProxyStrategy
     */
    private $eventStrategy;

    /**
     * @return SecurityProxyStrategyBagImpl
     */
    public function make($annotation)
    {
        switch ($annotation) {
            case $annotation instanceof Security:
                $strategyBag = new SecurityProxyStrategyBagImpl($this->securityStrategy);
                break;
            case $annotation instanceof Cache:
                $strategyBag = new CacheProxyStrategyBagImpl($this->cacheStrategy);
                break;
            case $annotation instanceof Transaction:
                $strategyBag = new TransactionProxyStrategyBagImpl($this->transactionStrategy);
                break;
            case $annotation instanceof Event:
                $strategyBag = new EventProxyStrategyBagImpl($this->eventStrategy);
                /** @var Event $annotation */
                if (in_array(Event::PRE_METHOD, $annotation->getMethods())) {
                    $strategyBag->setPreExecute(true);
                }
                if (in_array(Event::POST_METHOD, $annotation->getMethods())) {
                    $strategyBag->setPostExecute(true);
                }
                if (in_array(Event::ON_EXCEPTION_METHOD, $annotation->getMethods())) {
                    $strategyBag->setOnException(true);
                }
                break;
            default:
                throw new UnSupportedAnnotationException();
        }
        $strategyBag->setAnnotation($annotation);

        return $strategyBag;
    }

    public function setCacheStrategy(CacheProxyStrategy $cacheStrategy)
    {
        $this->cacheStrategy = $cacheStrategy;
    }

    public function setTransactionStrategy(TransactionProxyStrategy $transactionStrategy)
    {
        $this->transactionStrategy = $transactionStrategy;
    }

    public function setSecurityStrategy(SecurityProxyStrategy $securityStrategy)
    {
        $this->securityStrategy = $securityStrategy;
    }

    public function setEventStrategy(EventProxyStrategy $eventStrategy)
    {
        $this->eventStrategy = $eventStrategy;
    }

}
