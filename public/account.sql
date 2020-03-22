/*
 Navicat Premium Data Transfer

 Source Server         : huangxu'Mac
 Source Server Type    : MySQL
 Source Server Version : 80019
 Source Host           : localhost
 Source Database       : ylmember

 Target Server Type    : MySQL
 Target Server Version : 80019
 File Encoding         : utf-8

 Date: 03/18/2020 13:18:33 PM
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `account`
-- ----------------------------
DROP TABLE IF EXISTS `account`;
CREATE TABLE `account` (
  `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `type` tinyint unsigned NOT NULL DEFAULT '0' COMMENT '类型(0为支付宝,1为微信,2为银行卡,默认0)',
  `member_id` int unsigned NOT NULL DEFAULT '0' COMMENT '会员',
  `name` varchar(50) NOT NULL DEFAULT '0' COMMENT '姓名',
  `account` varchar(50) NOT NULL DEFAULT '0' COMMENT '账号',
  `mobile` varchar(11) NOT NULL DEFAULT '0' COMMENT '手机号码',
  `extend_field` text COMMENT '拓展字段(包含发卡行,发卡行所在省市等)',
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`) USING BTREE,
  KEY `type` (`type`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='用户提现账号信息';

SET FOREIGN_KEY_CHECKS = 1;
