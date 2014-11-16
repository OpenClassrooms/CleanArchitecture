<?php

namespace OpenClassrooms\Tests\UseCase\BusinessRules\Responders;

use OpenClassrooms\UseCase\Application\Responder\PaginatedUseCaseResponseBuilderImpl;
use OpenClassrooms\UseCase\BusinessRules\Responders\PaginatedUseCaseResponseBuilder;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class PaginatedUseCaseResponseBuilderTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var PaginatedUseCaseResponseBuilder
     */
    private $builder;

    /**
     * @test
     */
    public function WithoutItemsPerPage_Build_ReturnResponse()
    {
        $paginatedUseCaseResponse = $this->builder
            ->create()
            ->withItems(array())
            ->withTotalItems(100)
            ->build();
        $this->assertEquals(1, $paginatedUseCaseResponse->getPage());
        $this->assertEquals(1, $paginatedUseCaseResponse->getTotalPages());
    }

    /**
     * @test
     */
    public function WithItemsPerPageAndTotalItems_ReturnResponse()
    {
        $paginatedUseCaseResponse = $this->builder
            ->create()
            ->withItems(array())
            ->withItemsPerPage(10)
            ->withTotalItems(98)
            ->build();

        $this->assertEquals(1, $paginatedUseCaseResponse->getPage());
        $this->assertEquals(10, $paginatedUseCaseResponse->getTotalPages());
    }

    /**
     * @test
     */
    public function WithItemsPerPageSuperiorToTotalItems_ReturnResponse()
    {
        $paginatedUseCaseResponse = $this->builder
            ->create()
            ->withItems(array())
            ->withItemsPerPage(10)
            ->withTotalItems(9)
            ->build();

        $this->assertEquals(1, $paginatedUseCaseResponse->getPage());
    }

    /**
     * @test
     */
    public function SecondPage_ReturnResponse()
    {
        $paginatedUseCaseResponse = $this->builder
            ->create()
            ->withItems(array())
            ->withItemsPerPage(10)
            ->withPage(2)
            ->withTotalItems(98)
            ->build();

        $this->assertEquals(2, $paginatedUseCaseResponse->getPage());
        $this->assertEquals(10, $paginatedUseCaseResponse->getTotalPages());
    }

    /**
     * @test
     */
    public function LastPage_ReturnResponse()
    {
        $paginatedUseCaseResponse = $this->builder
            ->create()
            ->withItems(array())
            ->withItemsPerPage(10)
            ->withPage(10)
            ->withTotalItems(98)
            ->build();

        $this->assertEquals(10, $paginatedUseCaseResponse->getPage());
    }

    /**
     * @test
     */
    public function ReturnResponse()
    {
        $paginatedUseCaseResponse = $this->builder
            ->create()
            ->withItems(array())
            ->withItemsPerPage(10)
            ->withPage(10)
            ->withTotalItems(98)
            ->build();

        $this->assertEquals(array(), $paginatedUseCaseResponse->getItems());
        $this->assertEquals(10, $paginatedUseCaseResponse->getItemsPerPage());
        $this->assertEquals(10, $paginatedUseCaseResponse->getPage());
        $this->assertEquals(98, $paginatedUseCaseResponse->getTotalItems());
        $this->assertEquals(10, $paginatedUseCaseResponse->getTotalPages());
    }

    protected function setUp()
    {
        $this->builder = new PaginatedUseCaseResponseBuilderImpl();
    }
}
