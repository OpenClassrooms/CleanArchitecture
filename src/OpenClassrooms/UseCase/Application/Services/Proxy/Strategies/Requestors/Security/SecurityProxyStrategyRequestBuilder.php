<?php

namespace OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\Security;

use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\Security\Exceptions\AttributesMustBeDefinedException;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
interface SecurityProxyStrategyRequestBuilder
{
    /**
     * @return SecurityProxyStrategyRequestBuilder
     */
    public function create();

    /**
     * @return SecurityProxyStrategyRequestBuilder
     */
    public function withAttributes($attributes);

    /**
     * @return SecurityProxyStrategyRequestBuilder
     */
    public function withObject($object);

    /**
     * @return SecurityProxyStrategyRequest
     * @throws AttributesMustBeDefinedException
     */
    public function build();
}
