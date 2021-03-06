<?php

namespace OpenClassrooms\UseCase\Application\Services\Transaction;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
interface Transaction
{
    /**
     * @return bool
     */
    public function beginTransaction();

    /**
     * @return bool
     */
    public function isTransactionActive();

    /**
     * @return bool
     */
    public function commit();

    /**
     * @return bool
     */
    public function rollBack();
}
