<?php

namespace OpenClassrooms\Tests\CleanArchitecture\Application\Services\Transaction\Impl;

use OpenClassrooms\CleanArchitecture\Application\Services\Transaction\Impl\TransactionPDOAdapter;
use OpenClassrooms\CleanArchitecture\Application\Services\Transaction\Transaction;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class TransactionPDOAdapterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var Transaction
     */
    private $transaction;

    /**
     * @test
     */
    public function BeginTransaction_ReturnTransaction()
    {
        $transactionBegin = $this->transaction->beginTransaction();
        $this->assertTrue($transactionBegin);
        $this->assertTrue($this->pdo->inTransaction());
    }

    /**
     * @test
     * @expectedException \PDOException
     * @expectedExceptionMessage There is no active transaction
     */
    public function WithoutTransaction_Commit_ThrowException()
    {
        $this->transaction->commit();
    }

    /**
     * @test
     */
    public function Commit()
    {
        $this->transaction->beginTransaction();
        $committed = $this->transaction->commit();
        $this->assertTrue($committed);
        $this->assertFalse($this->pdo->inTransaction());
    }

    /**
     * @test
     * @expectedException \PDOException
     * @expectedExceptionMessage There is no active transaction
     */
    public function WithoutTransaction_RollBack_ThrowException()
    {
        $this->transaction->rollBack();
    }

    /**
     * @test
     */
    public function RollBack()
    {
        $this->transaction->beginTransaction();
        $rollBacked = $this->transaction->rollBack();
        $this->assertTrue($rollBacked);
        $this->assertFalse($this->pdo->inTransaction());
    }


    protected function setUp()
    {
        $this->pdo = new \PDO('sqlite::memory:');
        $this->transaction = new TransactionPDOAdapter();
        $this->transaction->setPdo($this->pdo);
    }
}
