<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 31.05.16
 * Time: 18:30
 */

namespace BikeStore\Controller;


use Application\Model\Manager\RoleManager;
use Application\Model\Resource;
use Application\Model\Role;
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
		$this->insertDefaultRoleResourceData();
		$this->insertStandardArticles();
	}

	private function insertDefaultRoleResourceData()
	{
		/** @var RoleManager $roleManager */
		$roleManager = $this->getServiceLocator()->get("roleManager");

		$roles = $roleManager->getAllEntities();

		if (count($roles) == 0)
		{
			$guestRole = new Role();
			$guestRole->setName("gast");
			$guestRole->setBeschreibung("Kein aktives oder eingeloggtes Mitglied");

			$userRole = new Role();
			$userRole->setName("user");
			$userRole->setBeschreibung("Normales Mitglied");

			$adminRole = new Role();
			$adminRole->setName("admin");
			$adminRole->setBeschreibung("Admin, darf alles");

			$adminRole->getParents()->add($userRole);
			$userRole->getChildren()->add($adminRole);

			$offlineResource = new Resource();
			$offlineResource->setName("offline");
			$offlineResource->setBeschreibung("alles, was ein nicht eingeloggter User sehen darf");

			$onlineResource = new Resource();
			$onlineResource->setName("online");
			$onlineResource->setBeschreibung("alles, was ein eingeloggter User sehen darf");

			$defaultResource = new Resource();
			$defaultResource->setName("default");
			$defaultResource->setBeschreibung("darf jeder");

			$adminResource = new Resource();
			$adminResource->setName("admin");
			$adminResource->setBeschreibung("darf nur ein Admin");

			$userRole->getResources()->add($onlineResource);
			$userRole->getResources()->add($defaultResource);

			$guestRole->getResources()->add($offlineResource);
			$guestRole->getResources()->add($defaultResource);

			$adminRole->getResources()->add($adminResource);

			$roleManager->save($adminRole);
			$roleManager->save($userRole);
			$roleManager->save($guestRole);

			echo "Default Roles & Resources eingefügt\n";
		}
		else
		{
			echo "Rollen existieren bereits - Überspringe das Einfügen neuer Rollen\n";
		}
	}
	private function insertStandardArticles()
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

		echo "insert Article-Test-Data";
	}
}