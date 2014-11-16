<?php

namespace OpenClassrooms\UseCase\Application\Annotations;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 * @Annotation
 */
class Cache
{

    /**
     * @var string
     */
    public $namespacePrefix;

    /**
     * @var string
     */
    public $namespaceAttribute;

    /**
     * @var int
     */
    public $lifetime;

    /**
     * @return string
     */
    public function getNamespaceAttribute()
    {
        return $this->namespaceAttribute;
    }

    /**
     * @return string
     */
    public function getNamespacePrefix()
    {
        return $this->namespacePrefix;
    }

    /**
     * @return int
     */
    public function getLifetime()
    {
        return $this->lifetime;
    }
}
