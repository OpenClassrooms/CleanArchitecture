<?php

namespace OpenClassrooms\Tests\UseCase\Application\Services\Cache;

use Doctrine\Common\Cache\ArrayCache;
use OpenClassrooms\Cache\Cache\CacheImpl;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class CacheSpy extends CacheImpl
{

    /**
     * @var int
     */
    public $lifeTime;

    /**
     * @var string
     */
    public $namespaceId;

    /**
     * @var bool
     */
    public $saved = false;

    /**
     * @var bool
     */
    public $savedWithNamespace = false;

    /**
     * @var bool
     */
    public $fetched = false;

    /**
     * @var bool
     */
    public $fetchedWithNamespace = false;

    public function __construct()
    {
        parent::__construct(new ArrayCache());
    }

    public function save($id, $data, $lifeTime = null)
    {
        $this->saved = true;
        $this->lifeTime = $lifeTime;

        return parent::save($id, $data, $lifeTime);
    }

    public function saveWithNamespace($id, $data, $namespaceId = null, $lifeTime = null)
    {
        $this->savedWithNamespace = true;
        $this->namespaceId = $namespaceId;

        return parent::saveWithNamespace($id, $data, $namespaceId, $lifeTime);
    }

    public function fetch($id)
    {
        $this->fetched = true;

        return parent::fetch($id);
    }

    public function fetchWithNamespace($id, $namespaceId = null)
    {
        $this->fetchedWithNamespace = true;

        return parent::fetchWithNamespace($id, $namespaceId);

    }
}
