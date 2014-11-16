<?php

namespace OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Impl\DTO;

use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Responders\ProxyStrategyResponse;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class ProxyStrategyResponseDTO implements ProxyStrategyResponse
{

    /**
     * @var string
     */
    public $data;

    /**
     * @var bool
     */
    public $stopExecution = false;

    public function __construct($data = null, $stopExecution = false)
    {
        $this->data = $data;
        $this->stopExecution = $stopExecution;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return bool
     */
    public function stopExecution()
    {
        return $this->stopExecution;
    }

}
