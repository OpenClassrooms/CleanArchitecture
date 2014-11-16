<?php

namespace OpenClassrooms\UseCase\Application\Services\Proxy\UseCases;

use Doctrine\Common\Annotations\Annotation;
use Doctrine\Common\Annotations\Reader;
use OpenClassrooms\UseCase\Application\Annotations\Cache;
use OpenClassrooms\UseCase\Application\Annotations\Event;
use OpenClassrooms\UseCase\Application\Annotations\Security;
use OpenClassrooms\UseCase\Application\Annotations\Transaction;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\ProxyStrategy;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\ProxyStrategyBag;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\ProxyStrategyBagFactory;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\ProxyStrategyRequestFactory;
use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCase;
use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\UseCase\BusinessRules\Responders\UseCaseResponse;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
abstract class UseCaseProxy implements UseCase
{

    /**
     * @var array
     */
    public static $strategyOrder = array(
        1 => ProxyStrategy::SECURITY,
        2 => ProxyStrategy::CACHE,
        3 => ProxyStrategy::TRANSACTION,
        4 => ProxyStrategy::EVENT
    );

    /**
     * @var Reader
     */
    protected $reader;

    /**
     * @var ProxyStrategyBagFactory
     */
    protected $proxyStrategyBagFactory;

    /**
     * @var ProxyStrategyRequestFactory
     */
    protected $proxyStrategyRequestFactory;

    /**
     * @var UseCase
     */
    protected $useCase;

    /**
     * @var UseCaseRequest
     */
    protected $request;

    /**
     * @var ProxyStrategyBag[]
     */
    private $strategies = array();

    /**
     * @var bool
     */
    private $stopExecution = false;

    /**
     * @var UseCaseResponse
     */
    private $response;

    /**
     * @return UseCaseResponse
     */
    public function execute(UseCaseRequest $useCaseRequest)
    {
        $this->request = $useCaseRequest;
        $this->buildStrategies();

        try {
            $response = $this->preExecute();

            if ($this->stopExecution) {
                $this->response = $response;
            } else {
                $this->response = $this->useCase->execute($useCaseRequest);
            }

            $this->postExecute();

            return $this->response;

        } catch (\Exception $e) {
            $this->onException($e);
            throw $e;
        }
    }

    private function buildStrategies()
    {
        $annotations = $this->getAnnotations();
        foreach ($annotations as $annotation) {
            if ($annotation instanceof Security
                || $annotation instanceof Cache
                || $annotation instanceof Transaction
                || $annotation instanceof Event
            ) {
                $proxyStrategyBag = $this->proxyStrategyBagFactory->make($annotation);
                $this->strategies[$proxyStrategyBag->getType()] = $proxyStrategyBag;
            }
        }
        $this->sortStrategies();
    }

    /**
     * @return Annotation[]
     */
    private function getAnnotations()
    {
        return $this->reader->getMethodAnnotations(new \ReflectionMethod($this->useCase, 'execute'));
    }

    private function sortStrategies()
    {
        uksort(
            $this->strategies,
            function ($s1, $s2) {
                return array_search($s1, UseCaseProxy::$strategyOrder) > array_search(
                    $s2,
                    UseCaseProxy::$strategyOrder
                );
            }
        );
    }

    /**
     * @return array
     */
    private function preExecute()
    {
        $this->stopExecution = false;
        $data = null;

        foreach ($this->strategies as $strategy) {
            if ($strategy->isPreExecute() && $this->transactionCanBegin($strategy)) {

                $request = $this->proxyStrategyRequestFactory->createPreExecuteRequest(
                    $strategy->getAnnotation(),
                    $this->useCase,
                    $this->request
                );

                $strategyResponse = $strategy->preExecute($request);

                if ($strategyResponse->stopExecution()) {
                    $this->stopExecution = true;
                    unset($this->strategies[ProxyStrategy::TRANSACTION]);
                    $data = $strategyResponse->getData();
                }
            }
        }

        return $data;
    }

    /**
     * @return bool
     */
    private function transactionCanBegin(ProxyStrategyBag $strategy)
    {
        return !($this->stopExecution && ProxyStrategy::TRANSACTION === $strategy->getType());
    }

    private function postExecute()
    {
        foreach ($this->strategies as $strategy) {
            if ($strategy->isPostExecute()) {
                $request = $this->proxyStrategyRequestFactory->createPostExecuteRequest(
                    $strategy->getAnnotation(),
                    $this->useCase,
                    $this->request,
                    $this->response
                );
                $strategy->postExecute($request);
            }
        }
    }

    private function onException(\Exception $exception)
    {
        foreach ($this->strategies as $strategy) {
            if ($strategy->isOnException()) {
                $request = $this->proxyStrategyRequestFactory->createOnExceptionRequest(
                    $strategy->getAnnotation(),
                    $this->useCase,
                    $this->request,
                    $exception
                );
                $strategy->onException($request);
            }
        }
    }

    /**
     * @return UseCase
     */
    public function getUseCase()
    {
        return $this->useCase;
    }

    public function setUseCase(UseCase $useCase)
    {
        $this->useCase = $useCase;
    }
}
