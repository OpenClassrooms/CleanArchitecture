<?php

namespace OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Impl\Security;

use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Impl\DTO\ProxyStrategyResponseDTO;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\PreExecuteProxyStrategy;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\ProxyStrategy;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\ProxyStrategyRequest;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\Security\SecurityProxyStrategyRequest;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Responders\ProxyStrategyResponse;
use OpenClassrooms\UseCase\Application\Services\Security\Security;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class SecurityProxyStrategy implements PreExecuteProxyStrategy
{

    /**
     * @var Security
     */
    private $security;

    /**
     * @return string
     */
    public function getType()
    {
        return ProxyStrategy::SECURITY;
    }

    /**
     * @return ProxyStrategyResponse
     */
    public function preExecute(ProxyStrategyRequest $proxyStrategyRequest)
    {
        /** @var SecurityProxyStrategyRequest $proxyStrategyRequest */
        $this->security->checkAccess(
            $proxyStrategyRequest->getAttributes(),
            $proxyStrategyRequest->getObject()
        );

        return new ProxyStrategyResponseDTO();
    }

    public function setSecurity(Security $security)
    {
        $this->security = $security;
    }
}
