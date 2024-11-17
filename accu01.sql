/*
MySQL Backup
Source Server Version: 5.6.17
Source Database: accu01
Date: 9/19/2022 21:24:49
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
--  Table structure for `acc_account_types`
-- ----------------------------
DROP TABLE IF EXISTS `acc_account_types`;
CREATE TABLE `acc_account_types` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(50) NOT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `acc_bank_account`
-- ----------------------------
DROP TABLE IF EXISTS `acc_bank_account`;
CREATE TABLE `acc_bank_account` (
  `account_id` int(4) NOT NULL AUTO_INCREMENT,
  `account_name` varchar(100) NOT NULL,
  `account_code` varchar(20) DEFAULT NULL,
  `credit_limit` double DEFAULT NULL,
  `account_status` char(1) DEFAULT NULL,
  `business_id` int(4) DEFAULT NULL,
  `account_type_id` int(11) NOT NULL,
  `last_reconcil` date DEFAULT NULL,
  PRIMARY KEY (`account_id`),
  KEY `business_id` (`business_id`),
  CONSTRAINT `acc_bank_account_ibfk_1` FOREIGN KEY (`business_id`) REFERENCES `acc_business` (`business_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records 
-- ----------------------------
INSERT INTO `acc_account_types` VALUES ('1','Fixed Deposits Account'), ('2','Checking Account'), ('3','Savings Account'), ('4','Other');
INSERT INTO `acc_bank_account` VALUES ('1','BOC-8065','B8065','70000','1','1','2','2021-03-29'), ('2','NTB-253625','N25','80000','1','1','0','0000-00-00');
