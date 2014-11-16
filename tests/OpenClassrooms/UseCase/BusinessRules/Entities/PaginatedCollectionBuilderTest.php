<?php

namespace OpenClassrooms\Tests\UseCase\BusinessRules\Entities;

use OpenClassrooms\UseCase\Application\Entity\PaginatedCollectionBuilderImpl;
use OpenClassrooms\UseCase\Application\Entity\PaginatedCollectionImpl;
use OpenClassrooms\UseCase\BusinessRules\Entities\PaginatedCollectionBuilder;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class PaginatedCollectionBuilderTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var PaginatedCollectionBuilder
     */
    private $builder;

    /**
     * @test
     */
    public function WithoutTotalItems_ThrowException()
    {
        $paginatedCollection = $this->builder->create()->build();
        $this->assertEquals(new PaginatedCollectionImpl(), $paginatedCollection);
    }

    /**
     * @test
     */
    public function ReturnPaginatedCollection()
    {
        $expectedItems = array('item1', 'item2', 'item3');
        $expectedItemsPerPage = 2;
        $expectedPage = 2;
        $paginatedCollection = $this->builder
            ->create()
            ->withItems($expectedItems)
            ->withItemsPerPage($expectedItemsPerPage)
            ->withPage($expectedPage)
            ->withTotalItems(count($expectedItems))
            ->build();

        $this->assertEquals($expectedItems, $paginatedCollection->getItems());
        $this->assertEquals($expectedItemsPerPage, $paginatedCollection->getItemsPerPage());
        $this->assertEquals($expectedPage, $paginatedCollection->getPage());
        $this->assertEquals(count($expectedItems), $paginatedCollection->getTotalItems());
        $this->assertEquals(2, $paginatedCollection->getTotalPages());
    }

    protected function setUp()
    {
        $this->builder = new PaginatedCollectionBuilderImpl();
    }
}
