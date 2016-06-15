<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 07.06.16
 * Time: 17:18
 */

namespace BikeStore\Form;


use Application\Form\MyForm;
use Application\Model\Form\Element\MyMultiCheckbox;
use BikeStore\Model\Equipment\Frame;
use BikeStore\Model\Manager\Equipment\FrameManager;
use Zend\Form\Element\Number;
use Zend\Form\Element\Submit;
use Zend\Mvc\Controller\Plugin\FlashMessenger;

class BicycleFilterForm extends ArticleFilterForm
{
	public function __construct(FlashMessenger $flashMessenger = null, $name = "", array $options = array())
	{
		parent::__construct($flashMessenger, $name, $options);
		$this->setAttribute("id", "bicycleFilterForm");
	}

	public function addElements()
	{
		parent::addElements();
		
		$frameType = new MyMultiCheckbox("frameType");
		$frameType->setAttribute("class", "");
		$frameType->setValueOptions(array(
			Frame::BIKE_TYPE_RACER => FrameManager::resolveBikeType(Frame::BIKE_TYPE_RACER),
			Frame::BIKE_TYPE_TOURING => FrameManager::resolveBikeType(Frame::BIKE_TYPE_TOURING),
			Frame::BIKE_TYPE_CITY => FrameManager::resolveBikeType(Frame::BIKE_TYPE_CITY),
			Frame::BIKE_TYPE_EBIKE => FrameManager::resolveBikeType(Frame::BIKE_TYPE_EBIKE),
			Frame::BIKE_TYPE_MOUNTAIN => FrameManager::resolveBikeType(Frame::BIKE_TYPE_MOUNTAIN),
		));
		$this->setSendFormOnClickClasses($frameType);
		$this->add($frameType);

		$riderType = new MyMultiCheckbox("riderType");
		$riderType->setAttribute("class", "");
		$riderType->setValueOptions(array(
			Frame::RIDER_TYPE_FEMALE => FrameManager::resolveRiderType(Frame::RIDER_TYPE_FEMALE),
			Frame::RIDER_TYPE_MALE => FrameManager::resolveRiderType(Frame::RIDER_TYPE_MALE),
			Frame::RIDER_TYPE_CHILD => FrameManager::resolveRiderType(Frame::RIDER_TYPE_CHILD),
		));
		$this->setSendFormOnClickClasses($riderType);
		$this->add($riderType);

		$frameHeightMin = new Number("frameHeightMin");
		$frameHeightMin->setLabel("Von:");
		$this->add($frameHeightMin);

		$frameHeightMax = new Number("frameHeightMax");
		$frameHeightMax->setLabel("Bis:");
		$this->add($frameHeightMax);
	}
}