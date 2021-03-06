-- This script create the buubleup database

-- MySQL Script generated by MySQL Workbench
-- Sat Aug  4 13:34:28 2018
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema bubbleUpDB
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema bubbleUpDB
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `bubbleUpDB` DEFAULT CHARACTER SET utf8 ;
USE `bubbleUpDB` ;

-- -----------------------------------------------------
-- Table `bubbleUpDB`.`comics`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bubbleUpDB`.`comics` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Title` VARCHAR(255) NOT NULL,
  `Synopsis` VARCHAR(255) NOT NULL,
  `StartDate` DATE NOT NULL,
  `EndDate` DATE NULL,
  `CoverExt` VARCHAR(10) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE INDEX `Title_UNIQUE` (`Title` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bubbleUpDB`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bubbleUpDB`.`users` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Login` VARCHAR(255) NOT NULL,
  `Firstname` VARCHAR(255) NOT NULL,
  `Surname` VARCHAR(255) NOT NULL,
  `BirthDate` DATE NOT NULL,
  `Password` VARCHAR(41) NOT NULL,
  `Email` VARCHAR(254) NOT NULL,
  `EmailValidated` TINYINT NOT NULL DEFAULT 0,
  `Unsubscribed` TINYINT NOT NULL DEFAULT 0,
  `EmailKey` VARCHAR(64) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE INDEX `Login_UNIQUE` (`Login` ASC),
  UNIQUE INDEX `Email_UNIQUE` (`Email` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bubbleUpDB`.`authors`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bubbleUpDB`.`authors` (
  `comicId` INT NOT NULL,
  `userId` INT NOT NULL,
  INDEX `fk_authors_comics_idx` (`comicId` ASC),
  INDEX `fk_authors_users1_idx` (`userId` ASC),
  CONSTRAINT `fk_authors_comics`
    FOREIGN KEY (`comicId`)
    REFERENCES `bubbleUpDB`.`comics` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_authors_users1`
    FOREIGN KEY (`userId`)
    REFERENCES `bubbleUpDB`.`users` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bubbleUpDB`.`volumes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bubbleUpDB`.`volumes` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Number` INT NOT NULL,
  `Title` VARCHAR(255) NOT NULL,
  `Synopsis` VARCHAR(255) NOT NULL,
  `StartDate` DATE NOT NULL,
  `EndDate` DATE NULL,
  `comicId` INT NOT NULL,
  PRIMARY KEY (`Id`),
  INDEX `fk_volumes_comics1_idx` (`comicId` ASC),
  CONSTRAINT `fk_volumes_comics1`
    FOREIGN KEY (`comicId`)
    REFERENCES `bubbleUpDB`.`comics` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bubbleUpDB`.`chapters`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bubbleUpDB`.`chapters` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Number` INT NOT NULL,
  `Title` VARCHAR(255) NOT NULL,
  `Synopsis` VARCHAR(255) NOT NULL,
  `Validated` TINYINT NOT NULL DEFAULT 0,
  `PublicationDate` DATE NULL,
  `volumeId` INT NOT NULL,
  PRIMARY KEY (`Id`),
  INDEX `fk_chapters_volumes1_idx` (`volumeId` ASC),
  CONSTRAINT `fk_chapters_volumes1`
    FOREIGN KEY (`volumeId`)
    REFERENCES `bubbleUpDB`.`volumes` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bubbleUpDB`.`comicStrips`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bubbleUpDB`.`comicStrips` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Number` INT NOT NULL,
  `Ext` VARCHAR(10) NOT NULL,
  `chapterId` INT NOT NULL,
  PRIMARY KEY (`Id`),
  INDEX `fk_comicStrips_chapters1_idx` (`chapterId` ASC),
  CONSTRAINT `fk_comicStrips_chapters1`
    FOREIGN KEY (`chapterId`)
    REFERENCES `bubbleUpDB`.`chapters` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bubbleUpDB`.`genres`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bubbleUpDB`.`genres` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Label` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE INDEX `Id_UNIQUE` (`Id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bubbleUpDB`.`comicsGenres`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bubbleUpDB`.`comicsGenres` (
  `genreId` INT NOT NULL,
  `comicId` INT NOT NULL,
  INDEX `fk_searchComics_genre1_idx` (`genreId` ASC),
  INDEX `fk_searchComics_comics1_idx` (`comicId` ASC),
  CONSTRAINT `fk_searchComics_genre1`
    FOREIGN KEY (`genreId`)
    REFERENCES `bubbleUpDB`.`genres` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_searchComics_comics1`
    FOREIGN KEY (`comicId`)
    REFERENCES `bubbleUpDB`.`comics` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `bubbleUpDB`;

DELIMITER ;

-- -----------------------------------------------------
-- Table `bubbleUpDB`.`tokens`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bubbleUpDB`.`tokens` (
  `Token` VARCHAR(64) NOT NULL,
  `Login` VARCHAR(255) NOT NULL,
  UNIQUE INDEX `Token_UNIQUE` (`Token` ASC))
ENGINE = InnoDB;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
