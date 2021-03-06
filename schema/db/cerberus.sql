
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- user
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user`
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
-- role
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `role`;

CREATE TABLE `role`
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
-- permission
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `permission`;

CREATE TABLE `permission`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(256) NOT NULL,
    `create_date` DATETIME,
    `description` VARCHAR(256) NOT NULL,
    `update_date` DATETIME,
    `status` VARCHAR(64) DEFAULT 'ACTIVE',
    `parent_id` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `permission_fi_6457b6` (`parent_id`),
    CONSTRAINT `permission_fk_6457b6`
        FOREIGN KEY (`parent_id`)
        REFERENCES `permission` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- user_role
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user_role`;

CREATE TABLE `user_role`
(
    `user_id` INTEGER NOT NULL,
    `role_id` INTEGER NOT NULL,
    PRIMARY KEY (`user_id`,`role_id`),
    INDEX `user_role_fi_1ff99e` (`role_id`),
    CONSTRAINT `user_role_fk_29554a`
        FOREIGN KEY (`user_id`)
        REFERENCES `user` (`id`)
        ON DELETE CASCADE,
    CONSTRAINT `user_role_fk_1ff99e`
        FOREIGN KEY (`role_id`)
        REFERENCES `role` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- role_permission
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `role_permission`;

CREATE TABLE `role_permission`
(
    `role_id` INTEGER NOT NULL,
    `permission_id` INTEGER NOT NULL,
    PRIMARY KEY (`role_id`,`permission_id`),
    INDEX `role_permission_fi_2b894c` (`permission_id`),
    CONSTRAINT `role_permission_fk_1ff99e`
        FOREIGN KEY (`role_id`)
        REFERENCES `role` (`id`)
        ON DELETE CASCADE,
    CONSTRAINT `role_permission_fk_2b894c`
        FOREIGN KEY (`permission_id`)
        REFERENCES `permission` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- log
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `log`;

CREATE TABLE `log`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `type` VARCHAR(32),
    `date_time` DATETIME,
    `log_text` TEXT,
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
