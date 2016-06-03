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
		$saddle->setPrice(1.5);
		$saddle->setName("Sattel");
		$articleManager->save($saddle);

		$saddleBar = new SaddleBar();
		$saddle->setPrice(3);
		$saddleBar->setName("Sattelstange");
		$saddleBar->setDiameter(27);
		$saddleBar->setLength(40);
		$articleManager->save($saddleBar);

		$handlebars = new Handlebars();
		$handlebars->setPrice(4.5);
		$handlebars->setName("Lenker");
		$articleManager->save($handlebars);

		$bell = new Bell();
		$bell->setPrice(6);
		$bell->setName("Klingel");
		$articleManager->save($bell);

		$brake = new Brake();
		$brake->setPrice(7.5);
		$brake->setName("Bremse");
		$articleManager->save($brake);

		$coat = new Coat();
		$coat->setPrice(9);
		$coat->setName("Mantel");
		$articleManager->save($coat);

		$dynamo = new Dynamo();
		$dynamo->setPrice(11.5);
		$dynamo->setName("Dynamo");
		$articleManager->save($dynamo);

		$frontWheel = new FrontWheel();
		$frontWheel->setPrice(13);
		$frontWheel->setName("Vorderrad");
		$articleManager->save($frontWheel);

		$gearShift = new GearShift();
		$gearShift->setPrice(14.5);
		$gearShift->setName("Gangschaltung");
		$articleManager->save($gearShift);

		$light = new Light();
		$light->setPrice(16);
		$light->setName("Licht");
		$articleManager->save($light);

		$mudGuard = new MudGuard();
		$mudGuard->setPrice(17.5);
		$mudGuard->setName("Schutzblech");
		$articleManager->save($mudGuard);

		$pannierRack = new PannierRack();
		$pannierRack->setPrice(19);
		$pannierRack->setName("Gepäckträger");
		$articleManager->save($pannierRack);

		$pedal = new Pedal();
		$pedal->setPrice(20.5);
		$pedal->setName("Pedal");
		$articleManager->save($pedal);

		$rearWheel = new RearWheel();
		$rearWheel->setPrice(22);
		$rearWheel->setName("Hinterrad");
		$articleManager->save($rearWheel);

		$tube = new Tube();
		$tube->setPrice(23.5);
		$tube->setName("Schlauch");
		$articleManager->save($tube);

		$frame = new Frame();
		$frame->setPrice(25);
		$frame->setName("Rahmen");
		$articleManager->save($frame);

		$bicycle = new Bicycle();
		$bicycle->setPrice(26.5);
		$bicycle->setName("Fahrrad");
		$bicycle->setQuickDescription("Standardfahrrad");
		$bicycle->setDescription("Hier könnte ihre Beschreibung stehen");
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

		echo "insert Article-Test-Data successfull";
	}
}