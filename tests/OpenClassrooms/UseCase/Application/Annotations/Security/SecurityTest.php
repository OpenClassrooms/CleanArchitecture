<?php

namespace OpenClassrooms\Tests\UseCase\Application\Annotations\Security;

use Doctrine\Common\Annotations\AnnotationReader;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class SecurityTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var AnnotationReader
     */
    private $reader;

    /**
     * @test
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Roles MUST be defined
     */
    public function WithoutRole_ThrowException()
    {
        $class = new \ReflectionClass(new SecurityClassDummy());
        $this->reader->getMethodAnnotation($class->getMethod('method'), 'security');
    }

    protected function setUp()
    {
        $this->reader = new AnnotationReader();
    }

}
