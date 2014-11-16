<?php

namespace OpenClassrooms\UseCase\BusinessRules\Responders;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
abstract class PaginatedUseCaseResponseBuilder
{

    /**
     * @var AbstractPaginatedUseCaseResponse
     */
    protected $paginatedUseCaseResponse;

    /**
     * @return PaginatedUseCaseResponseBuilder
     * @codeCoverageIgnore
     */
    abstract public function create();

    /**
     * @return PaginatedUseCaseResponseBuilder
     */
    public function withItems(array $items)
    {
        $this->paginatedUseCaseResponse->setItems($items);

        return $this;
    }

    /**
     * @return PaginatedUseCaseResponseBuilder
     */
    public function withItemsPerPage($itemsPerPage)
    {
        $this->paginatedUseCaseResponse->setItemsPerPage($itemsPerPage);

        return $this;
    }

    /**
     * @return PaginatedUseCaseResponseBuilder
     */
    public function withPage($page)
    {
        $this->paginatedUseCaseResponse->setPage($page);

        return $this;
    }

    /**
     * @return PaginatedUseCaseResponseBuilder
     */
    public function withTotalItems($totalItems)
    {
        $this->paginatedUseCaseResponse->setTotalItems($totalItems);

        return $this;
    }

    /**
     * @return AbstractPaginatedUseCaseResponse
     */
    public function build()
    {
        return $this->paginatedUseCaseResponse;
    }
}
