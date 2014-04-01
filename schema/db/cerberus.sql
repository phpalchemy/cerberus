
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- USER
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `USER`;

CREATE TABLE `USER`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(128) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `first_name` VARCHAR(128) NOT NULL,
    `last_name` VARCHAR(128) NOT NULL,
    `create_date` DATETIME,
    `update_date` DATETIME,
    `status` VARCHAR(64) DEFAULT 'ACTIVE',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- PERMISSION
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `PERMISSION`;

CREATE TABLE `PERMISSION`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(256) NOT NULL,
    `create_date` DATETIME,
    `description` VARCHAR(256) NOT NULL,
    `update_date` DATETIME,
    `status` VARCHAR(64) DEFAULT 'ACTIVE',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- ROLE
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `ROLE`;

CREATE TABLE `ROLE`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(128) NOT NULL,
    `description` VARCHAR(256) NOT NULL,
    `create_date` DATETIME,
    `update_date` DATETIME,
    `status` VARCHAR(64) DEFAULT 'ACTIVE',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- USER_ROLE
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `USER_ROLE`;

CREATE TABLE `USER_ROLE`
(
    `user_id` INTEGER NOT NULL,
    `role_id` INTEGER NOT NULL,
    PRIMARY KEY (`user_id`,`role_id`),
    INDEX `USER_ROLE_FI_2` (`role_id`),
    CONSTRAINT `USER_ROLE_FK_1`
        FOREIGN KEY (`user_id`)
        REFERENCES `USER` (`id`)
        ON DELETE CASCADE,
    CONSTRAINT `USER_ROLE_FK_2`
        FOREIGN KEY (`role_id`)
        REFERENCES `ROLE` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- ROLE_PERMISSION
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `ROLE_PERMISSION`;

CREATE TABLE `ROLE_PERMISSION`
(
    `role_id` INTEGER NOT NULL,
    `permission_id` INTEGER NOT NULL,
    PRIMARY KEY (`role_id`,`permission_id`),
    INDEX `ROLE_PERMISSION_FI_2` (`permission_id`),
    CONSTRAINT `ROLE_PERMISSION_FK_1`
        FOREIGN KEY (`role_id`)
        REFERENCES `ROLE` (`id`)
        ON DELETE CASCADE,
    CONSTRAINT `ROLE_PERMISSION_FK_2`
        FOREIGN KEY (`permission_id`)
        REFERENCES `PERMISSION` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- LOGIN_LOG
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `LOGIN_LOG`;

CREATE TABLE `LOGIN_LOG`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `type` VARCHAR(32),
    `date_time` DATETIME,
    `user_id` VARCHAR(256),
    `username` VARCHAR(128),
    `session_id` VARCHAR(64),
    `client_address` VARCHAR(128),
    `client_ip` VARCHAR(16),
    `client_agent` VARCHAR(128),
    `client_platform` VARCHAR(64),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
