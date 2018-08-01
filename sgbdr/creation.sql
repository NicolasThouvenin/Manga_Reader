-- -----------------------------------------------------
-- Table comics
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS comics (
  Id INT NOT NULL AUTO_INCREMENT,
  Title VARCHAR(255) NOT NULL,
  Synopsie VARCHAR(255) NOT NULL,
  StartDate DATE NOT NULL,
  EndDate DATE NULL,
  PRIMARY KEY (Id),
  UNIQUE INDEX Title_UNIQUE (Title ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table users
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS users (
  Id INT NOT NULL AUTO_INCREMENT,
  Login VARCHAR(255) NOT NULL,
  Firstname VARCHAR(255) NOT NULL,
  Surname VARCHAR(255) NOT NULL,
  BirthDate DATE NOT NULL,
  Password VARCHAR(255) NOT NULL,
  Email VARCHAR(254) NOT NULL,
  EmailValided TINYINT NOT NULL DEFAULT 0,
  PRIMARY KEY (Id),
  UNIQUE INDEX Login_UNIQUE (Login ASC),
  UNIQUE INDEX Email_UNIQUE (Email ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table authors
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS authors (
  comicId INT NOT NULL,
  userId INT NOT NULL,
  INDEX fk_authors_comics_idx (comicId ASC),
  INDEX fk_authors_users1_idx (userId ASC),
  CONSTRAINT fk_authors_comics
    FOREIGN KEY (comicId)
    REFERENCES comics (Id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_authors_users1
    FOREIGN KEY (userId)
    REFERENCES users (Id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table narrativeArcs
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS narrativeArcs (
  Id INT NOT NULL AUTO_INCREMENT,
  Number INT NOT NULL,
  Title VARCHAR(255) NOT NULL,
  Synopsie VARCHAR(255) NOT NULL,
  StartDate DATE NOT NULL,
  EndDate DATE NULL,
  comicId INT NOT NULL,
  INDEX fk_narrativeArc_comics1_idx (comicId ASC),
  PRIMARY KEY (Id),
  CONSTRAINT fk_narrativeArc_comics1
    FOREIGN KEY (comicId)
    REFERENCES comics (Id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table volumes
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS volumes (
  Id INT NOT NULL AUTO_INCREMENT,
  Number INT NOT NULL,
  Title VARCHAR(255) NOT NULL,
  Synopsie VARCHAR(255) NOT NULL,
  StartDate DATE NOT NULL,
  EndDate DATE NULL,
  narrativeArcId INT NOT NULL,
  PRIMARY KEY (Id),
  INDEX fk_volume_narrativeArc1_idx (narrativeArcId ASC),
  CONSTRAINT fk_volume_narrativeArc1
    FOREIGN KEY (narrativeArcId)
    REFERENCES narrativeArcs (Id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table chapters
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS chapters (
  Id INT NOT NULL AUTO_INCREMENT,
  Number INT NOT NULL,
  Title VARCHAR(255) NOT NULL,
  Synopsie VARCHAR(255) NOT NULL,
  Validated TINYINT NOT NULL,
  PublicationDate DATE NULL,
  volumeId INT NOT NULL,
  PRIMARY KEY (Id),
  INDEX fk_chapters_volumes1_idx (volumeId ASC),
  CONSTRAINT fk_chapters_volumes1
    FOREIGN KEY (volumeId)
    REFERENCES volumes (Id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table comicStrips
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS comicStrips (
  Id INT NOT NULL AUTO_INCREMENT,
  Number INT NOT NULL,
  Path VARCHAR(250) NOT NULL,
  chapterId INT NOT NULL,
  PRIMARY KEY (Id),
  INDEX fk_comicStrips_chapters1_idx (chapterId ASC),
  CONSTRAINT fk_comicStrips_chapters1
    FOREIGN KEY (chapterId)
    REFERENCES chapters (Id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table genre
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS genre (
  Id INT NOT NULL AUTO_INCREMENT,
  Label VARCHAR(45) NOT NULL,
  PRIMARY KEY (Id))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table searchComics
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS searchComics (
  genreId INT NOT NULL,
  comicId INT NOT NULL,
  INDEX fk_searchComics_genre1_idx (genreId ASC),
  INDEX fk_searchComics_comics1_idx (comicId ASC),
  CONSTRAINT fk_searchComics_genre1
    FOREIGN KEY (genreId)
    REFERENCES genre (Id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_searchComics_comics1
    FOREIGN KEY (comicId)
    REFERENCES comics (Id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE superusejknox;

DELIMITER $$
USE superusejknox$$
CREATE DEFINER = CURRENT_USER TRIGGER chapters_BEFORE_UPDATE BEFORE UPDATE ON chapters FOR EACH ROW
BEGIN
	IF (OLD.Validated = 0 OR NEW.Validated = 1) THEN
		SET NEW.PublicationDate = NOW();
	END IF;
END$$


DELIMITER ;