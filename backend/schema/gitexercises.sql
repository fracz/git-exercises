-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema git_exercises
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Table `attempt`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `attempt` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `committer_id` NCHAR(40) NOT NULL,
  `committer_name` VARCHAR(255) NOT NULL,
  `exercise` VARCHAR(50) NOT NULL,
  `passed` TINYINT(4) NOT NULL,
  `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `commiter_id_idx` (`committer_id` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 4012
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `gamification_session`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `gamification_session` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `start` TIMESTAMP NOT NULL,
  `end` TIMESTAMP NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gamification_stats`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `gamification_stats` (
  `session_id` INT UNSIGNED NOT NULL,
  `committer_id` NCHAR(40) NOT NULL,
  `passed` TINYINT(3) UNSIGNED NOT NULL DEFAULT 0,
  `failed` TINYINT(3) UNSIGNED NOT NULL DEFAULT 0,
  `points` DOUBLE(6,2) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`committer_id`, `session_id`),
  INDEX `fk_gamification_gamification_session_idx` (`session_id` ASC),
  CONSTRAINT `fk_gamification_gamification_session`
    FOREIGN KEY (`session_id`)
    REFERENCES `gamification_session` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `console_link`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `console_link` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `url` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `url_UNIQUE` (`url` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `id_map`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `id_map` (
  `long_id` CHAR(40) NOT NULL,
  `short_id` VARCHAR(40) NOT NULL,
  PRIMARY KEY (`long_id`),
  UNIQUE INDEX `short_id_UNIQUE` (`short_id` ASC))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;


-- further changes

ALTER TABLE `gamification_stats`
	DROP FOREIGN KEY `fk_gamification_gamification_session`;
ALTER TABLE `gamification_stats`
	ADD CONSTRAINT `fk_gamification_gamification_session` FOREIGN KEY (`session_id`) REFERENCES `gamification_session` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;
