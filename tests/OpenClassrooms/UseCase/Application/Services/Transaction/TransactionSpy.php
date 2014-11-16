<?php

namespace OpenClassrooms\Tests\UseCase\Application\Services\Transaction;

use OpenClassrooms\UseCase\Application\Services\Transaction\Transaction;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class TransactionSpy implements Transaction
{

    /**
     * @var bool
     */
    public $transactionBegin = false;

    /**
     * @var bool
     */
    public $committed = false;

    /**
     * @var bool
     */
    public $rollBacked = false;

    /**
     * @return bool
     */
    public function beginTransaction()
    {
        $this->transactionBegin = true;

        return true;
    }

    /**
     * @return bool
     */
    public function isTransactionActive()
    {
        return $this->transactionBegin;
    }

    /**
     * @return bool
     */
    public function commit()
    {
        $this->committed = true;

        return true;
    }

    /**
     * @return bool
     */
    public function rollBack()
    {
        $this->rollBacked = true;

        return true;
    }
}
