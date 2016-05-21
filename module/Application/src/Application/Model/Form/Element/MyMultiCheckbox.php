<?php
/**
 * Created by PhpStorm.
 * User: Silas
 * Date: 30.03.2015
 * Time: 20:24
 */

namespace Application\Model\Form\Element;


use Zend\Form\Element\MultiCheckbox;

class MyMultiCheckbox extends MultiCheckbox{

    /** @var  bool */
    private $showCheckAll;

    public function getInputSpecification()
    {
        $inputSpecification =  parent::getInputSpecification();
        $inputSpecification["required"] = false;
        return $inputSpecification;
    }


    public function __construct($name = null, $options = array())
    {
        $this->showCheckAll = true;
        parent::__construct($name, $options);
    }

    /**
     * @return bool
     */
    public function isShowCheckAll()
    {
        return $this->showCheckAll;
    }

    /**
     * @param bool $showCheckAll
     */
    public function setShowCheckAll($showCheckAll)
    {
        $this->showCheckAll = $showCheckAll;
    }




} 