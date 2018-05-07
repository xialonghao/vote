# Host: 119.28.15.235  (Version: 5.5.46)
# Date: 2018-05-07 14:34:59
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "table_vote"
#

DROP TABLE IF EXISTS `table_vote`;
CREATE TABLE `table_vote` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL COMMENT '被投票人',
  `asid` int(11) NOT NULL DEFAULT '0' COMMENT '投票人',
  `inputtime` datetime DEFAULT NULL COMMENT '时间',
  `content` varchar(255) DEFAULT NULL COMMENT '内容',
  `waiver` mediumint(9) DEFAULT NULL COMMENT '弃权',
  `display_type` tinyint(1) DEFAULT NULL COMMENT '计数',
  `obey` tinyint(3) DEFAULT NULL COMMENT '服从能力',
  `work` tinyint(3) DEFAULT NULL COMMENT '做事能力',
  `commun` tinyint(3) DEFAULT NULL COMMENT '沟通能力',
  `grade` tinyint(3) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=utf8 COMMENT='投票';

#
# Data for table "table_vote"
#

/*!40000 ALTER TABLE `table_vote` DISABLE KEYS */;
INSERT INTO `table_vote` VALUES (1,6,61,'2018-04-08 13:37:03','呜哈哈',1,NULL,80,100,70,NULL),(2,4,51,'2018-04-08 13:37:03','呜呼呼',0,NULL,100,100,100,NULL),(3,1,41,'2018-04-08 13:37:03','啦哈哈',0,1,100,20,30,NULL),(36,0,61,'2018-04-08 16:19:40','',NULL,NULL,80,80,80,NULL),(37,0,3,'2018-04-22 21:32:01','',0,NULL,80,100,100,NULL),(38,0,3,'2018-04-22 21:34:18','',0,NULL,60,100,100,NULL),(39,0,3,'2018-04-22 21:34:18','',0,NULL,100,100,100,NULL);
/*!40000 ALTER TABLE `table_vote` ENABLE KEYS */;
