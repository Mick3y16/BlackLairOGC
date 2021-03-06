/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS = @@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION = @@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


DROP TABLE IF EXISTS `ogc_users`;
CREATE TABLE IF NOT EXISTS `ogc_users` (
  `id`        INT(10)      NOT NULL AUTO_INCREMENT COMMENT 'Identifier',
  `username`  VARCHAR(32)  NOT NULL,
  `firstname` VARCHAR(32)  NOT NULL,
  `lastname`  VARCHAR(32)  NOT NULL,
  `email`     VARCHAR(255) NOT NULL,
  `joindate`  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
)
  ENGINE =MyISAM
  DEFAULT CHARSET =utf8
  COMMENT ='Account System'
  AUTO_INCREMENT =1;

/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS = @OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION = @OLD_COLLATION_CONNECTION */;
