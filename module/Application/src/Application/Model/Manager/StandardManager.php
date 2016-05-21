<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 24.01.15
 * Time: 20:40
 */

namespace Application\Model\Manager;


use Application\Model\Repository\StandardRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

class StandardManager
{
	/** @var  StandardRepository */
	protected $repository;

	protected $entity;

	public function __construct(StandardRepository $repository, $entity = null)
	{
		$this->repository = $repository;
		$this->entity = $entity;
	}

	/**
	 * @return mixed
	 */
	public function getEntity()
	{
		return $this->entity;
	}

	/**
	 * @param mixed $entity
	 */
	public function setEntity($entity)
	{
		$this->entity = $entity;
	}
    
    public function getMetadata()
    {
        return $this->repository->getMetadata();
    }

    private function codeSql($string)
    {
        $string = str_replace("\\", "\\\\\\\\", $string);
        $string = str_replace("'", "\\\\\\'", $string);
        $string = str_replace("\"", "\\\\\\\"", $string);
        return $string;
    }

    public function getSqlDump()
    {
        /** @var ClassMetadata $metadata */
        $metadata = $this->getMetadata();
        $tableName = $metadata->getTableName();
        $fieldNames = $metadata->getColumnNames();
        $entities = $this->getAllEntities(false);

        $associations = $metadata->getAssociationMappings();

        foreach ($associations as $association)
        {
            if (isset($association["joinColumns"])) //spalte gehört zur Tabelle
            {
                foreach ($association["joinColumns"] as $joinColumn)
                {
                    $fieldNames[] = $joinColumn["name"];
                }
            }
        }

        $sql = "SET @table_name := \"".$this->codeSql($tableName)."\";\n";
        $n = 0;
        foreach($fieldNames as $fieldName)
        {
            $sql .= "SET @field_name_".$n." := \"".$this->codeSql($fieldName)."\";\n";
            $n++;
        }

        $sql .= "\n\n-- ----------------------------------------------------------------------------\n\n\n";

        if (is_array($entities) && count($entities) > 0) {

            $sql .= "SET @sql := CONCAT ('INSERT INTO ', @table_name, ' (";
            for ($i = 0; $i < $n; $i++) {
                $sql .= "',@field_name_" . $i.", '";
                if ($i < $n - 1) {
                    $sql .= ", ";
                }
            }
            $sql .= ") VALUES ";

            /** @var  array $entity */
            foreach ($entities as $entity) {
                $sql .= "\n(";
                foreach ($entity as $value) {
                    if ($value instanceof \DateTime) {
                        $value = $value->format("Y-m-d H:i:s");
                    }
                    $sql .= "\"" . $this->codeSql($value) . "\",";
                }
                $sql[strlen($sql) - 1] = ")";
                $sql .= ",";
            }
            $sql[strlen($sql) - 1] = "'";
            $sql .= ");\n\n";
            $sql .= "PREPARE stmt FROM @sql;\n";
            $sql .= "EXECUTE stmt;\n";
            $sql .= "DEALLOCATE PREPARE stmt;\n\n\n";
        }
        return $sql;
    }

	/**
	 * @param object $entity
	 * @return object
	 */
	protected function selectCorrectEntity($entity)
	{
		if (!is_object($entity) && is_object($this->entity))
		{
			$entity = $this->entity;
		}
		return $entity;
	}

	public function getAllEntities($asEntities = true)
	{
        return $this->repository->findAll($asEntities);
	}

	public function getEntityById($id)
	{
		$this->entity = $this->repository->find($id);
		return $this->entity;
	}

	public function save($entity = null, $flush = true)
	{
		$entity = $this->selectCorrectEntity($entity);
		$this->repository->persist($entity, $flush);
	}

    public function emFlush($entity = NULL)
    {
        $this->repository->emFlush($entity);
    }

	public function removeEntity($entity = null)
	{
		$entity = $this->selectCorrectEntity($entity);
		$this->repository->remove($entity);
	}
    public function findBy($args, $orderBy = null, $limit = null, $offset = null)
    {
        return $this->repository->findBy($args, $orderBy, $limit, $offset);
    }
	public function findOneBy($args, $orderBy = null)
	{
		return $this->repository->findOneBy($args, $orderBy);
	}
}