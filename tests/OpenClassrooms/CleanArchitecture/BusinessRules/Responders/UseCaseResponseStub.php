<?php

namespace OpenClassrooms\Tests\CleanArchitecture\BusinessRules\Responders;

use OpenClassrooms\CleanArchitecture\BusinessRules\Responders\UseCaseResponse;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class UseCaseResponseStub implements UseCaseResponse
{
    const VALUE = 'value';

    public $value = self::VALUE;
}
