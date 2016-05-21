<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 24.01.15
 * Time: 20:32
 */

namespace Application\Model\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query;

class StandardRepository extends EntityRepository
{
	public function persist($entityObject, $flush = true)
	{
		$this->_em->persist($entityObject);
		if ($flush)
		{
			$this->_em->flush();
		}
	}

	public function remove($entityObject, $flush = true)
	{
		$this->_em->remove($entityObject);
		if ($flush)
		{
			$this->_em->flush();
		}
	}
	public function merge($entityObject, $flush = true)
	{
		$this->_em->merge($entityObject);
		if ($flush)
		{
			$this->_em->flush();
		}
	}
    public function emFlush($entity = NULL)
    {
        $this->_em->flush($entity);
    }

    public function getMetadata()
    {
        return $this->_em->getMetadataFactory()->getMetadataFor($this->_entityName);
    }

    public function findAll($asEntities = true)
    {
        if ($asEntities) {
            return parent::findAll();
        }
        else
        {
            /** @var ClassMetadata $metadata */
            $metadata = $this->getMetadata();
            $columnNames = $metadata->getColumnNames();
            $associations = $metadata->getAssociationMappings();

            foreach ($associations as $association)
            {
                if (isset($association["joinColumns"])) //spalte gehört zur Tabelle
                {
                    foreach ($association["joinColumns"] as $joinColumn)
                    {
                        $columnNames[] = $joinColumn["name"];
                    }
                }
            }

            $rsm = new Query\ResultSetMapping();
            $select = "";
            foreach ($columnNames as $column)
            {
                $rsm->addScalarResult($column, $column);
                $select .= "".$column.", ";
            }
            $select[strlen($select)-2] = " ";
            $res = $this->_em->createNativeQuery('SELECT '.$select.' FROM '.$metadata->getTableName().' ', $rsm)->getResult(Query::HYDRATE_ARRAY);
            return $res;
        }
    }
}