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
  `codigo` VARCHAR(45) NOT NULL,
  `nombre` VARCHAR(45) NULL DEFAULT NULL,
  `descripcion` VARCHAR(45) NULL DEFAULT NULL,
  `precio` INT NULL DEFAULT NULL,
  `costo` INT NULL DEFAULT NULL,
  `stock` INT NULL DEFAULT NULL,
  PRIMARY KEY (`codigo`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `shena`.`pedidos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `shena`.`pedidos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NULL DEFAULT NULL,
  `fecha` DATE NULL DEFAULT NULL,
  `estado` VARCHAR(45) NULL DEFAULT NULL,
  `vendedor` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `shena`.`carrito`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `shena`.`carrito` (
  `pedidos_id` INT NOT NULL,
  `productos_codigo` VARCHAR(45) NOT NULL,
  `cantidad` INT NULL DEFAULT NULL,
  `costototal` INT NULL DEFAULT NULL,
  PRIMARY KEY (`pedidos_id`, `productos_codigo`),
  INDEX `fk_pedidos_has_productos_productos1_idx` (`productos_codigo` ASC) ,
  INDEX `fk_pedidos_has_productos_pedidos_idx` (`pedidos_id` ASC) ,
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
  `nombre` VARCHAR(45) NULL DEFAULT NULL,
  `direccion` VARCHAR(45) NULL DEFAULT NULL,
  `celular` INT NULL DEFAULT NULL,
  `rol` VARCHAR(45) NULL DEFAULT NULL,
  `estado` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`CI`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `shena`.`ventas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `shena`.`ventas` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `pedidos_id` INT NOT NULL,
  `costo` INT NULL,
  `fecha` DATE NULL,
  `estado` VARCHAR(45) NULL,
  PRIMARY KEY (`id`, `pedidos_id`),
  INDEX `fk_ventas_pedidos1_idx` (`pedidos_id` ASC) ,
  CONSTRAINT `fk_ventas_pedidos1`
    FOREIGN KEY (`pedidos_id`)
    REFERENCES `shena`.`pedidos` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
