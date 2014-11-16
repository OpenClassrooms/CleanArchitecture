<?php

namespace OpenClassrooms\UseCase\BusinessRules\Responders;

use OpenClassrooms\UseCase\BusinessRules\Entities\PaginatedCollection;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
abstract class AbstractPaginatedUseCaseResponseFactory implements PaginatedUseCaseResponseFactory
{

    /**
     * @var PaginatedUseCaseResponseBuilder
     */
    private $paginatedUseCaseResponseBuilder;

    /**
     * @return AbstractPaginatedUseCaseResponse
     */
    public function createFromPaginatedCollection(PaginatedCollection $paginatedCollection)
    {
        return $this->paginatedUseCaseResponseBuilder->create()
            ->withItems($paginatedCollection->getItems())
            ->withItemsPerPage($paginatedCollection->getItemsPerPage())
            ->withPage($paginatedCollection->getPage())
            ->withTotalItems($paginatedCollection->getTotalItems())
            ->build();
    }

    public function setPaginatedUseCaseResponseBuilder(PaginatedUseCaseResponseBuilder $paginatedUseCaseResponseBuilder)
    {
        $this->paginatedUseCaseResponseBuilder = $paginatedUseCaseResponseBuilder;
    }
}
