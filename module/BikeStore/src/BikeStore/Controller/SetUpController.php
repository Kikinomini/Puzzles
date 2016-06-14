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
use BikeStore\Model\Article;
use BikeStore\Model\Bicycle;
use BikeStore\Model\EBike;
use BikeStore\Model\Equipment\Battery;
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
use BikeStore\Model\Manager\BicycleManager;
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

		if(count($roles) == 0)
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

	private function initArticle(Article $article, $lfdNr = 0, $price = -1)
	{
		if($price < 0)
		{
			$price = $lfdNr * 15;
		}
		$reflectionClass = new \ReflectionClass($article);
		$article->setName($reflectionClass->getShortName() . " " . $lfdNr);
		$article->setImageName("testImage.php?t=" . $article->getName());
		$article->setPrice($price);
		$article->setQuickDescription($reflectionClass->getName());
		$article->setDescription(nl2br($reflectionClass->getDocComment()));

		return $article;
	}

	private function insertStandardArticles()
	{
		$numberArticles = 10;

		/** @var ArticleManager $articleManager */
		$articleManager = $this->getServiceLocator()->get("BikeStore.articleManager");

		$articleTypes = array(
			new Battery(), //0
			new Bell(),
			new Brake(), //2
			new Coat(),
			new Dynamo(), //4
			new Frame(),
			new FrontWheel(), // 6
			new GearShift(),
			new Handlebars(),
			new Light(), //9
			new MudGuard(),
			new PannierRack(), //11
			new Pedal(),
			new RearWheel(),
			new Saddle(), //14
			new SaddleBar(),
			new Tube(), // 16
			new Bicycle(),
			new EBike(),
		);

		$articles = array();
		$numberArticleTypes = count($articleTypes);
		for($i = 0; $i < $numberArticleTypes; $i++)
		{
			$articles[$i] = array();
			for($l = 0; $l < $numberArticles; $l++)
			{
				$article = clone $articleTypes[$i];
				$article = $this->initArticle($article, $l, $i + $l * 15);

				switch($i)
				{
					case 0:
					{
						/** @var Battery $article */
						$article->setBatteryTime($l * M_2_PI);
						$article->setChargingTime($l * M_2_SQRTPI);
						break;
					}
					case 1:
					{
						/** @var Bell $article */
//						$article->se
						break;
					}
					case 2:
					{
						/** @var Brake $article */
						$article->setBrakeType(($l % 2) + 1);
						break;
					}
					case 3:
					{
						/** @var Coat $article */
						$article->setProfile("stringProfil " . $l);
						$article->setSize(24 + 2 * $l);
						break;
					}
					case 4:
					{
						/** @var Dynamo $article */
						$article->setType(($l % 3) + 1);
						break;
					}
					case 5:
					{
						/** @var Frame $article */
						$article->setBackShocker(($l % 2) == 0);
						$article->setBikeType(($l % 5) + 1);
						$article->setFrameSize(56 + 2 * $l);
						$article->setFrontShocker(($l % 2) == 1);
						$article->setRiderType(($l % 3) + 1);
						break;
					}
					case 6:
					{
						/** @var FrontWheel $article */
						$article->setSize(24 + 2 * $l);
						break;
					}
					case 7:
					{
						/** @var GearShift $article */
						$article->setType(($l % 2) + 1);
						$article->setNumberBackGears($l);
						$article->setNumberFrontGears($l);
						break;
					}
					case 8:
					{
						/** @var Handlebars $article */
						$article->setDiameter(10 + 1.5 * $l);
						$article->setLength(35+2.7*$l);
						break;
					}
					case 9:
					{
						/** @var Light $article */
						$article->setType($l%2+1);
						$article->setIsBatteryPowered($l%2 == 0);
						break;
					}
					case 10:
					{
						/** @var MudGuard $article */
						$article->setSize(24+2*$l);
						break;
					}
					case 11:
					{
						/** @var PannierRack $article */
//						$article->set;
						break;
					}
					case 12:
					{
						/** @var Pedal $article */
						$article->setPedalType($l % 4 + 1);
						break;
					}
					case 13:
					{
						/** @var RearWheel $article */
						$article->setWheelSize(24 + 2 * $l);
						$article->setBackPedalBrake($l%2 == 0);
						$article->setGearType($l%2+1);
						break;
					}
					case 14:
					{
						/** @var Saddle $article */
						$article->setType($l % 2 + 1);
						$article->setMaterial($l%3+1);
						break;
					}
					case 15:
					{
						/** @var SaddleBar $article */
						$article->setLength(35+1.4*$l);
						$article->setDiameter(10+2.4*$l);
						break;
					}
					case 16:
					{
						/** @var Tube $article */
						$article->setWheelSize(24 + 1.9 * $l);
						break;
					}
					case 18:
					{
						/** @var EBike $article */
						$article->setBattery($articles[0][$l]);
					}
					case 17:
					{
						/** @var Bicycle $article */
						$article->setBell($articles[1][$l]);
						$article->setFrontBrake($articles[2][$l]);
						$article->setRearBrake($articles[2][$numberArticles-$l-1]);
						$article->setFrontCoat($articles[3][$l]);
						$article->setRearCoat($articles[3][$numberArticles-$l-1]);
						$article->setDynamo($articles[4][$l]);
						$article->setFrame($articles[5][$l]);
						$article->setFrontWheel($articles[6][$l]);
						$article->setGearShift($articles[7][$l]);
						$article->setHandlebars($articles[8][$l]);
						$article->setLight($articles[9][$l]);
						$article->setMudGuard($articles[10][$l]);
						$article->setPannierRack($articles[11][$l]);
						$article->setPedal($articles[12][$l]);
						$article->setRearWheel($articles[13][$l]);
						$article->setSaddle($articles[14][$l]);
						$article->setSaddleBar($articles[15][$l]);
						$article->setFrontTube($articles[16][$l]);
						$article->setRearTube($articles[16][$numberArticles - $l-1]);
						break;
					}
				}

				$articles[$i][$l] = $article;
				$articleManager->save($article);
			}
		}

//		$saddle = new Saddle();
//		$saddle->setPrice(1.5);
//		$saddle->setName("Sattel");
//		$articleManager->save($saddle);
//
//		$saddleBar = new SaddleBar();
//		$saddle->setPrice(3);
//		$saddleBar->setName("Sattelstange");
//		$saddleBar->setDiameter(27);
//		$saddleBar->setLength(40);
//		$articleManager->save($saddleBar);
//
//		$handlebars = new Handlebars();
//		$handlebars->setPrice(4.5);
//		$handlebars->setName("Lenker");
//		$articleManager->save($handlebars);
//
//		$bell = new Bell();
//		$bell->setPrice(6);
//		$bell->setName("Klingel");
//		$articleManager->save($bell);
//
//		$brake = new Brake();
//		$brake->setPrice(7.5);
//		$brake->setName("Bremse");
//		$articleManager->save($brake);
//
//		$coat = new Coat();
//		$coat->setPrice(9);
//		$coat->setName("Mantel");
//		$articleManager->save($coat);
//
//		$dynamo = new Dynamo();
//		$dynamo->setPrice(11.5);
//		$dynamo->setName("Dynamo");
//		$articleManager->save($dynamo);
//
//		$frontWheel = new FrontWheel();
//		$frontWheel->setPrice(13);
//		$frontWheel->setName("Vorderrad");
//		$articleManager->save($frontWheel);
//
//		$gearShift = new GearShift();
//		$gearShift->setPrice(14.5);
//		$gearShift->setName("Gangschaltung");
//		$articleManager->save($gearShift);
//
//		$light = new Light();
//		$light->setPrice(16);
//		$light->setName("Licht");
//		$articleManager->save($light);
//
//		$mudGuard = new MudGuard();
//		$mudGuard->setPrice(17.5);
//		$mudGuard->setName("Schutzblech");
//		$articleManager->save($mudGuard);
//
//		$pannierRack = new PannierRack();
//		$pannierRack->setPrice(19);
//		$pannierRack->setName("Gepäckträger");
//		$articleManager->save($pannierRack);
//
//		$pedal = new Pedal();
//		$pedal->setPrice(20.5);
//		$pedal->setName("Pedal");
//		$articleManager->save($pedal);
//
//		$rearWheel = new RearWheel();
//		$rearWheel->setPrice(22);
//		$rearWheel->setName("Hinterrad");
//		$articleManager->save($rearWheel);
//
//		$tube = new Tube();
//		$tube->setPrice(23.5);
//		$tube->setName("Schlauch");
//		$articleManager->save($tube);
//
//		$frame = new Frame();
//		$frame->setPrice(25);
//		$frame->setName("Rahmen");
//		$articleManager->save($frame);
//
//		$bicycle = new Bicycle();
//		$bicycle->setPrice(26.5);
//		$bicycle->setName("Fahrrad");
//		$bicycle->setQuickDescription("Standardfahrrad");
//		$bicycle->setDescription("Hier könnte ihre Beschreibung stehen");
//		$bicycle->setBell($bell);
//		$bicycle->setFrontBrake($brake);
//		$bicycle->setRearBrake($brake);
//		$bicycle->setFrontCoat($coat);
//		$bicycle->setRearCoat($coat);
//		$bicycle->setDynamo($dynamo);
//		$bicycle->setFrame($frame);
//		$bicycle->setFrontWheel($frontWheel);
//		$bicycle->setRearWheel($rearWheel);
//		$bicycle->setPannierRack($pannierRack);
//		$bicycle->setPedal($pedal);
//		$bicycle->setFrontTube($tube);
//		$bicycle->setRearTube($tube);
//		$bicycle->setLight($light);
//		$bicycle->setMudGuard($mudGuard);
//		$bicycle->setGearShift($gearShift);
//		$bicycle->setSaddle($saddle);
//		$bicycle->setSaddleBar($saddleBar);
//		$bicycle->setHandlebars($handlebars);
//		$articleManager->save($bicycle);

		echo "insert Article-Test-Data successfull";
	}

	public function deleteAllArticlesAction()
	{
		/** @var ArticleManager $articleManager */
		$articleManager = $this->getServiceLocator()->get("BikeStore.articleManager");
		/** @var BicycleManager $bicycleManager */
		$bicycleManager = $this->getServiceLocator()->get("BikeStore.bicycleManager");

		$articles = $bicycleManager->getAllEntities();
		foreach($articles as $article)
		{
			$articleManager->removeEntity($article);
		}
		$articles = $articleManager->getAllEntities();
		foreach($articles as $article)
		{
			$articleManager->removeEntity($article);
		}
		echo "Alle Artikel gelöscht\n";
	}

	public function refreshTestArticlesAction()
	{
		$this->deleteAllArticlesAction();
		$this->insertTestDataAction();
	}
}