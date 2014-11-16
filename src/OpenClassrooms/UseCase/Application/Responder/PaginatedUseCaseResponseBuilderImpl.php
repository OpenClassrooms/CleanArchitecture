<?php

namespace OpenClassrooms\UseCase\Application\Responder;

use OpenClassrooms\UseCase\BusinessRules\Responders\PaginatedUseCaseResponseBuilder;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class PaginatedUseCaseResponseBuilderImpl extends PaginatedUseCaseResponseBuilder
{
    /**
     * @return PaginatedUseCaseResponseBuilder
     */
    public function create()
    {
        $this->paginatedUseCaseResponse = new PaginatedUseCaseResponseImpl();

        return $this;
    }
}
