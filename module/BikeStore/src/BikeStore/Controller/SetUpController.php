<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 31.05.16
 * Time: 18:30
 */

namespace BikeStore\Controller;


use BikeStore\Model\Bicycle;
use BikeStore\Model\Equipment\Bell;
use BikeStore\Model\Equipment\Brake;
use BikeStore\Model\Equipment\Coat;
use BikeStore\Model\Equipment\Dynamo;
use BikeStore\Model\Equipment\Frame;
use BikeStore\Model\Equipment\FrontWheel;
use BikeStore\Model\Equipment\GearShift;
use BikeStore\Model\Equipment\Handlebars;
use BikeStore\Model\Equipment\Light;
use BikeStore\Model\Equipment\MudGuard;
use BikeStore\Model\Equipment\PannierRack;
use BikeStore\Model\Equipment\Pedal;
use BikeStore\Model\Equipment\RearWheel;
use BikeStore\Model\Equipment\Saddle;
use BikeStore\Model\Equipment\SaddleBar;
use BikeStore\Model\Equipment\Tube;
use BikeStore\Model\Manager\ArticleManager;
use BikeStore\Model\Manager\EquipmentManager;
use Zend\Mvc\Controller\AbstractActionController;

class SetUpController extends AbstractActionController
{
	public function insertTestDataAction()
	{
		/** @var ArticleManager $articleManager */
		$articleManager = $this->getServiceLocator()->get("BikeStore.articleManager");

			$saddle = new Saddle();
			$articleManager->save($saddle);

			$saddleBar = new SaddleBar();
			$articleManager->save($saddleBar);

			$handlebars = new Handlebars();
			$articleManager->save($handlebars);

			$bell = new Bell();
			$articleManager->save($bell);

			$brake = new Brake();
			$articleManager->save($brake);

			$coat = new Coat();
			$articleManager->save($coat);

			$dynamo = new Dynamo();
			$articleManager->save($dynamo);

			$frontWheel = new FrontWheel();
			$articleManager->save($frontWheel);

			$gearShift = new GearShift();
			$articleManager->save($gearShift);

			$light = new Light();
			$articleManager->save($light);

			$mudGuard = new MudGuard();
			$articleManager->save($mudGuard);

			$pannierRack = new PannierRack();
			$articleManager->save($pannierRack);

			$pedal = new Pedal();
			$articleManager->save($pedal);

			$rearWheel = new RearWheel();
			$articleManager->save($rearWheel);

			$tube = new Tube();
			$articleManager->save($tube);

			$frame = new Frame();
			$articleManager->save($frame);

			$bicycle = new Bicycle();
			$bicycle->setBell($bell);
			$bicycle->setFrontBrake($brake);
			$bicycle->setRearBrake($brake);
			$bicycle->setFrontCoat($coat);
			$bicycle->setRearCoat($coat);
			$bicycle->setDynamo($dynamo);
			$bicycle->setFrame($frame);
			$bicycle->setFrontWheel($frontWheel);
			$bicycle->setRearWheel($rearWheel);
			$bicycle->setPannierRack($pannierRack);
			$bicycle->setPedal($pedal);
			$bicycle->setFrontTube($tube);
			$bicycle->setRearTube($tube);
			$bicycle->setLight($light);
			$bicycle->setMudGuard($mudGuard);
			$bicycle->setGearShift($gearShift);
			$bicycle->setSaddle($saddle);
			$bicycle->setSaddleBar($saddleBar);
			$bicycle->setHandlebars($handlebars);

			$articleManager->save($bicycle);
	}
}