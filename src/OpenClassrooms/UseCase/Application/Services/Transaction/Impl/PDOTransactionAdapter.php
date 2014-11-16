<?php

namespace OpenClassrooms\UseCase\Application\Services\Transaction\Impl;

use OpenClassrooms\UseCase\Application\Services\Transaction\Transaction;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class PDOTransactionAdapter implements Transaction
{

    /**
     * @var \PDO
     */
    protected $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @return bool
     */
    public function beginTransaction()
    {
        return $this->isTransactionActive() ? true : $this->pdo->beginTransaction();
    }

    /**
     * @return bool
     */
    public function isTransactionActive()
    {
        return $this->pdo->inTransaction();
    }

    /**
     * @return bool
     */
    public function commit()
    {
        return $this->pdo->commit();
    }

    /**
     * @return bool
     */
    public function rollBack()
    {
        return $this->pdo->rollBack();
    }
}
