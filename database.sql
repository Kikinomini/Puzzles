SET SQL_SAFE_UPDATES = 0;

CREATE DATABASE IF NOT EXISTS puzzles;
USE puzzles;

CREATE TABLE User (
  id INT AUTO_INCREMENT NOT NULL,
  username VARCHAR(255) NOT NULL,
  password VARCHAR(128) NOT NULL,
  email VARCHAR(255) NOT NULL,
  vorname VARCHAR(255) NOT NULL,
  nachname VARCHAR(255) NOT NULL,
  geburtsdatum DATE NOT NULL,
  aktiviert TINYINT(1) NOT NULL,
  blockiert TINYINT(1) NOT NULL,
  UNIQUE INDEX UNIQ_2DA17977F85E0677 (username),
  UNIQUE INDEX UNIQ_2DA17977E7927C74 (email),
  PRIMARY KEY(id)
  ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;

CREATE TABLE Role (
  id INT AUTO_INCREMENT NOT NULL,
  name VARCHAR(75) NOT NULL,
  beschreibung VARCHAR(255) NOT NULL,
  UNIQUE INDEX UNIQ_F75B25545E237E06 (name),
  PRIMARY KEY(id)
  ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;

CREATE TABLE Resource (
  id INT AUTO_INCREMENT NOT NULL,
  name VARCHAR(75) NOT NULL,
  beschreibung VARCHAR(255) NOT NULL,
  UNIQUE INDEX UNIQ_45E796405E237E06 (name),
  PRIMARY KEY(id)
  ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;

CREATE TABLE UserResource (
  UserId INT NOT NULL,
  ResourceId INT NOT NULL,
  INDEX IDX_7193B2CF631A48FA (UserId),
  INDEX IDX_7193B2CFC3A87F61 (ResourceId),
  PRIMARY KEY(UserId, ResourceId),
  CONSTRAINT FK_7193B2CF631A48FA FOREIGN KEY (UserId) REFERENCES User (id),
  CONSTRAINT FK_7193B2CFC3A87F61 FOREIGN KEY (ResourceId) REFERENCES Resource (id)
  ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;

CREATE TABLE RoleUser (
  RoleId INT NOT NULL,
  UserId INT NOT NULL,
  INDEX IDX_2DDE86A9BF6EF8BE (RoleId),
  INDEX IDX_2DDE86A9631A48FA (UserId),
  PRIMARY KEY(RoleId, UserId),
  CONSTRAINT FK_2DDE86A9BF6EF8BE FOREIGN KEY (RoleId) REFERENCES Role (id),
  CONSTRAINT FK_2DDE86A9631A48FA FOREIGN KEY (UserId) REFERENCES User (id)
  ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;

CREATE TABLE RoleResource (
  RoleId INT NOT NULL,
  ResourceId INT NOT NULL,
  INDEX IDX_9553093EBF6EF8BE (RoleId),
  INDEX IDX_9553093EC3A87F61 (ResourceId),
  PRIMARY KEY(RoleId, ResourceId),
  CONSTRAINT FK_9553093EBF6EF8BE FOREIGN KEY (RoleId) REFERENCES Role (id),
  CONSTRAINT FK_9553093EC3A87F61 FOREIGN KEY (ResourceId) REFERENCES Resource (id)
  ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;

CREATE TABLE RoleChildren (
  ParentId INT NOT NULL,
  ChildId INT NOT NULL,
  INDEX IDX_88554C92E9982EB8 (ParentId),
  INDEX IDX_88554C92CD4052DB (ChildId),
  PRIMARY KEY(ChildId, ParentId),
  CONSTRAINT FK_88554C92E9982EB8 FOREIGN KEY (ParentId) REFERENCES Role (id),
  CONSTRAINT FK_88554C92CD4052DB FOREIGN KEY (ChildId) REFERENCES Role (id)
  ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;

CREATE TABLE Code (
  id INT AUTO_INCREMENT NOT NULL,
  code VARCHAR(255) NOT NULL,
  action VARCHAR(255) NOT NULL,
  wert VARCHAR(255) NOT NULL,
  erstelldatum DATETIME NOT NULL,
  userId INT DEFAULT NULL,
  UNIQUE INDEX UNIQ_D7279FA677153098 (code),
  INDEX IDX_D7279FA664B64DCC (userId),
  PRIMARY KEY(id),
  CONSTRAINT FK_D7279FA664B64DCC FOREIGN KEY (userId) REFERENCES User (id)
  ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;

CREATE TABLE `Cronjob` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`intervalInMinutes` INT(11) NOT NULL DEFAULT '0',
	`lastRun` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
	`lastSuccess` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
	`className` VARCHAR(255) NOT NULL DEFAULT '0',
	`errorMessage` VARCHAR(255) NOT NULL DEFAULT '',
	`discr` VARCHAR(255) NULL DEFAULT NULL,
	`active` TINYINT(1) NULL DEFAULT 1,
	PRIMARY KEY (`id`)
);

USE puzzles;
INSERT INTO Role (name, beschreibung) VALUES ('gast', 'Kein aktives oder eingeloggtes Mitglied');
INSERT INTO Role (name, beschreibung) VALUES ('user', 'Normales Mitglied');
INSERT INTO Role (name, beschreibung) VALUES ('admin', 'Admin, darf alles');

INSERT INTO Resource (name, beschreibung) VALUES ('offline', 'alles, was ein nicht eingeloggter User sehen darf');
INSERT INTO Resource (name, beschreibung) VALUES ('online', 'alles, was ein eingeloggter User sehen darf');
INSERT INTO Resource (name, beschreibung) VALUES ('default', 'darf jeder');
INSERT INTO `Resource` (`name`, `beschreibung`) VALUES ('admin', 'darf nur ein Admin');


INSERT INTO RoleChildren (ParentId, ChildId)
  SELECT r1.id, r2.id FROM Role r1, Role r2
    WHERE r1.name = 'user' AND r2.name='admin';


INSERT INTO RoleResource(RoleId, ResourceId)
  SELECT r1.id, r2.id FROM Role r1, Resource r2
    WHERE r1.name = 'user' AND r2.name='online';

INSERT INTO RoleResource(RoleId, ResourceId)
  SELECT r1.id, r2.id FROM Role r1, Resource r2
    WHERE r1.name = 'gast' AND r2.name='offline';

INSERT INTO RoleResource(RoleId, ResourceId)
  SELECT r1.id, r2.id FROM Role r1, Resource r2
    WHERE r1.name = 'user' AND r2.name='default';

INSERT INTO RoleResource(RoleId, ResourceId)
  SELECT r1.id, r2.id FROM Role r1, Resource r2
    WHERE r1.name = 'gast' AND r2.name='default';

INSERT INTO RoleResource(RoleId, ResourceId)
  SELECT r1.id, r2.id FROM Role r1, Resource r2
    WHERE r1.name = 'admin' AND r2.name='admin';

-- Abgesendet
-- #################################################################################################