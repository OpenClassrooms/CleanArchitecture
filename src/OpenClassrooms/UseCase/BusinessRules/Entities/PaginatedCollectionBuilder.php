<?php

namespace OpenClassrooms\UseCase\BusinessRules\Entities;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
abstract class PaginatedCollectionBuilder
{

    /**
     * @var PaginatedCollection
     */
    protected $paginatedCollection;

    /**
     * @return PaginatedCollectionBuilder
     * @codeCoverageIgnore
     */
    abstract public function create();

    /**
     * @return PaginatedCollectionBuilder
     */
    public function withItems(array $items)
    {
        $this->paginatedCollection->setItems($items);

        return $this;
    }

    /**
     * @return PaginatedCollectionBuilder
     */
    public function withItemsPerPage($itemsPerPage)
    {
        $this->paginatedCollection->setItemsPerPage($itemsPerPage);

        return $this;
    }

    /**
     * @return PaginatedCollectionBuilder
     */
    public function withPage($page)
    {
        $this->paginatedCollection->setPage($page);

        return $this;
    }

    /**
     * @return PaginatedCollectionBuilder
     */
    public function withTotalItems($totalItems)
    {
        $this->paginatedCollection->setTotalItems($totalItems);

        return $this;
    }

    /**
     * @return PaginatedCollection
     */
    public function build()
    {
        return $this->paginatedCollection;
    }
}
