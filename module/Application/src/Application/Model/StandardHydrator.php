<?php
/**
 * Created by PhpStorm.
 * User: Silas
 * Date: 20.06.2015
 * Time: 14:48
 */

namespace Application\Model;


use Zend\Stdlib\Hydrator\HydratorInterface;

class StandardHydrator implements HydratorInterface{

    private $extractOptions;
    private $hydrateOptions;

    public function __construct()
    {
        $this->extractOptions = array();
        $this->hydrateOptions = array();
    }

    /**
     * @return array
     */
    public function getExtractOptions()
    {
        return $this->extractOptions;
    }

    /**
     * @param array $extractOptions
     */
    public function setExtractOptions($extractOptions)
    {
        $this->extractOptions = $extractOptions;
    }

    /**
     * @return array
     */
    public function getHydrateOptions()
    {
        return $this->hydrateOptions;
    }

    /**
     * @param array $hydrateOptions
     */
    public function setHydrateOptions($hydrateOptions)
    {
        $this->hydrateOptions = $hydrateOptions;
    }



    /**
     * Extract values from an object
     *
     * @param  object $object
     * @return array
     */
    public function extract($object)
    {
        $data = array();
        foreach($this->extractOptions as $option)
        {
            if ($option["type"] == "normal")
            {
                $functionName = "get".$option["objectKey"];
                $data[$option["arrayKey"]] = $object->$functionName();
            }
        }
        return $data;
    }

    /**
     * Hydrate $object with the provided $data.
     *
     * @param  array $data
     * @param  object $object
     * @return object
     */
    public function hydrate(array $data, $object)
    {
        foreach($this->hydrateOptions as $option)
        {
            if ($option["type"] == "normal")
            {
                $functionName = "set".$option["objectKey"];
                $object->$functionName($data[$option["arrayKey"]]);
            }
        }
        return $object;
    }

} 