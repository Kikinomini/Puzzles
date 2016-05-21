<?php


namespace Application\Model\Manager;

use Application\Model\Manager\StandardManager;
use Application\Model\Repository\ResourceRepository;
use Application\Model\Resource;

class ResourceManager extends StandardManager
{
    public function __construct(ResourceRepository $repository, Resource $entity = null)
    {
        parent::__construct($repository, $entity);
    }

    /**
     * @param String $name
     * @return null|\Application\Model\Resource
     */
    public function getEntityByName($name)
    {
        return $this->repository->findOneBy(array("name" => $name));
    }
}