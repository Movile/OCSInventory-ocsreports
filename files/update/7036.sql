UNLOCK TABLES;

CREATE TABLE IF NOT EXISTS `software_homologated` (
    `ID` INTEGER NOT NULL AUTO_INCREMENT,
    `SOFTWARE_ID` INTEGER NOT NULL,
    `SOFTWARE_VERSION_ID` INTEGER NOT NULL,
    `SOFTWARE_PUBLISHER_ID` INTEGER NOT NULL,
    PRIMARY KEY (`ID`),
    FOREIGN KEY (`SOFTWARE_ID`)
        REFERENCES `software`(`ID`),
    FOREIGN KEY (`SOFTWARE_VERSION_ID`)
        REFERENCES `software_version`(`ID`),
    FOREIGN KEY (`SOFTWARE_PUBLISHER_ID`)
        REFERENCES `software_publisher`(`ID`)

) ENGINE=InnoDB DEFAULT CHARSET=UTF8;

CREATE TABLE IF NOT EXISTS `occurence` (
    `ID` INTEGER NOT NULL AUTO_INCREMENT,
    `DESCRIPTION` VARCHAR(255) DEFAULT NULL,
    `HARDWARE_ID` INTEGER DEFAULT NULL,
    `GENERIC_FIELD` VARCHAR(255) DEFAULT NULL,
    `OCCURRENCES_CATEGORY_ID` INTEGER DEFAULT NULL,
    `TIMESTAMP` TIMESTAMP NOT NULL,
    PRIMARY KEY (`ID`),
    FOREIGN KEY (`OCCURRENCES_CATEGORY_ID`)
        REFERENCES `occurence_category`(`ID`),
    FOREIGN KEY (`HARDWARE_ID`)
        REFERENCES `hardware`(`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=UTF8;

CREATE TABLE IF NOT EXISTS `occurence_category` (
    `ID` INTEGER NOT NULL AUTO_INCREMENT,
    `NAME` VARCHAR(255) NOT NULL UNIQUE,
    `DESCRIPTION` VARCHAR(255) DEFAULT NULL,
    PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=UTF8;



INSERT INTO occurence_category (ID, NAME, DESCRIPTION) VALUES (1, 'Usage of not homologated software');