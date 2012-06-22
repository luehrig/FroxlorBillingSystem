SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `froxlor_billing` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `froxlor_billing` ;

-- -----------------------------------------------------
-- Table `froxlor_billing`.`tbl_language`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `froxlor_billing`.`tbl_language` ;

CREATE  TABLE IF NOT EXISTS `froxlor_billing`.`tbl_language` (
  `language_id` INT NOT NULL AUTO_INCREMENT ,
  `language_name` VARCHAR(50) NOT NULL ,
  `iso_code` CHAR(5) NOT NULL ,
  PRIMARY KEY (`language_id`) )
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `froxlor_billing`.`tbl_country`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `froxlor_billing`.`tbl_country` ;

CREATE  TABLE IF NOT EXISTS `froxlor_billing`.`tbl_country` (
  `country_id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `language_id` INT NOT NULL ,
  `iso_code` CHAR(2) NOT NULL ,
  `country_name` VARCHAR(100) NOT NULL ,
  PRIMARY KEY (`country_id`, `language_id`) ,
  INDEX `fk_country_language_id` (`language_id` ASC) ,
  CONSTRAINT `fk_country_language_id`
    FOREIGN KEY (`language_id` )
    REFERENCES `froxlor_billing`.`tbl_language` (`language_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `froxlor_billing`.`tbl_customer_address`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `froxlor_billing`.`tbl_customer_address` ;

CREATE  TABLE IF NOT EXISTS `froxlor_billing`.`tbl_customer_address` (
  `customer_address_id` INT NOT NULL AUTO_INCREMENT ,
  `street` VARCHAR(255) NOT NULL ,
  `street_number` VARCHAR(5) NOT NULL ,
  `post_code` VARCHAR(10) NOT NULL ,
  `city` VARCHAR(100) NOT NULL ,
  `country_code` INT NOT NULL ,
  INDEX `fk_customer_address_country_id` (`country_code` ASC) ,
  PRIMARY KEY (`customer_address_id`) ,
  UNIQUE INDEX `customer_address_id_UNIQUE` (`customer_address_id` ASC) ,
  CONSTRAINT `fk_customer_address_country_id`
    FOREIGN KEY (`country_code` )
    REFERENCES `froxlor_billing`.`tbl_country` (`language_id` )
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `froxlor_billing`.`tbl_customer`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `froxlor_billing`.`tbl_customer` ;

CREATE  TABLE IF NOT EXISTS `froxlor_billing`.`tbl_customer` (
  `customer_id` INT NOT NULL AUTO_INCREMENT ,
  `gender` CHAR(1) NOT NULL ,
  `title` VARCHAR(50) NULL ,
  `first_name` VARCHAR(100) NOT NULL ,
  `last_name` VARCHAR(100) NOT NULL ,
  `company` VARCHAR(255) NULL ,
  `shipping_address` INT NOT NULL ,
  `billing_address` INT NOT NULL ,
  `telephone` VARCHAR(50) NULL ,
  `fax` VARCHAR(50) NULL ,
  `email` VARCHAR(255) NOT NULL ,
  `registered_on` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  `password` VARCHAR(40) NOT NULL ,
  `customer_number` CHAR(10) NULL ,
  PRIMARY KEY (`customer_id`) ,
  UNIQUE INDEX `customer_id_UNIQUE` (`customer_id` ASC) ,
  INDEX `fk_customer_shipping_address` (`shipping_address` ASC) ,
  INDEX `fk_customer_billing_address` (`billing_address` ASC) ,
  CONSTRAINT `fk_customer_shipping_address`
    FOREIGN KEY (`shipping_address` )
    REFERENCES `froxlor_billing`.`tbl_customer_address` (`customer_address_id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_customer_billing_address`
    FOREIGN KEY (`billing_address` )
    REFERENCES `froxlor_billing`.`tbl_customer_address` (`customer_address_id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `froxlor_billing`.`tbl_order_status`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `froxlor_billing`.`tbl_order_status` ;

CREATE  TABLE IF NOT EXISTS `froxlor_billing`.`tbl_order_status` (
  `order_status_id` INT NOT NULL AUTO_INCREMENT ,
  `language_id` INT NOT NULL ,
  `description` VARCHAR(255) NOT NULL ,
  PRIMARY KEY (`order_status_id`, `language_id`) ,
  INDEX `fk_order_status_language_id` (`language_id` ASC) ,
  CONSTRAINT `fk_order_status_language_id`
    FOREIGN KEY (`language_id` )
    REFERENCES `froxlor_billing`.`tbl_language` (`language_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `froxlor_billing`.`tbl_order`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `froxlor_billing`.`tbl_order` ;

CREATE  TABLE IF NOT EXISTS `froxlor_billing`.`tbl_order` (
  `order_id` INT NOT NULL AUTO_INCREMENT ,
  `customer_id` INT NOT NULL ,
  `order_date` DATE NOT NULL ,
  `order_status` INT NOT NULL ,
  `customer_shipping_address` INT NOT NULL ,
  `customer_billing_address` INT NOT NULL ,
  PRIMARY KEY (`order_id`) ,
  UNIQUE INDEX `order_id_UNIQUE` (`order_id` ASC) ,
  INDEX `fk_order_customer_id` (`customer_id` ASC) ,
  INDEX `fk_order_order_status_id` (`order_status` ASC) ,
  INDEX `fk_order_shipping_address` (`customer_shipping_address` ASC) ,
  INDEX `fk_order_billing_address` (`customer_billing_address` ASC) ,
  CONSTRAINT `fk_order_customer_id`
    FOREIGN KEY (`customer_id` )
    REFERENCES `froxlor_billing`.`tbl_customer` (`customer_id` )
    ON DELETE NO ACTION
    ON UPDATE CASCADE,
  CONSTRAINT `fk_order_order_status_id`
    FOREIGN KEY (`order_status` )
    REFERENCES `froxlor_billing`.`tbl_order_status` (`order_status_id` )
    ON DELETE NO ACTION
    ON UPDATE CASCADE,
  CONSTRAINT `fk_order_shipping_address`
    FOREIGN KEY (`customer_shipping_address` )
    REFERENCES `froxlor_billing`.`tbl_customer_address` (`customer_address_id` )
    ON DELETE NO ACTION
    ON UPDATE CASCADE,
  CONSTRAINT `fk_order_billing_address`
    FOREIGN KEY (`customer_billing_address` )
    REFERENCES `froxlor_billing`.`tbl_customer_address` (`customer_address_id` )
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `froxlor_billing`.`tbl_invoice_status`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `froxlor_billing`.`tbl_invoice_status` ;

CREATE  TABLE IF NOT EXISTS `froxlor_billing`.`tbl_invoice_status` (
  `invoice_status_id` INT NOT NULL AUTO_INCREMENT ,
  `language_id` INT NOT NULL ,
  `description` VARCHAR(255) NOT NULL ,
  PRIMARY KEY (`invoice_status_id`, `language_id`) ,
  INDEX `fk_invoice_status_language_id` (`language_id` ASC) ,
  CONSTRAINT `fk_invoice_status_language_id`
    FOREIGN KEY (`language_id` )
    REFERENCES `froxlor_billing`.`tbl_language` (`language_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `froxlor_billing`.`tbl_currency`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `froxlor_billing`.`tbl_currency` ;

CREATE  TABLE IF NOT EXISTS `froxlor_billing`.`tbl_currency` (
  `currency_id` INT NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(32) NOT NULL ,
  `code` CHAR(3) NOT NULL ,
  `symbol` VARCHAR(12) NOT NULL ,
  `decimal_point` CHAR(1) NOT NULL ,
  `thousands_point` CHAR(1) NOT NULL ,
  `decimal_places` CHAR(1) NOT NULL ,
  PRIMARY KEY (`currency_id`) ,
  UNIQUE INDEX `currency_id_UNIQUE` (`currency_id` ASC) )
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `froxlor_billing`.`tbl_tax`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `froxlor_billing`.`tbl_tax` ;

CREATE  TABLE IF NOT EXISTS `froxlor_billing`.`tbl_tax` (
  `tax_id` INT NOT NULL AUTO_INCREMENT ,
  `tax_rate` DECIMAL NULL ,
  PRIMARY KEY (`tax_id`) ,
  UNIQUE INDEX `tax_id_UNIQUE` (`tax_id` ASC) )
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `froxlor_billing`.`tbl_invoice`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `froxlor_billing`.`tbl_invoice` ;

CREATE  TABLE IF NOT EXISTS `froxlor_billing`.`tbl_invoice` (
  `invoice_id` INT NOT NULL AUTO_INCREMENT ,
  `customer_id` INT NOT NULL ,
  `issue_date` DATE NOT NULL ,
  `payment_date` DATE NOT NULL ,
  `payed_on` DATE NULL ,
  `invoice_number` VARCHAR(7) NULL ,
  `order_id` INT NOT NULL ,
  `invoice_status` INT NOT NULL ,
  `currency_id` INT NOT NULL ,
  `tax_id` INT NOT NULL ,
  PRIMARY KEY (`invoice_id`) ,
  INDEX `fk_invoice_customer_id` (`customer_id` ASC) ,
  UNIQUE INDEX `invoice_number_UNIQUE` (`invoice_id` ASC) ,
  INDEX `fk_invoice_order_id` (`order_id` ASC) ,
  INDEX `fk_invoice_invoice_status_id` (`invoice_status` ASC) ,
  INDEX `fk_invoice_currency_id` (`currency_id` ASC) ,
  INDEX `fk_invoice_tax_id` (`tax_id` ASC) ,
  CONSTRAINT `fk_invoice_customer_id`
    FOREIGN KEY (`customer_id` )
    REFERENCES `froxlor_billing`.`tbl_customer` (`customer_id` )
    ON DELETE NO ACTION
    ON UPDATE CASCADE,
  CONSTRAINT `fk_invoice_order_id`
    FOREIGN KEY (`order_id` )
    REFERENCES `froxlor_billing`.`tbl_order` (`order_id` )
    ON DELETE NO ACTION
    ON UPDATE CASCADE,
  CONSTRAINT `fk_invoice_invoice_status_id`
    FOREIGN KEY (`invoice_status` )
    REFERENCES `froxlor_billing`.`tbl_invoice_status` (`invoice_status_id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_invoice_currency_id`
    FOREIGN KEY (`currency_id` )
    REFERENCES `froxlor_billing`.`tbl_currency` (`currency_id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_invoice_tax_id`
    FOREIGN KEY (`tax_id` )
    REFERENCES `froxlor_billing`.`tbl_tax` (`tax_id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `froxlor_billing`.`tbl_product`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `froxlor_billing`.`tbl_product` ;

CREATE  TABLE IF NOT EXISTS `froxlor_billing`.`tbl_product` (
  `product_id` INT NOT NULL AUTO_INCREMENT ,
  `language_id` INT NOT NULL ,
  `title` VARCHAR(50) NOT NULL ,
  `contract_periode` TINYINT NOT NULL ,
  `description` MEDIUMTEXT NULL ,
  `quantity` INT NOT NULL ,
  `price` DOUBLE NOT NULL ,
  `active` TINYINT(1)  NOT NULL DEFAULT false ,
  PRIMARY KEY (`product_id`, `language_id`) ,
  INDEX `fk_product_language_id` (`language_id` ASC) ,
  CONSTRAINT `fk_product_language_id`
    FOREIGN KEY (`language_id` )
    REFERENCES `froxlor_billing`.`tbl_language` (`language_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `froxlor_billing`.`tbl_product_attribute`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `froxlor_billing`.`tbl_product_attribute` ;

CREATE  TABLE IF NOT EXISTS `froxlor_billing`.`tbl_product_attribute` (
  `product_attribute_id` INT NOT NULL AUTO_INCREMENT ,
  `language_id` INT NOT NULL ,
  `description` VARCHAR(255) NOT NULL ,
  PRIMARY KEY (`product_attribute_id`, `language_id`) ,
  INDEX `fk_product_attribute_language_id` (`language_id` ASC) ,
  CONSTRAINT `fk_product_attribute_language_id`
    FOREIGN KEY (`language_id` )
    REFERENCES `froxlor_billing`.`tbl_language` (`language_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `froxlor_billing`.`tbl_product_info`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `froxlor_billing`.`tbl_product_info` ;

CREATE  TABLE IF NOT EXISTS `froxlor_billing`.`tbl_product_info` (
  `product_id` INT NOT NULL ,
  `attribute_id` INT NOT NULL ,
  `value` VARCHAR(50) NULL ,
  PRIMARY KEY (`product_id`, `attribute_id`) ,
  INDEX `fk_product_info_product_id` (`product_id` ASC) ,
  INDEX `fk_product_info_attribute_id` (`attribute_id` ASC) ,
  CONSTRAINT `fk_product_info_product_id`
    FOREIGN KEY (`product_id` )
    REFERENCES `froxlor_billing`.`tbl_product` (`product_id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_product_info_attribute_id`
    FOREIGN KEY (`attribute_id` )
    REFERENCES `froxlor_billing`.`tbl_product_attribute` (`product_attribute_id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `froxlor_billing`.`tbl_order_position_detail`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `froxlor_billing`.`tbl_order_position_detail` ;

CREATE  TABLE IF NOT EXISTS `froxlor_billing`.`tbl_order_position_detail` (
  `order_position_id` INT NOT NULL ,
  `server_id` INT NOT NULL ,
  `froxlor_customer_id` VARCHAR(40) NULL ,
  PRIMARY KEY (`order_position_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `froxlor_billing`.`tbl_order_position`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `froxlor_billing`.`tbl_order_position` ;

CREATE  TABLE IF NOT EXISTS `froxlor_billing`.`tbl_order_position` (
  `order_position_id` INT NOT NULL AUTO_INCREMENT ,
  `order_id` INT NOT NULL ,
  `product_id` INT NOT NULL ,
  `quantity` INT NOT NULL ,
  `price` DOUBLE NOT NULL ,
  `tax_id` INT NOT NULL ,
  PRIMARY KEY (`order_position_id`) ,
  INDEX `fk_order_position_product_id` (`product_id` ASC) ,
  INDEX `fk_order_position_order_id` (`order_id` ASC) ,
  INDEX `fk_order_position_order_position_detail_id` (`order_position_id` ASC) ,
  UNIQUE INDEX `order_position_id_UNIQUE` (`order_position_id` ASC) ,
  INDEX `fk_order_position_tax_id` (`tax_id` ASC) ,
  CONSTRAINT `fk_order_position_product_id`
    FOREIGN KEY (`product_id` )
    REFERENCES `froxlor_billing`.`tbl_product` (`product_id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_order_position_order_id`
    FOREIGN KEY (`order_id` )
    REFERENCES `froxlor_billing`.`tbl_order` (`order_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_order_position_order_position_detail_id`
    FOREIGN KEY (`order_position_id` )
    REFERENCES `froxlor_billing`.`tbl_order_position_detail` (`order_position_id` )
    ON DELETE NO ACTION
    ON UPDATE CASCADE,
  CONSTRAINT `fk_order_position_tax_id`
    FOREIGN KEY (`tax_id` )
    REFERENCES `froxlor_billing`.`tbl_tax` (`tax_id` )
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `froxlor_billing`.`tbl_server`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `froxlor_billing`.`tbl_server` ;

CREATE  TABLE IF NOT EXISTS `froxlor_billing`.`tbl_server` (
  `server_id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(255) NOT NULL ,
  `mngmnt_ui` VARCHAR(45) NULL ,
  `ipv4` VARCHAR(15) NULL ,
  `ipv6` VARCHAR(40) NULL ,
  `froxlor_username` VARCHAR(50) NOT NULL ,
  `froxlor_password` VARCHAR(40) NOT NULL ,
  `froxlor_db` VARCHAR(50) NOT NULL ,
  `froxlor_db_host` VARCHAR(255) NULL ,
  `total_space` DOUBLE NULL ,
  `free_space` DOUBLE NULL ,
  `active` TINYINT(1)  NOT NULL DEFAULT false ,
  PRIMARY KEY (`server_id`) ,
  UNIQUE INDEX `server_id_UNIQUE` (`server_id` ASC) ,
  UNIQUE INDEX `ipv4_UNIQUE` (`ipv4` ASC) ,
  UNIQUE INDEX `ipv6_UNIQUE` (`ipv6` ASC) )
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `froxlor_billing`.`tbl_active_customer`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `froxlor_billing`.`tbl_active_customer` ;

CREATE  TABLE IF NOT EXISTS `froxlor_billing`.`tbl_active_customer` (
  `customer_id` INT NOT NULL ,
  `session_id` CHAR(32) NOT NULL ,
  `start_date` TIMESTAMP NULL ,
  `expiration_date` TIMESTAMP NULL ,
  PRIMARY KEY (`customer_id`) ,
  INDEX `fk_active_customer_customer_id` (`customer_id` ASC) ,
  CONSTRAINT `fk_active_customer_customer_id`
    FOREIGN KEY (`customer_id` )
    REFERENCES `froxlor_billing`.`tbl_customer` (`customer_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `froxlor_billing`.`tbl_customizing`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `froxlor_billing`.`tbl_customizing` ;

CREATE  TABLE IF NOT EXISTS `froxlor_billing`.`tbl_customizing` (
  `key` VARCHAR(32) NOT NULL ,
  `language_id` INT NULL ,
  `value` VARCHAR(255) NOT NULL ,
  INDEX `fk_customizing_language_id` (`language_id` ASC) ,
  CONSTRAINT `fk_customizing_language_id`
    FOREIGN KEY (`language_id` )
    REFERENCES `froxlor_billing`.`tbl_language` (`language_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `froxlor_billing`.`tbl_backend_user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `froxlor_billing`.`tbl_backend_user` ;

CREATE  TABLE IF NOT EXISTS `froxlor_billing`.`tbl_backend_user` (
  `backend_user_id` INT NOT NULL AUTO_INCREMENT ,
  `first_name` VARCHAR(100) NOT NULL ,
  `last_name` VARCHAR(100) NOT NULL ,
  `password` VARCHAR(40) NOT NULL ,
  `email` VARCHAR(255) NOT NULL ,
  PRIMARY KEY (`backend_user_id`) ,
  UNIQUE INDEX `backend_user_id_UNIQUE` (`backend_user_id` ASC) )
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `froxlor_billing`.`tbl_reminder_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `froxlor_billing`.`tbl_reminder_type` ;

CREATE  TABLE IF NOT EXISTS `froxlor_billing`.`tbl_reminder_type` (
  `reminder_type_id` INT NOT NULL AUTO_INCREMENT ,
  `language_id` INT NOT NULL ,
  `title` VARCHAR(100) NOT NULL ,
  PRIMARY KEY (`reminder_type_id`, `language_id`) ,
  INDEX `fk_reminder_type_language_id` (`language_id` ASC) ,
  CONSTRAINT `fk_reminder_type_language_id`
    FOREIGN KEY (`language_id` )
    REFERENCES `froxlor_billing`.`tbl_language` (`language_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `froxlor_billing`.`tbl_reminder`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `froxlor_billing`.`tbl_reminder` ;

CREATE  TABLE IF NOT EXISTS `froxlor_billing`.`tbl_reminder` (
  `reminder_id` INT NOT NULL AUTO_INCREMENT ,
  `customer_id` INT NOT NULL ,
  `order_id` INT NOT NULL ,
  `reminder_type` INT NOT NULL ,
  PRIMARY KEY (`reminder_id`) ,
  UNIQUE INDEX `reminder_id_UNIQUE` (`reminder_id` ASC) ,
  INDEX `fk_reminder_customer_id` (`customer_id` ASC) ,
  INDEX `fk_reminder_order_id` (`order_id` ASC) ,
  INDEX `fk_reminder_reminder_type_id` (`reminder_type` ASC) ,
  CONSTRAINT `fk_reminder_customer_id`
    FOREIGN KEY (`customer_id` )
    REFERENCES `froxlor_billing`.`tbl_customer` (`customer_id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_reminder_order_id`
    FOREIGN KEY (`order_id` )
    REFERENCES `froxlor_billing`.`tbl_order` (`order_id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_reminder_reminder_type_id`
    FOREIGN KEY (`reminder_type` )
    REFERENCES `froxlor_billing`.`tbl_reminder_type` (`reminder_type_id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `froxlor_billing`.`tbl_contract`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `froxlor_billing`.`tbl_contract` ;

CREATE  TABLE IF NOT EXISTS `froxlor_billing`.`tbl_contract` (
  `contract_id` INT NOT NULL AUTO_INCREMENT ,
  `customer_id` INT NOT NULL ,
  `order_id` INT NOT NULL ,
  `invoice_id` INT NOT NULL ,
  ` expiration_date` DATE NULL ,
  `start_date` DATE NULL ,
  PRIMARY KEY (`contract_id`) ,
  UNIQUE INDEX `contract_id_UNIQUE` (`contract_id` ASC) ,
  INDEX `fk_contract_customer_id` (`customer_id` ASC) ,
  INDEX `fk_contract_order_id` (`order_id` ASC) ,
  INDEX `fk_contract_invoice_id` (`invoice_id` ASC) ,
  CONSTRAINT `fk_contract_customer_id`
    FOREIGN KEY (`customer_id` )
    REFERENCES `froxlor_billing`.`tbl_customer` (`customer_id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_contract_order_id`
    FOREIGN KEY (`order_id` )
    REFERENCES `froxlor_billing`.`tbl_order` (`order_id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_contract_invoice_id`
    FOREIGN KEY (`invoice_id` )
    REFERENCES `froxlor_billing`.`tbl_invoice` (`invoice_id` )
    ON DELETE SET NULL
    ON UPDATE CASCADE)
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `froxlor_billing`.`tbl_content`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `froxlor_billing`.`tbl_content` ;

CREATE  TABLE IF NOT EXISTS `froxlor_billing`.`tbl_content` (
  `content_id` INT NOT NULL AUTO_INCREMENT ,
  `language_id` INT NOT NULL ,
  `title` VARCHAR(255) NULL ,
  `text` MEDIUMTEXT NULL ,
  PRIMARY KEY (`content_id`, `language_id`) ,
  INDEX `fk_content_language_id` (`language_id` ASC) ,
  CONSTRAINT `fk_content_language_id`
    FOREIGN KEY (`language_id` )
    REFERENCES `froxlor_billing`.`tbl_language` (`language_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `froxlor_billing`.`tbl_shopping_cart`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `froxlor_billing`.`tbl_shopping_cart` ;

CREATE  TABLE IF NOT EXISTS `froxlor_billing`.`tbl_shopping_cart` (
  `session_id` CHAR(32) NOT NULL ,
  `product_id` INT NOT NULL ,
  `quantity` INT NOT NULL ,
  INDEX `fk_shopping_cart_product_id` (`product_id` ASC) ,
  PRIMARY KEY (`session_id`, `product_id`) ,
  CONSTRAINT `fk_shopping_cart_product_id`
    FOREIGN KEY (`product_id` )
    REFERENCES `froxlor_billing`.`tbl_product` (`product_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `froxlor_billing`.`tbl_active_backend_user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `froxlor_billing`.`tbl_active_backend_user` ;

CREATE  TABLE IF NOT EXISTS `froxlor_billing`.`tbl_active_backend_user` (
  `backend_user_id` INT NOT NULL ,
  `session_id` CHAR(32) NOT NULL ,
  `start_date` TIMESTAMP NULL ,
  `expiration_date` TIMESTAMP NULL ,
  PRIMARY KEY (`backend_user_id`) ,
  INDEX `fk_active_backend_user_backend_user_id` (`backend_user_id` ASC) ,
  CONSTRAINT `fk_active_backend_user_backend_user_id`
    FOREIGN KEY (`backend_user_id` )
    REFERENCES `froxlor_billing`.`tbl_backend_user` (`backend_user_id` )
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = MyISAM;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `froxlor_billing`.`tbl_language`
-- -----------------------------------------------------
START TRANSACTION;
USE `froxlor_billing`;
INSERT INTO `froxlor_billing`.`tbl_language` (`language_id`, `language_name`, `iso_code`) VALUES (1, 'Deutsch', 'de-de');
INSERT INTO `froxlor_billing`.`tbl_language` (`language_id`, `language_name`, `iso_code`) VALUES (2, 'English', 'en-us');

COMMIT;

-- -----------------------------------------------------
-- Data for table `froxlor_billing`.`tbl_country`
-- -----------------------------------------------------
START TRANSACTION;
USE `froxlor_billing`;
INSERT INTO `froxlor_billing`.`tbl_country` (`country_id`, `language_id`, `iso_code`, `country_name`) VALUES (1, 1, 'DE', 'Deutschland');
INSERT INTO `froxlor_billing`.`tbl_country` (`country_id`, `language_id`, `iso_code`, `country_name`) VALUES (1, 2, 'DE', 'Germany');
INSERT INTO `froxlor_billing`.`tbl_country` (`country_id`, `language_id`, `iso_code`, `country_name`) VALUES (2, 1, 'AT', 'Österreich');
INSERT INTO `froxlor_billing`.`tbl_country` (`country_id`, `language_id`, `iso_code`, `country_name`) VALUES (2, 2, 'AT', 'Austria');
INSERT INTO `froxlor_billing`.`tbl_country` (`country_id`, `language_id`, `iso_code`, `country_name`) VALUES (3, 1, 'CH', 'Schweiz');
INSERT INTO `froxlor_billing`.`tbl_country` (`country_id`, `language_id`, `iso_code`, `country_name`) VALUES (3, 2, 'CH', 'Switzerland');

COMMIT;

-- -----------------------------------------------------
-- Data for table `froxlor_billing`.`tbl_order_status`
-- -----------------------------------------------------
START TRANSACTION;
USE `froxlor_billing`;
INSERT INTO `froxlor_billing`.`tbl_order_status` (`order_status_id`, `language_id`, `description`) VALUES (1, 1, 'offen');
INSERT INTO `froxlor_billing`.`tbl_order_status` (`order_status_id`, `language_id`, `description`) VALUES (1, 2, 'pending');
INSERT INTO `froxlor_billing`.`tbl_order_status` (`order_status_id`, `language_id`, `description`) VALUES (2, 1, 'abgeschlossen');
INSERT INTO `froxlor_billing`.`tbl_order_status` (`order_status_id`, `language_id`, `description`) VALUES (2, 2, 'completed');

COMMIT;

-- -----------------------------------------------------
-- Data for table `froxlor_billing`.`tbl_invoice_status`
-- -----------------------------------------------------
START TRANSACTION;
USE `froxlor_billing`;
INSERT INTO `froxlor_billing`.`tbl_invoice_status` (`invoice_status_id`, `language_id`, `description`) VALUES (1, 1, 'offen');
INSERT INTO `froxlor_billing`.`tbl_invoice_status` (`invoice_status_id`, `language_id`, `description`) VALUES (1, 2, 'pending');
INSERT INTO `froxlor_billing`.`tbl_invoice_status` (`invoice_status_id`, `language_id`, `description`) VALUES (2, 1, 'bezahlt');
INSERT INTO `froxlor_billing`.`tbl_invoice_status` (`invoice_status_id`, `language_id`, `description`) VALUES (2, 2, 'payed');

COMMIT;

-- -----------------------------------------------------
-- Data for table `froxlor_billing`.`tbl_currency`
-- -----------------------------------------------------
START TRANSACTION;
USE `froxlor_billing`;
INSERT INTO `froxlor_billing`.`tbl_currency` (`currency_id`, `title`, `code`, `symbol`, `decimal_point`, `thousands_point`, `decimal_places`) VALUES (1, 'Euro', 'EUR', '€', ',', '.', '2');
INSERT INTO `froxlor_billing`.`tbl_currency` (`currency_id`, `title`, `code`, `symbol`, `decimal_point`, `thousands_point`, `decimal_places`) VALUES (2, 'US Dollar', 'USD', '$', '.', '.', '2');

COMMIT;

-- -----------------------------------------------------
-- Data for table `froxlor_billing`.`tbl_tax`
-- -----------------------------------------------------
START TRANSACTION;
USE `froxlor_billing`;
INSERT INTO `froxlor_billing`.`tbl_tax` (`tax_id`, `tax_rate`) VALUES (1, 0.0);
INSERT INTO `froxlor_billing`.`tbl_tax` (`tax_id`, `tax_rate`) VALUES (2, 19.0);

COMMIT;

-- -----------------------------------------------------
-- Data for table `froxlor_billing`.`tbl_product`
-- -----------------------------------------------------
START TRANSACTION;
USE `froxlor_billing`;
INSERT INTO `froxlor_billing`.`tbl_product` (`product_id`, `language_id`, `title`, `contract_periode`, `description`, `quantity`, `price`, `active`) VALUES (1, 1, 'Beispielprodukt', 12, 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam', 100, 10.0, true);

COMMIT;

-- -----------------------------------------------------
-- Data for table `froxlor_billing`.`tbl_product_attribute`
-- -----------------------------------------------------
START TRANSACTION;
USE `froxlor_billing`;
INSERT INTO `froxlor_billing`.`tbl_product_attribute` (`product_attribute_id`, `language_id`, `description`) VALUES (1, 1, 'Speicherplatz');
INSERT INTO `froxlor_billing`.`tbl_product_attribute` (`product_attribute_id`, `language_id`, `description`) VALUES (1, 2, 'Disk Space');
INSERT INTO `froxlor_billing`.`tbl_product_attribute` (`product_attribute_id`, `language_id`, `description`) VALUES (2, 1, 'E-Mail Postfächer');
INSERT INTO `froxlor_billing`.`tbl_product_attribute` (`product_attribute_id`, `language_id`, `description`) VALUES (2, 2, 'eMail Inboxes');
INSERT INTO `froxlor_billing`.`tbl_product_attribute` (`product_attribute_id`, `language_id`, `description`) VALUES (3, 1, 'Inklusivvolumen');
INSERT INTO `froxlor_billing`.`tbl_product_attribute` (`product_attribute_id`, `language_id`, `description`) VALUES (3, 2, 'Traffic');

COMMIT;

-- -----------------------------------------------------
-- Data for table `froxlor_billing`.`tbl_product_info`
-- -----------------------------------------------------
START TRANSACTION;
USE `froxlor_billing`;
INSERT INTO `froxlor_billing`.`tbl_product_info` (`product_id`, `attribute_id`, `value`) VALUES (1, 1, '250');

COMMIT;

-- -----------------------------------------------------
-- Data for table `froxlor_billing`.`tbl_customizing`
-- -----------------------------------------------------
START TRANSACTION;
USE `froxlor_billing`;
INSERT INTO `froxlor_billing`.`tbl_customizing` (`key`, `language_id`, `value`) VALUES ('site_title', 1, 'Froxlorcloud');
INSERT INTO `froxlor_billing`.`tbl_customizing` (`key`, `language_id`, `value`) VALUES ('site_title', 2, 'Froxlorcloud');
INSERT INTO `froxlor_billing`.`tbl_customizing` (`key`, `language_id`, `value`) VALUES ('default_language', NULL, '1');
INSERT INTO `froxlor_billing`.`tbl_customizing` (`key`, `language_id`, `value`) VALUES ('min_password_length', NULL, '8');
INSERT INTO `froxlor_billing`.`tbl_customizing` (`key`, `language_id`, `value`) VALUES ('sys_gender_male', NULL, 'm');
INSERT INTO `froxlor_billing`.`tbl_customizing` (`key`, `language_id`, `value`) VALUES ('sys_gender_female', NULL, 'f');
INSERT INTO `froxlor_billing`.`tbl_customizing` (`key`, `language_id`, `value`) VALUES ('sys_customer_prefix', NULL, 'K');
INSERT INTO `froxlor_billing`.`tbl_customizing` (`key`, `language_id`, `value`) VALUES ('sys_invoice_prefix', NULL, 'R');
INSERT INTO `froxlor_billing`.`tbl_customizing` (`key`, `language_id`, `value`) VALUES ('business_standard_invoice_status', NULL, '1');
INSERT INTO `froxlor_billing`.`tbl_customizing` (`key`, `language_id`, `value`) VALUES ('business_standard_order_status', NULL, '1');
INSERT INTO `froxlor_billing`.`tbl_customizing` (`key`, `language_id`, `value`) VALUES ('business_standard_payment_periode', NULL, '14');
INSERT INTO `froxlor_billing`.`tbl_customizing` (`key`, `language_id`, `value`) VALUES ('business_company_name', NULL, 'Froxlor Hosting Company');
INSERT INTO `froxlor_billing`.`tbl_customizing` (`key`, `language_id`, `value`) VALUES ('business_company_president', NULL, 'Max Mustermann');
INSERT INTO `froxlor_billing`.`tbl_customizing` (`key`, `language_id`, `value`) VALUES ('business_payment_bank_account', NULL, '12345678');
INSERT INTO `froxlor_billing`.`tbl_customizing` (`key`, `language_id`, `value`) VALUES ('business_payment_bank_code', NULL, '09871100');
INSERT INTO `froxlor_billing`.`tbl_customizing` (`key`, `language_id`, `value`) VALUES ('business_payment_swift_code', NULL, 'DE0111111111');
INSERT INTO `froxlor_billing`.`tbl_customizing` (`key`, `language_id`, `value`) VALUES ('business_company_street', NULL, 'Mustergasse 1a');
INSERT INTO `froxlor_billing`.`tbl_customizing` (`key`, `language_id`, `value`) VALUES ('business_company_founder_year', NULL, '2012');
INSERT INTO `froxlor_billing`.`tbl_customizing` (`key`, `language_id`, `value`) VALUES ('business_company_city', NULL, 'Musterstadt');
INSERT INTO `froxlor_billing`.`tbl_customizing` (`key`, `language_id`, `value`) VALUES ('business_company_post_code', NULL, '12345');
INSERT INTO `froxlor_billing`.`tbl_customizing` (`key`, `language_id`, `value`) VALUES ('business_company_tel', NULL, '49 123 456789');
INSERT INTO `froxlor_billing`.`tbl_customizing` (`key`, `language_id`, `value`) VALUES ('business_company_fax', NULL, '49 123 09876543');
INSERT INTO `froxlor_billing`.`tbl_customizing` (`key`, `language_id`, `value`) VALUES ('sys_product_attribute_discspace', NULL, '1');
INSERT INTO `froxlor_billing`.`tbl_customizing` (`key`, `language_id`, `value`) VALUES ('business_froxlor_client_prefix', NULL, 'FBS');
INSERT INTO `froxlor_billing`.`tbl_customizing` (`key`, `language_id`, `value`) VALUES ('business_payment_bank_name', NULL, 'Hausbank');
INSERT INTO `froxlor_billing`.`tbl_customizing` (`key`, `language_id`, `value`) VALUES ('business_payment_tax_id_number', NULL, '0987654321');
INSERT INTO `froxlor_billing`.`tbl_customizing` (`key`, `language_id`, `value`) VALUES ('business_company_email', NULL, 'info@projektplatz.eu');
INSERT INTO `froxlor_billing`.`tbl_customizing` (`key`, `language_id`, `value`) VALUES ('business_company_webpage', NULL, 'http://projektplatz.eu');
INSERT INTO `froxlor_billing`.`tbl_customizing` (`key`, `language_id`, `value`) VALUES ('business_company_country', NULL, 'Germany');
INSERT INTO `froxlor_billing`.`tbl_customizing` (`key`, `language_id`, `value`) VALUES ('business_company_billing_sender', NULL, 'billing@projektplatz.eu');
INSERT INTO `froxlor_billing`.`tbl_customizing` (`key`, `language_id`, `value`) VALUES ('business_payment_payment_terms_id', NULL, '1');

COMMIT;

-- -----------------------------------------------------
-- Data for table `froxlor_billing`.`tbl_backend_user`
-- -----------------------------------------------------
START TRANSACTION;
USE `froxlor_billing`;
INSERT INTO `froxlor_billing`.`tbl_backend_user` (`backend_user_id`, `first_name`, `last_name`, `password`, `email`) VALUES (1, 'Admin', 'Admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'admin@projektplatz.eu');

COMMIT;

-- -----------------------------------------------------
-- Data for table `froxlor_billing`.`tbl_reminder_type`
-- -----------------------------------------------------
START TRANSACTION;
USE `froxlor_billing`;
INSERT INTO `froxlor_billing`.`tbl_reminder_type` (`reminder_type_id`, `language_id`, `title`) VALUES (1, 1, 'Erste Mahnung');
INSERT INTO `froxlor_billing`.`tbl_reminder_type` (`reminder_type_id`, `language_id`, `title`) VALUES (1, 2, 'first reminder');
INSERT INTO `froxlor_billing`.`tbl_reminder_type` (`reminder_type_id`, `language_id`, `title`) VALUES (2, 1, 'Zweite Mahnung');
INSERT INTO `froxlor_billing`.`tbl_reminder_type` (`reminder_type_id`, `language_id`, `title`) VALUES (2, 2, 'second reminder');

COMMIT;

-- -----------------------------------------------------
-- Data for table `froxlor_billing`.`tbl_content`
-- -----------------------------------------------------
START TRANSACTION;
USE `froxlor_billing`;
INSERT INTO `froxlor_billing`.`tbl_content` (`content_id`, `language_id`, `title`, `text`) VALUES (1, 1, 'Impressum', 'Hier kommt ein Impressum hin!');
INSERT INTO `froxlor_billing`.`tbl_content` (`content_id`, `language_id`, `title`, `text`) VALUES (1, 2, 'imprint', 'This will be the imprint');
INSERT INTO `froxlor_billing`.`tbl_content` (`content_id`, `language_id`, `title`, `text`) VALUES (2, 1, 'Startseite', 'Eine ganz tolle Startseite');
INSERT INTO `froxlor_billing`.`tbl_content` (`content_id`, `language_id`, `title`, `text`) VALUES (2, 2, 'home', 'This will be the landing page');
INSERT INTO `froxlor_billing`.`tbl_content` (`content_id`, `language_id`, `title`, `text`) VALUES (3, 1, 'Allgemeine Geschäftsbedingungen', '<div align=\"center\"><b>Allgemeine Geschäftsbedingungen (AGB)</b></div><br />');

COMMIT;
