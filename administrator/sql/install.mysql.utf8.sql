CREATE TABLE IF NOT EXISTS `#__cg_dictionary` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`word` VARCHAR(255)  NOT NULL ,
`definition` TEXT NOT NULL ,
`family` VARCHAR(255) DEFAULT '',
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;