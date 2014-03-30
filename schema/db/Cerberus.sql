
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- user
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user`
(
    `usr_id` INTEGER NOT NULL AUTO_INCREMENT,
    `usr_username` VARCHAR(128) NOT NULL,
    `usr_password` VARCHAR(32) NOT NULL,
    `usr_first_name` VARCHAR(128) NOT NULL,
    `usr_last_name` VARCHAR(128) NOT NULL,
    `usr_create_date` DATETIME,
    `usr_update_date` DATETIME,
    `usr_status` VARCHAR(64) DEFAULT 'ACTIVE',
    PRIMARY KEY (`usr_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- permission
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `permission`;

CREATE TABLE `permission`
(
    `prm_id` INTEGER NOT NULL AUTO_INCREMENT,
    `prm_name` VARCHAR(256) NOT NULL,
    `prm_create_date` DATETIME,
    `prm_update_date` DATETIME,
    `prm_status` VARCHAR(64) DEFAULT 'ACTIVE',
    PRIMARY KEY (`prm_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- rol
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `rol`;

CREATE TABLE `rol`
(
    `rol_id` INTEGER NOT NULL AUTO_INCREMENT,
    `rol_name` VARCHAR(128) NOT NULL,
    `rol_description` VARCHAR(128) NOT NULL,
    `rol_create_date` DATETIME,
    `rol_update_date` DATETIME,
    `rol_status` VARCHAR(64) DEFAULT 'ACTIVE',
    PRIMARY KEY (`rol_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- user_rol
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user_rol`;

CREATE TABLE `user_rol`
(
    `usr_id` INTEGER NOT NULL,
    `rol_id` INTEGER NOT NULL,
    PRIMARY KEY (`usr_id`,`rol_id`),
    INDEX `user_rol_FI_2` (`rol_id`),
    CONSTRAINT `user_rol_FK_1`
        FOREIGN KEY (`usr_id`)
        REFERENCES `user` (`usr_id`)
        ON DELETE CASCADE,
    CONSTRAINT `user_rol_FK_2`
        FOREIGN KEY (`rol_id`)
        REFERENCES `rol` (`rol_id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- rol_permission
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `rol_permission`;

CREATE TABLE `rol_permission`
(
    `rol_id` INTEGER NOT NULL,
    `prm_id` INTEGER NOT NULL,
    PRIMARY KEY (`rol_id`,`prm_id`),
    INDEX `rol_permission_FI_2` (`prm_id`),
    CONSTRAINT `rol_permission_FK_1`
        FOREIGN KEY (`rol_id`)
        REFERENCES `rol` (`rol_id`)
        ON DELETE CASCADE,
    CONSTRAINT `rol_permission_FK_2`
        FOREIGN KEY (`prm_id`)
        REFERENCES `permission` (`prm_id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
