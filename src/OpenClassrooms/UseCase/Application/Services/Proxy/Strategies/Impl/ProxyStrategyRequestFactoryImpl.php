<?php

namespace OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Impl;

use OpenClassrooms\UseCase\Application\Annotations\Cache;
use OpenClassrooms\UseCase\Application\Annotations\Event;
use OpenClassrooms\UseCase\Application\Annotations\Security;
use OpenClassrooms\UseCase\Application\Annotations\Transaction;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Exceptions\UnSupportedAnnotationException;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Impl\DTO\ProxyStrategyRequestDTO;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\Cache\CacheProxyStrategyRequestBuilder;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\Event\EventProxyStrategyRequestBuilder;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\ProxyStrategyRequest;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\ProxyStrategyRequestFactory;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\Security\SecurityProxyStrategyRequestBuilder;
use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCase;
use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\UseCase\BusinessRules\Responders\UseCaseResponse;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class ProxyStrategyRequestFactoryImpl implements ProxyStrategyRequestFactory
{

    /**
     * @var CacheProxyStrategyRequestBuilder
     */
    private $cacheProxyStrategyRequestBuilder;

    /**
     * @var SecurityProxyStrategyRequestBuilder
     */
    private $securityProxyStrategyRequestBuilder;

    /**
     * @var EventProxyStrategyRequestBuilder
     */
    private $eventProxyStrategyRequestBuilder;

    /**
     * @return ProxyStrategyRequest
     */
    public function createPreExecuteRequest($annotation, UseCase $useCase, UseCaseRequest $useCaseRequest)
    {
        switch ($annotation) {
            case $annotation instanceof Security:
                /** @var Security $annotation */
                if ($annotation->checkRequest()) {
                    $object = $useCaseRequest;
                } elseif (null !== $fieldName = $annotation->getCheckField()) {
                    $reflectionObject = new \ReflectionObject($useCaseRequest);
                    $property = $reflectionObject->getProperty($fieldName);
                    $property->setAccessible(true);
                    $object = $property->getValue($useCaseRequest);
                } else {
                    $object = null;
                }

                $request = $this->securityProxyStrategyRequestBuilder
                    ->create()
                    ->withAttributes($annotation->getRoles())
                    ->withObject($object)
                    ->build();
                break;
            case $annotation instanceof Cache:
                /** @var Cache $annotation */
                $request = $this->cacheProxyStrategyRequestBuilder
                    ->create()
                    ->withNamespaceId($this->getNamespaceId($annotation, $useCaseRequest))
                    ->withId($this->createCacheId($useCase, $useCaseRequest))
                    ->withLifeTime($annotation->getLifetime())
                    ->build();
                break;
            case $annotation instanceof Transaction:
                $request = new ProxyStrategyRequestDTO();
                break;
            case $annotation instanceof Event:
                /** @var Event $annotation */
                $request = $this->eventProxyStrategyRequestBuilder
                    ->create()
                    ->withEventName($this->getPreEventName($annotation, $useCase))
                    ->withUseCaseRequest($useCaseRequest)
                    ->build();
                break;
            default:
                throw new UnSupportedAnnotationException();
                break;
        }

        return $request;
    }

    /**
     * @return string|null
     */
    private function getNamespaceId(Cache $annotation, UseCaseRequest $useCaseRequest)
    {
        $namespaceId = null;
        if (null !== $annotation->getNamespacePrefix()) {
            $namespaceId = $annotation->getNamespacePrefix();
        }
        if (null !== $namespaceAttribute = $annotation->getNamespaceAttribute()) {
            $reflectionClass = new \ReflectionClass($useCaseRequest);
            $property = $reflectionClass->getProperty($namespaceAttribute);
            $property->setAccessible(true);
            null === $namespaceId ? $namespaceId = $property->getValue($useCaseRequest)
                : $namespaceId .= $property->getValue($useCaseRequest);
        }

        return $namespaceId;
    }

    /**
     * @return string
     */
    private function createCacheId(UseCase $useCase, UseCaseRequest $useCaseRequest)
    {
        return md5(get_class($useCase) . serialize($useCaseRequest));
    }

    /**
     * @return string
     */
    private function getPreEventName(Event $annotation, UseCase $useCase)
    {
        return 'use_case.pre.' . $this->getEventName($annotation, $useCase);
    }

    /**
     * @return string
     */
    private function getEventName(Event $annotation, UseCase $useCase)
    {
        if (null === $name = $annotation->getName()) {
            $reflectionClass = new \ReflectionClass($useCase);
            $name = $reflectionClass->getShortName();
        }

        return $this->formatEventName($name);
    }

    /**
     * @return string
     */
    private function formatEventName($name)
    {
        $name = preg_replace('/(?<=\\w)(?=[A-Z])/', "_$1", $name);
        $name = strtolower($name);

        return $name;
    }

    /**
     * @return ProxyStrategyRequest
     */
    public function createPostExecuteRequest(
        $annotation,
        UseCase $useCase,
        UseCaseRequest $useCaseRequest,
        UseCaseResponse $useCaseResponse = null
    )
    {
        $request = new ProxyStrategyRequestDTO();
        switch ($annotation) {
            case $annotation instanceof Cache:
                /** @var Cache $annotation */
                $request = $this->cacheProxyStrategyRequestBuilder
                    ->create()
                    ->withNamespaceId($this->getNamespaceId($annotation, $useCaseRequest))
                    ->withId($this->createCacheId($useCase, $useCaseRequest))
                    ->withLifeTime($annotation->getLifetime())
                    ->withData($useCaseResponse)
                    ->build();
                break;
            case $annotation instanceof Transaction:
                break;
            case $annotation instanceof Event:
                /** @var Event $annotation */
                if (in_array('post', $annotation->getMethods())) {
                    $request = $this->eventProxyStrategyRequestBuilder
                        ->create()
                        ->withEventName($this->getPostEventName($annotation, $useCase))
                        ->withUseCaseRequest($useCaseRequest)
                        ->withUseCaseResponse($useCaseResponse)
                        ->build();
                }
                break;
            default:
                throw new UnSupportedAnnotationException();
        }

        return $request;
    }

    /**
     * @return string
     */
    private function getPostEventName(Event $annotation, UseCase $useCase)
    {
        return 'use_case.post.' . $this->getEventName($annotation, $useCase);
    }

    /**
     * @return ProxyStrategyRequest
     */
    public function createOnExceptionRequest(
        $annotation,
        UseCase $useCase,
        UseCaseRequest $useCaseRequest,
        \Exception $exception
    )
    {
        switch ($annotation) {
            case $annotation instanceof Transaction:
                $request = new ProxyStrategyRequestDTO();
                break;
            case $annotation instanceof Event:
                /** @var Event $annotation */
                $request = $this->eventProxyStrategyRequestBuilder
                    ->create()
                    ->withEventName($this->getOnExceptionEventName($annotation, $useCase))
                    ->withUseCaseRequest($useCaseRequest)
                    ->withException($exception)
                    ->build();
                break;
            default:
                throw new UnSupportedAnnotationException();
        }

        return $request;
    }

    /**
     * @return string
     */
    private function getOnExceptionEventName(Event $annotation, UseCase $useCase)
    {
        return 'use_case.exception.' . $this->getEventName($annotation, $useCase);
    }

    public function setCacheProxyStrategyRequestBuilder(
        CacheProxyStrategyRequestBuilder $cacheProxyStrategyRequestBuilder
    )
    {
        $this->cacheProxyStrategyRequestBuilder = $cacheProxyStrategyRequestBuilder;
    }

    public function setSecurityProxyStrategyRequestBuilder(
        SecurityProxyStrategyRequestBuilder $securityProxyStrategyRequestBuilder
    )
    {
        $this->securityProxyStrategyRequestBuilder = $securityProxyStrategyRequestBuilder;
    }

    public function setEventProxyStrategyRequestBuilder(
        EventProxyStrategyRequestBuilder $eventProxyStrategyRequestBuilder
    )
    {
        $this->eventProxyStrategyRequestBuilder = $eventProxyStrategyRequestBuilder;
    }

}
