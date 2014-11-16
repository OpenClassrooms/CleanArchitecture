<?php

namespace OpenClassrooms\Tests\UseCase\BusinessRules\Responders\Doubles;

use OpenClassrooms\UseCase\BusinessRules\Responders\UseCaseResponse;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class UseCaseResponseStub implements UseCaseResponse
{
    const VALUE = 'value';

    public $value = self::VALUE;

}
