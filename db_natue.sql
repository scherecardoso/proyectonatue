-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema shena
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema shena
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `shena` DEFAULT CHARACTER SET utf8 ;
USE `shena` ;

-- -----------------------------------------------------
-- Table `shena`.`productos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `shena`.`productos` (
  `codigo` INT NOT NULL,
  `nombre` VARCHAR(45) NULL,
  `descripcion` VARCHAR(45) NULL,
  `precio` INT NULL,
  `costo` INT NULL,
  `stock` INT NULL,
  PRIMARY KEY (`codigo`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `shena`.`pedidos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `shena`.`pedidos` (
  `id` INT NOT NULL,
  `nombre` VARCHAR(45) NULL,
  `fecha` DATE NULL,
  `estado` VARCHAR(45) NULL,
  `vendedor` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `shena`.`carrito`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `shena`.`carrito` (
  `pedidos_id` INT NOT NULL,
  `productos_codigo` INT NOT NULL,
  PRIMARY KEY (`pedidos_id`, `productos_codigo`),
  INDEX `fk_pedidos_has_productos_productos1_idx` (`productos_codigo` ASC),
  INDEX `fk_pedidos_has_productos_pedidos_idx` (`pedidos_id` ASC),
  CONSTRAINT `fk_pedidos_has_productos_pedidos`
    FOREIGN KEY (`pedidos_id`)
    REFERENCES `shena`.`pedidos` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pedidos_has_productos_productos1`
    FOREIGN KEY (`productos_codigo`)
    REFERENCES `shena`.`productos` (`codigo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `shena`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `shena`.`usuario` (
  `CI` INT NOT NULL,
  `nombre` VARCHAR(45) NULL,
  `direccion` VARCHAR(45) NULL,
  `celular` INT NULL,
  `rol` VARCHAR(45) NULL,
  `estado` VARCHAR(45) NULL,
  PRIMARY KEY (`CI`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;