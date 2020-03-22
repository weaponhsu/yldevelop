/*
 Navicat Premium Data Transfer

 Source Server         : huangxu'Mac
 Source Server Type    : MySQL
 Source Server Version : 80019
 Source Host           : localhost
 Source Database       : develop

 Target Server Type    : MySQL
 Target Server Version : 80019
 File Encoding         : utf-8

 Date: 03/22/2020 11:49:31 AM
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `access`
-- ----------------------------
DROP TABLE IF EXISTS `access`;
CREATE TABLE `access` (
  `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `rule_id` int unsigned NOT NULL DEFAULT '0' COMMENT '角色',
  `menu_id` int unsigned NOT NULL DEFAULT '0' COMMENT '菜单',
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_menu_unique` (`rule_id`,`menu_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='权限表';

-- ----------------------------
--  Records of `access`
-- ----------------------------
BEGIN;
INSERT INTO `access` VALUES ('2', '1', '4'), ('3', '1', '7'), ('4', '1', '8'), ('5', '1', '9'), ('17', '1', '10'), ('1', '1', '11'), ('6', '2', '3'), ('7', '2', '12'), ('8', '2', '13'), ('9', '2', '14'), ('10', '2', '15'), ('11', '2', '16'), ('12', '3', '17'), ('13', '3', '18'), ('14', '3', '19'), ('15', '3', '20'), ('16', '3', '21'), ('18', '5', '22'), ('19', '5', '23'), ('20', '5', '24'), ('21', '5', '25'), ('22', '5', '26'), ('23', '5', '27'), ('24', '5', '28'), ('25', '6', '29'), ('26', '6', '30'), ('27', '6', '31'), ('28', '6', '32'), ('29', '6', '33'), ('38', '8', '36'), ('37', '8', '37'), ('36', '8', '38');
COMMIT;

-- ----------------------------
--  Table structure for `albums`
-- ----------------------------
DROP TABLE IF EXISTS `albums`;
CREATE TABLE `albums` (
  `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `type` tinyint unsigned NOT NULL DEFAULT '0' COMMENT '类型(0为主贴的图片,1为产品的图片,2为回帖的图片)',
  `album` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci COMMENT '图片的序列化字符串',
  `stats` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '审核状态(0为未审核,1为已审核,2为审核不通过)',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '编辑时间',
  `updated_by` int unsigned NOT NULL DEFAULT '0' COMMENT '审核人员',
  PRIMARY KEY (`id`),
  KEY `type` (`type`) USING BTREE,
  KEY `stats` (`stats`) USING BTREE,
  KEY `updated_by` (`updated_by`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='图片表';

-- ----------------------------
--  Records of `albums`
-- ----------------------------
BEGIN;
INSERT INTO `albums` VALUES ('16', '0', 'a:2:{i:0;s:22:\"/public/upload/123.png\";i:1;s:22:\"/public/upload/234.jpg\";}', '1', '2019-02-15 14:26:06', '2019-02-15 14:26:06', '0'), ('20', '1', 'a:2:{i:0;s:28:\"/public/upload/product_1.jpg\";i:1;s:28:\"/public/upload/product_2.png\";}', '1', '2019-02-16 18:56:16', '2019-02-16 18:56:16', '0'), ('22', '1', 'a:2:{i:0;s:28:\"/public/upload/product_1.jpg\";i:1;s:28:\"/public/upload/product_2.png\";}', '1', '2019-02-16 19:09:54', '2019-02-16 19:09:54', '0'), ('24', '1', 'a:2:{i:0;s:25:\"/public/upload/reply1.jpg\";i:1;s:25:\"/public/upload/reply2.png\";}', '1', '2019-02-18 12:01:45', '2019-02-18 12:01:45', '0'), ('25', '1', 'a:2:{i:0;s:25:\"/public/upload/reply1.jpg\";i:1;s:25:\"/public/upload/reply2.png\";}', '1', '2019-02-18 12:02:21', '2019-02-18 12:02:21', '0'), ('26', '1', 'a:2:{i:0;s:25:\"/public/upload/reply1.jpg\";i:1;s:25:\"/public/upload/reply2.png\";}', '1', '2019-02-18 12:02:42', '2019-02-18 12:02:42', '0'), ('27', '0', 'a:1:{i:0;s:30:\"/upload/post/5c7492a31b4ca.jpg\";}', '1', '2019-02-26 09:17:20', '2019-02-26 09:17:20', '0'), ('28', '0', 'a:4:{i:0;s:30:\"/upload/post/5c7496b798957.jpg\";i:1;s:30:\"/upload/post/5c7496ba4be54.jpg\";i:2;s:30:\"/upload/post/5c7496bd3a371.jpg\";i:3;s:30:\"/upload/post/5c7496bfbd95c.jpg\";}', '1', '2019-02-26 09:33:09', '2019-02-26 09:33:09', '0'), ('29', '0', 'a:2:{i:0;s:30:\"/upload/post/5c74977bd790e.jpg\";i:1;s:30:\"/upload/post/5c74977e9d800.jpg\";}', '1', '2019-02-26 09:33:51', '2019-02-26 09:33:51', '0'), ('30', '0', 'a:6:{i:0;s:30:\"/upload/post/5c749856e5b7e.jpg\";i:1;s:30:\"/upload/post/5c7498598edec.jpg\";i:2;s:30:\"/upload/post/5c74985c2690b.jpg\";i:3;s:30:\"/upload/post/5c74985f63a91.jpg\";i:4;s:30:\"/upload/post/5c749861ac367.jpg\";i:5;s:30:\"/upload/post/5c74986433c68.jpg\";}', '1', '2019-02-26 09:37:42', '2019-02-26 09:37:42', '0'), ('31', '0', 'a:2:{i:0;s:30:\"/upload/post/5c749da4d1ffc.jpg\";i:1;s:30:\"/upload/post/5c749da7e94cd.jpg\";}', '1', '2019-02-26 10:00:10', '2019-02-26 10:00:10', '0'), ('32', '0', 'a:1:{i:0;s:30:\"/upload/post/5c749dda15d86.jpg\";}', '1', '2019-02-26 10:01:53', '2019-02-26 10:01:53', '0'), ('33', '0', 'a:2:{i:0;s:30:\"/upload/post/5c749e670e874.jpg\";i:1;s:30:\"/upload/post/5c749e6994ba1.jpg\";}', '1', '2019-02-26 10:03:43', '2019-02-26 10:03:43', '0'), ('34', '1', 'a:6:{i:0;s:34:\"/upload/product/5c74e5ce1a06a.jpeg\";i:1;s:34:\"/upload/product/5c74e5d0c6a15.jpeg\";i:2;s:34:\"/upload/product/5c74e5d37f755.jpeg\";i:3;s:34:\"/upload/product/5c74e5d69daac.jpeg\";i:4;s:34:\"/upload/product/5c74e5d90f686.jpeg\";i:5;s:34:\"/upload/product/5c74e5dc151ed.jpeg\";}', '1', '2019-02-26 15:08:29', '2019-02-26 15:08:29', '0'), ('35', '0', 'a:6:{i:0;s:30:\"/upload/post/5c7577acb9775.jpg\";i:1;s:30:\"/upload/post/5c7577af2d9ee.jpg\";i:2;s:30:\"/upload/post/5c7577b17cf55.jpg\";i:3;s:30:\"/upload/post/5c7577b3e2244.jpg\";i:4;s:30:\"/upload/post/5c7577b632870.jpg\";i:5;s:30:\"/upload/post/5c7577b8d8af6.jpg\";}', '1', '2019-02-27 01:30:36', '2019-02-27 01:30:36', '0'), ('36', '0', 'a:6:{i:0;s:30:\"/upload/post/5c7577acb9775.jpg\";i:1;s:30:\"/upload/post/5c7577af2d9ee.jpg\";i:2;s:30:\"/upload/post/5c7577b17cf55.jpg\";i:3;s:30:\"/upload/post/5c7577b3e2244.jpg\";i:4;s:30:\"/upload/post/5c7577b632870.jpg\";i:5;s:30:\"/upload/post/5c7577b8d8af6.jpg\";}', '1', '2019-02-27 01:30:46', '2019-02-27 01:30:46', '0'), ('37', '0', 'a:6:{i:0;s:30:\"/upload/post/5c7577acb9775.jpg\";i:1;s:30:\"/upload/post/5c7577af2d9ee.jpg\";i:2;s:30:\"/upload/post/5c7577b17cf55.jpg\";i:3;s:30:\"/upload/post/5c7577b3e2244.jpg\";i:4;s:30:\"/upload/post/5c7577b632870.jpg\";i:5;s:30:\"/upload/post/5c7577b8d8af6.jpg\";}', '1', '2019-02-27 01:31:00', '2019-02-27 01:31:00', '0'), ('38', '0', 'a:1:{i:0;s:30:\"/upload/post/5c7581cb8b5dd.jpg\";}', '1', '2019-02-27 02:13:38', '2019-02-27 02:13:38', '0'), ('39', '0', 'a:1:{i:0;s:30:\"/upload/post/5c7581cb8b5dd.jpg\";}', '1', '2019-02-27 02:13:55', '2019-02-27 02:13:55', '0'), ('40', '0', 'a:6:{i:0;s:30:\"/upload/post/5c7587743d7a8.jpg\";i:1;s:30:\"/upload/post/5c758776b8ef8.jpg\";i:2;s:30:\"/upload/post/5c75877a5b4b4.jpg\";i:3;s:30:\"/upload/post/5c75877da391d.jpg\";i:4;s:30:\"/upload/post/5c75878130ff1.jpg\";i:5;s:30:\"/upload/post/5c758783d64df.jpg\";}', '1', '2019-02-27 02:37:59', '2019-02-27 02:37:59', '0'), ('41', '1', 'a:6:{i:0;s:33:\"/upload/product/5c75c6377e899.jpg\";i:1;s:33:\"/upload/product/5c75c63a18be6.jpg\";i:2;s:33:\"/upload/product/5c75c63d39f16.jpg\";i:3;s:33:\"/upload/product/5c75c6419c80d.jpg\";i:4;s:33:\"/upload/product/5c75c6442a9c4.jpg\";i:5;s:33:\"/upload/product/5c75c64788c34.jpg\";}', '1', '2019-02-27 07:05:47', '2019-02-27 07:05:47', '0'), ('42', '1', 'a:5:{i:0;s:33:\"/upload/product/5c75cb9c6b2f4.jpg\";i:1;s:33:\"/upload/product/5c75cb9edbd4f.jpg\";i:2;s:33:\"/upload/product/5c75cba17c29e.jpg\";i:3;s:33:\"/upload/product/5c75cba476aec.jpg\";i:4;s:33:\"/upload/product/5c75cba6eeebf.jpg\";}', '1', '2019-02-27 07:29:36', '2019-02-27 07:29:36', '0'), ('43', '7', 'a:4:{i:0;s:26:\"/upload//5c76023848826.jpg\";i:1;s:26:\"/upload//5c7602384aebb.jpg\";i:2;s:26:\"/upload//5c76023853ff5.jpg\";i:3;s:26:\"/upload//5c76023856034.jpg\";}', '1', '2019-02-27 11:23:04', '2019-02-27 11:23:04', '0'), ('44', '8', 'a:3:{i:0;s:26:\"/upload//5c76071352526.jpg\";i:1;s:26:\"/upload//5c76071356d2a.png\";i:2;s:26:\"/upload//5c760713613ed.jpg\";}', '1', '2019-02-27 11:42:13', '2019-02-27 11:42:13', '0'), ('45', '8', 'a:3:{i:0;s:26:\"/upload//5c7607298b8b9.jpg\";i:1;s:26:\"/upload//5c7607298f22c.jpg\";i:2;s:26:\"/upload//5c76072992f00.jpg\";}', '1', '2019-02-27 11:42:35', '2019-02-27 11:42:35', '0'), ('46', '8', 'a:6:{i:0;s:26:\"/upload//5c76074a5d1d9.jpg\";i:1;s:26:\"/upload//5c76074a6124e.jpg\";i:2;s:26:\"/upload//5c76074a64507.jpg\";i:3;s:26:\"/upload//5c76074a66cc9.jpg\";i:4;s:26:\"/upload//5c76074a68d27.jpg\";i:5;s:26:\"/upload//5c76074a6c99d.jpg\";}', '1', '2019-02-27 11:43:08', '2019-02-27 11:43:08', '0'), ('47', '7', 'a:4:{i:0;s:26:\"/upload//5c76075e57d4c.jpg\";i:1;s:26:\"/upload//5c76075e5cec6.jpg\";i:2;s:26:\"/upload//5c76075e600c9.jpg\";i:3;s:26:\"/upload//5c76075e62ffb.jpg\";}', '1', '2019-02-27 11:43:28', '2019-02-27 11:43:28', '0'), ('48', '4', 'a:5:{i:0;s:26:\"/upload//5c7607a87e817.jpg\";i:1;s:26:\"/upload//5c7607a8830c5.jpg\";i:2;s:26:\"/upload//5c7607a886f23.jpg\";i:3;s:26:\"/upload//5c7607a88a7b3.jpg\";i:4;s:26:\"/upload//5c7607a890cd8.jpg\";}', '1', '2019-02-27 11:44:48', '2019-02-27 11:44:48', '0'), ('49', '9', 'a:4:{i:0;s:26:\"/upload//5c7607c161555.jpg\";i:1;s:26:\"/upload//5c7607c165bf3.jpg\";i:2;s:26:\"/upload//5c7607c1681ab.jpg\";i:3;s:26:\"/upload//5c7607c16a6c0.jpg\";}', '1', '2019-02-27 11:45:06', '2019-02-27 11:45:06', '0'), ('50', '8', 'a:4:{i:0;s:26:\"/upload//5c7607d960986.jpg\";i:1;s:26:\"/upload//5c7607d963ea4.jpg\";i:2;s:26:\"/upload//5c7607d9669c3.jpg\";i:3;s:26:\"/upload//5c7607d968a4f.jpg\";}', '1', '2019-02-27 11:45:30', '2019-02-27 11:45:30', '0'), ('51', '4', 'a:4:{i:0;s:26:\"/upload//5c7607f0125c1.jpg\";i:1;s:26:\"/upload//5c7607f0179d0.jpg\";i:2;s:26:\"/upload//5c7607f01c0b4.jpg\";i:3;s:26:\"/upload//5c7607f01fe15.jpg\";}', '1', '2019-02-27 11:45:53', '2019-02-27 11:45:53', '0'), ('52', '2', 'a:4:{i:0;s:26:\"/upload//5c76080a6db92.jpg\";i:1;s:26:\"/upload//5c76080a713cf.jpg\";i:2;s:26:\"/upload//5c76080a73ea3.jpg\";i:3;s:26:\"/upload//5c76080a75e6d.jpg\";}', '1', '2019-02-27 11:46:20', '2019-02-27 11:46:20', '0'), ('53', '4', 'a:9:{i:0;s:26:\"/upload//5c7608348fece.jpg\";i:1;s:26:\"/upload//5c760834935bb.jpg\";i:2;s:26:\"/upload//5c76083496283.jpg\";i:3;s:26:\"/upload//5c7608349b3af.jpg\";i:4;s:26:\"/upload//5c7608349e386.jpg\";i:5;s:26:\"/upload//5c760834de8a9.jpg\";i:6;s:26:\"/upload//5c760834ecfee.jpg\";i:7;s:26:\"/upload//5c760835161e2.jpg\";i:8;s:26:\"/upload//5c7608352d379.jpg\";}', '1', '2019-02-27 11:47:02', '2019-02-27 11:47:02', '0'), ('54', '5', 'a:4:{i:0;s:26:\"/upload//5c760851daeee.jpg\";i:1;s:26:\"/upload//5c760851ddca4.jpg\";i:2;s:26:\"/upload//5c760851e1afd.jpg\";i:3;s:26:\"/upload//5c760851e8398.jpg\";}', '1', '2019-02-27 11:47:31', '2019-02-27 11:47:31', '0'), ('55', '4', 'a:7:{i:0;s:26:\"/upload//5c760869a7548.jpg\";i:1;s:26:\"/upload//5c760869a2f9c.jpg\";i:2;s:26:\"/upload//5c760869aa277.jpg\";i:3;s:26:\"/upload//5c760869ac8dc.jpg\";i:4;s:26:\"/upload//5c760869b497f.jpg\";i:5;s:26:\"/upload//5c760869b6983.jpg\";i:6;s:26:\"/upload//5c760869cca2a.jpg\";}', '1', '2019-02-27 11:47:55', '2019-02-27 11:47:55', '0'), ('56', '3', 'a:5:{i:0;s:26:\"/upload//5c760881a0c3c.jpg\";i:1;s:26:\"/upload//5c760881a429f.jpg\";i:2;s:26:\"/upload//5c760881a678e.jpg\";i:3;s:26:\"/upload//5c760881a9dd7.jpg\";i:4;s:26:\"/upload//5c760881ade85.jpg\";}', '1', '2019-02-27 11:48:21', '2019-02-27 11:48:21', '0'), ('57', '1', 'a:5:{i:0;s:33:\"/upload/product/5c761f5423f67.jpg\";i:1;s:33:\"/upload/product/5c761f56ac481.jpg\";i:2;s:33:\"/upload/product/5c761f5944b72.jpg\";i:3;s:33:\"/upload/product/5c761f5c63655.jpg\";i:4;s:33:\"/upload/product/5c761f5ed1f2b.jpg\";}', '1', '2019-02-27 13:27:17', '2019-02-27 13:27:17', '0'), ('58', '1', 'a:1:{i:0;s:31:\"/upload/reply/5c772a10ad1e3.jpg\";}', '1', '2019-02-28 08:28:02', '2019-02-28 08:28:02', '0'), ('59', '1', 'a:3:{i:0;s:32:\"/upload/reply/5c772e1b1a4cd.jpeg\";i:1;s:32:\"/upload/reply/5c772e1da082f.jpeg\";i:2;s:32:\"/upload/reply/5c772e1fe055c.jpeg\";}', '1', '2019-02-28 08:41:05', '2019-02-28 08:41:05', '0'), ('60', '3', 'a:5:{i:0;s:27:\"/upload//5c78678c0965d.jpeg\";i:1;s:27:\"/upload//5c78678c0ea0d.jpeg\";i:2;s:27:\"/upload//5c78678c118d0.jpeg\";i:3;s:27:\"/upload//5c78678c393d3.jpeg\";i:4;s:27:\"/upload//5c78678c581c1.jpeg\";}', '1', '2019-03-01 06:58:32', '2019-03-01 06:58:32', '0'), ('61', '2', 'a:8:{i:0;s:27:\"/upload//5c7867b336068.jpeg\";i:1;s:27:\"/upload//5c7867b33a251.jpeg\";i:2;s:27:\"/upload//5c7867b34453b.jpeg\";i:3;s:27:\"/upload//5c7867b34e063.jpeg\";i:4;s:27:\"/upload//5c7867b351673.jpeg\";i:5;s:27:\"/upload//5c7867b35812e.jpeg\";i:6;s:27:\"/upload//5c7867b36b5e9.jpeg\";i:7;s:27:\"/upload//5c7867b381a55.jpeg\";}', '1', '2019-03-01 06:59:03', '2019-03-01 06:59:03', '0'), ('62', '10', 'a:5:{i:0;s:27:\"/upload//5c7867d583978.jpeg\";i:1;s:27:\"/upload//5c7867d58619b.jpeg\";i:2;s:27:\"/upload//5c7867d592fb1.jpeg\";i:3;s:27:\"/upload//5c7867d59d930.jpeg\";i:4;s:27:\"/upload//5c7867d5af465.jpeg\";}', '1', '2019-03-01 06:59:36', '2019-03-01 06:59:36', '0'), ('63', '11', 'a:7:{i:0;s:27:\"/upload//5c7867ea98d8a.jpeg\";i:1;s:27:\"/upload//5c7867ea9ca9d.jpeg\";i:2;s:27:\"/upload//5c7867ea9f439.jpeg\";i:3;s:27:\"/upload//5c7867eab11e7.jpeg\";i:4;s:27:\"/upload//5c7867eab34ce.jpeg\";i:5;s:27:\"/upload//5c7867eab71a8.jpeg\";i:6;s:27:\"/upload//5c7867eabdf56.jpeg\";}', '1', '2019-03-01 06:59:57', '2019-03-01 06:59:57', '0'), ('64', '11', 'a:5:{i:0;s:27:\"/upload//5c7868015aff6.jpeg\";i:1;s:27:\"/upload//5c7868015f64c.jpeg\";i:2;s:27:\"/upload//5c786801673bb.jpeg\";i:3;s:27:\"/upload//5c78680169544.jpeg\";i:4;s:27:\"/upload//5c7868016c0ea.jpeg\";}', '1', '2019-03-01 07:00:19', '2019-03-01 07:00:19', '0'), ('65', '11', 'a:5:{i:0;s:26:\"/upload//5c786817d9c1c.png\";i:1;s:26:\"/upload//5c786817e0b49.png\";i:2;s:26:\"/upload//5c786817eea13.png\";i:3;s:26:\"/upload//5c7868184ba8d.png\";i:4;s:26:\"/upload//5c78681865e31.png\";}', '1', '2019-03-01 07:00:42', '2019-03-01 07:00:42', '0'), ('66', '11', 'a:7:{i:0;s:27:\"/upload//5c786834bc885.jpeg\";i:1;s:27:\"/upload//5c786834c941b.jpeg\";i:2;s:27:\"/upload//5c786834d184f.jpeg\";i:3;s:27:\"/upload//5c786834dc9fa.jpeg\";i:4;s:27:\"/upload//5c786834decdd.jpeg\";i:5;s:27:\"/upload//5c786834e6ad0.jpeg\";i:6;s:27:\"/upload//5c786834ee916.jpeg\";}', '1', '2019-03-01 07:01:10', '2019-03-01 07:01:10', '0'), ('67', '10', 'a:6:{i:0;s:27:\"/upload//5c78684d5bcb1.jpeg\";i:1;s:27:\"/upload//5c78684d61c95.jpeg\";i:2;s:27:\"/upload//5c78684d64c0a.jpeg\";i:3;s:27:\"/upload//5c78684d678c9.jpeg\";i:4;s:27:\"/upload//5c78684d6d420.jpeg\";i:5;s:27:\"/upload//5c78684d74216.jpeg\";}', '1', '2019-03-01 07:01:35', '2019-03-01 07:01:35', '0'), ('68', '11', 'a:5:{i:0;s:27:\"/upload//5c78687ec5188.jpeg\";i:1;s:27:\"/upload//5c78687ed53af.jpeg\";i:2;s:26:\"/upload//5c78687f02168.png\";i:3;s:27:\"/upload//5c78687f043b0.jpeg\";i:4;s:26:\"/upload//5c78687f2e9d6.png\";}', '1', '2019-03-01 07:02:26', '2019-03-01 07:02:26', '0'), ('69', '11', 'a:5:{i:0;s:27:\"/upload//5c786898976df.jpeg\";i:1;s:27:\"/upload//5c786898a1cb1.jpeg\";i:2;s:27:\"/upload//5c786898a3e02.jpeg\";i:3;s:27:\"/upload//5c786898aab2a.jpeg\";i:4;s:26:\"/upload//5c786898d7d81.png\";}', '1', '2019-03-01 07:02:50', '2019-03-01 07:02:50', '0'), ('70', '2', 'a:2:{i:0;s:26:\"/upload//5c7868b0ae782.jpg\";i:1;s:26:\"/upload//5c7868b0b8599.jpg\";}', '1', '2019-03-01 07:03:15', '2019-03-01 07:03:15', '0'), ('71', '11', 'a:6:{i:0;s:27:\"/upload//5c7868c57b7ab.jpeg\";i:1;s:27:\"/upload//5c7868c5811f6.jpeg\";i:2;s:27:\"/upload//5c7868c584c4a.jpeg\";i:3;s:27:\"/upload//5c7868c59472b.jpeg\";i:4;s:27:\"/upload//5c7868c5bd749.jpeg\";i:5;s:27:\"/upload//5c7868c5c6e95.jpeg\";}', '1', '2019-03-01 07:03:35', '2019-03-01 07:03:35', '0'), ('72', '4', 'a:5:{i:0;s:27:\"/upload//5c7868d86f844.jpeg\";i:1;s:27:\"/upload//5c7868d87421a.jpeg\";i:2;s:27:\"/upload//5c7868d876787.jpeg\";i:3;s:27:\"/upload//5c7868d87b425.jpeg\";i:4;s:27:\"/upload//5c7868d883ed9.jpeg\";}', '1', '2019-03-01 07:03:54', '2019-03-01 07:03:54', '0'), ('73', '11', 'a:8:{i:0;s:27:\"/upload//5c7868eccce86.jpeg\";i:1;s:27:\"/upload//5c7868ecd6bd0.jpeg\";i:2;s:27:\"/upload//5c7868ecd95b8.jpeg\";i:3;s:27:\"/upload//5c7868ecebcd0.jpeg\";i:4;s:27:\"/upload//5c7868ecef324.jpeg\";i:5;s:27:\"/upload//5c7868ecf158e.jpeg\";i:6;s:27:\"/upload//5c7868ed01e57.jpeg\";i:7;s:27:\"/upload//5c7868ed08d20.jpeg\";}', '1', '2019-03-01 07:04:15', '2019-03-01 07:04:15', '0'), ('74', '1', 'a:4:{i:0;s:26:\"/upload//5c7d85f9b2da3.png\";i:1;s:26:\"/upload//5c7d85fc157ef.png\";i:2;s:26:\"/upload//5c7d85fc54bc7.png\";i:3;s:26:\"/upload//5c7d85fce6b95.png\";}', '1', '2019-03-05 04:10:21', '2019-03-05 04:10:21', '0'), ('75', '1', 'a:4:{i:0;s:26:\"/upload//5c7d8bf5223b7.png\";i:1;s:26:\"/upload//5c7d8bf5d541f.png\";i:2;s:26:\"/upload//5c7d8bf5ebbfc.png\";i:3;s:26:\"/upload//5c7d8bf602383.png\";}', '1', '2019-03-05 04:35:02', '2019-03-05 04:35:02', '0'), ('76', '1', 'a:5:{i:0;s:26:\"/upload//5c7d8c093b79c.png\";i:1;s:26:\"/upload//5c7d8c0963766.png\";i:2;s:26:\"/upload//5c7d8c098cccd.png\";i:3;s:26:\"/upload//5c7d8c09a7a34.png\";i:4;s:26:\"/upload//5c7d8c0a9717e.png\";}', '1', '2019-03-05 04:35:24', '2019-03-05 04:35:24', '0'), ('77', '1', 'a:1:{i:0;s:26:\"/upload//5c7d8ce3e8391.png\";}', '1', '2019-03-05 04:39:01', '2019-03-05 04:39:01', '0'), ('78', '1', 'a:3:{i:0;s:26:\"/upload//5c7d97989a619.jpg\";i:1;s:26:\"/upload//5c7d97989fcf3.jpg\";i:2;s:26:\"/upload//5c7d9798a4136.jpg\";}', '1', '2019-03-05 05:24:45', '2019-03-05 05:24:45', '0'), ('79', '1', 'a:4:{i:0;s:26:\"/upload//5c7d98628b399.jpg\";i:1;s:26:\"/upload//5c7d98628d5f8.jpg\";i:2;s:26:\"/upload//5c7d98628f73e.jpg\";i:3;s:26:\"/upload//5c7d9862918b3.jpg\";}', '1', '2019-03-05 05:28:05', '2019-03-05 05:28:05', '0'), ('80', '1', 'a:3:{i:0;s:26:\"/upload//5c7d98c2977e8.jpg\";i:1;s:26:\"/upload//5c7d98c29ba4c.jpg\";i:2;s:26:\"/upload//5c7d98c29ee3f.jpg\";}', '1', '2019-03-05 05:29:42', '2019-03-05 05:29:42', '0'), ('81', '1', 'a:3:{i:0;s:26:\"/upload//5c7d9becaa792.jpg\";i:1;s:26:\"/upload//5c7d9becae79d.jpg\";i:2;s:26:\"/upload//5c7d9becb09f7.jpg\";}', '1', '2019-03-05 05:43:31', '2019-03-05 05:43:31', '0'), ('82', '1', 'a:4:{i:0;s:26:\"/upload//5c7d9c354bc6a.jpg\";i:1;s:26:\"/upload//5c7d9c355724e.jpg\";i:2;s:26:\"/upload//5c7d9c355931f.jpg\";i:3;s:26:\"/upload//5c7d9c355cc5f.jpg\";}', '1', '2019-03-05 05:44:22', '2019-03-05 05:44:22', '0'), ('83', '1', 'a:3:{i:0;s:26:\"/upload//5c7d9c5e199af.jpg\";i:1;s:26:\"/upload//5c7d9c5e1ded8.jpg\";i:2;s:26:\"/upload//5c7d9c5e20f6a.jpg\";}', '1', '2019-03-05 05:45:04', '2019-03-05 05:45:04', '0'), ('84', '1', 'a:5:{i:0;s:26:\"/upload//5c7d9c8c2f34d.png\";i:1;s:26:\"/upload//5c7d9c8cdb5d1.png\";i:2;s:26:\"/upload//5c7d9c8ce1275.png\";i:3;s:26:\"/upload//5c7d9c8cf0fd2.png\";i:4;s:26:\"/upload//5c7d9c8d08592.png\";}', '1', '2019-03-05 05:45:49', '2019-03-05 05:45:49', '0'), ('85', '1', 'a:3:{i:0;s:26:\"/upload//5c7d9c9407fbd.jpg\";i:1;s:26:\"/upload//5c7d9c940a0bb.jpg\";i:2;s:26:\"/upload//5c7d9c940c1ee.jpg\";}', '1', '2019-03-05 05:45:57', '2019-03-05 05:45:57', '0'), ('86', '1', 'a:3:{i:0;s:26:\"/upload//5c7d9cc79428d.jpg\";i:1;s:26:\"/upload//5c7d9cc7982ac.jpg\";i:2;s:26:\"/upload//5c7d9cc79ae9a.jpg\";}', '1', '2019-03-05 05:46:49', '2019-03-05 05:46:49', '0'), ('87', '1', 'a:3:{i:0;s:26:\"/upload//5c7d9cdf6397e.jpg\";i:1;s:26:\"/upload//5c7d9cdf68401.jpg\";i:2;s:26:\"/upload//5c7d9cdf6c08a.jpg\";}', '1', '2019-03-05 05:47:12', '2019-03-05 05:47:12', '0'), ('97', '0', 'a:1:{i:0;s:13:\"/upload/3.png\";}', '1', '2019-10-08 12:42:33', '2019-10-08 12:42:33', '0'), ('98', '1', 'a:2:{i:0;s:13:\"/upload/4.png\";i:1;s:13:\"/upload/5.jpg\";}', '1', '2019-10-08 13:25:42', '2019-10-08 13:25:42', '0'), ('99', '1', 'a:2:{i:0;s:13:\"/upload/4.png\";i:1;s:13:\"/upload/5.jpg\";}', '1', '2019-10-08 13:26:06', '2019-10-08 13:26:06', '0'), ('100', '0', 'a:4:{i:0;s:13:\"/upload/1.png\";i:1;s:6:\"/2.png\";i:2;s:31:\"/upload/posts/5db60e3db6091.jpg\";i:3;s:31:\"/upload/posts/5db60e45c6d11.png\";}', '1', '2019-10-08 12:26:57', '2019-10-08 12:26:57', '0');
COMMIT;

-- ----------------------------
--  Table structure for `authority`
-- ----------------------------
DROP TABLE IF EXISTS `authority`;
CREATE TABLE `authority` (
  `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `rule_id` int unsigned NOT NULL COMMENT '权限',
  `role_id` int unsigned NOT NULL DEFAULT '0' COMMENT '角色',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='角色权限表';

-- ----------------------------
--  Records of `authority`
-- ----------------------------
BEGIN;
INSERT INTO `authority` VALUES ('23', '6', '1'), ('24', '5', '1'), ('25', '3', '1'), ('26', '2', '1'), ('27', '1', '1'), ('38', '8', '2'), ('39', '5', '2');
COMMIT;

-- ----------------------------
--  Table structure for `menu`
-- ----------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '0' COMMENT '显示名',
  `parent` int NOT NULL DEFAULT '0' COMMENT '上级',
  `path` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '0' COMMENT '层级关系',
  `url` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '0' COMMENT '特殊URL',
  `display` tinyint unsigned NOT NULL DEFAULT '0' COMMENT '是否显示到左侧菜单(0为否,1为是,默认0)',
  `is_operation` tinyint unsigned NOT NULL DEFAULT '0' COMMENT '是否是操作(0为否,1为是,默认0)',
  `list_order` int unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `created_by` int unsigned NOT NULL DEFAULT '0' COMMENT '创建人',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最近一次编辑时间',
  `updated_by` int unsigned NOT NULL DEFAULT '0' COMMENT '最后一次编辑人',
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`) USING BTREE,
  KEY `display` (`display`) USING BTREE,
  KEY `is_operation` (`display`) USING BTREE,
  KEY `name` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='菜单表';

-- ----------------------------
--  Records of `menu`
-- ----------------------------
BEGIN;
INSERT INTO `menu` VALUES ('1', '顶级菜单', '0', '0-', '0', '1', '0', '1', '2016-08-03 17:38:46', '66', '2020-03-16 11:02:16', '66'), ('2', '系统管理', '1', '0-1-', '0', '1', '0', '1', '2016-08-03 17:38:46', '66', '2020-03-16 11:02:16', '66'), ('3', '管理员管理', '2', '0-1-2-', '0', '1', '0', '99', '2016-10-02 14:40:55', '66', '2020-03-16 11:02:16', '66'), ('4', '角色管理', '2', '0-1-2-', '0', '1', '0', '12', '2016-09-20 14:05:40', '66', '2020-03-16 11:02:16', '66'), ('7', '查询角色', '4', '0-1-2-4-', '/admin/role/list', '0', '1', '1', '2018-12-25 15:35:02', '66', '2020-03-16 11:02:16', '66'), ('8', '创建角色', '4', '0-1-2-4-', '/admin/role/create', '0', '1', '2', '2018-12-25 15:35:34', '66', '2020-03-16 11:02:16', '66'), ('9', '编辑角色', '4', '0-1-2-4-', '/admin/role/edit', '0', '1', '3', '2018-12-25 15:35:56', '66', '2020-03-16 11:02:16', '66'), ('10', '删除角色', '4', '0-1-2-4-', '/admin/role/delete', '0', '1', '4', '2018-12-25 15:36:21', '66', '2020-03-16 11:02:16', '66'), ('11', '批量删除角色', '4', '0-1-2-4-', '/admin/role/batchDelete', '0', '1', '5', '2018-12-25 15:36:38', '66', '2020-03-16 11:02:16', '66'), ('12', '查询后台账号', '3', '0-1-2-3-', '/admin/user/list', '0', '1', '1', '2018-12-25 15:36:57', '66', '2020-03-16 11:02:16', '66'), ('13', '创建后台账号', '3', '0-1-2-3-', '/admin/user/create', '0', '1', '2', '2018-12-25 15:37:15', '66', '2020-03-16 11:02:16', '66'), ('14', '编辑后台账号', '3', '0-1-2-3-', '/admin/user/edit', '0', '1', '3', '2018-12-25 15:37:33', '66', '2020-03-16 11:02:16', '66'), ('15', '删除后台账号', '3', '0-1-2-3-', '/admin/user/delete', '0', '1', '4', '2018-12-25 15:37:54', '66', '2020-03-16 11:02:16', '66'), ('16', '批量删除后台账号', '3', '0-1-2-3-', '/admin/user/batchDelete', '0', '1', '5', '2018-12-25 15:38:12', '66', '2020-03-16 11:02:16', '66'), ('17', '权限管理', '2', '0-1-2-', '0', '1', '0', '1', '2020-03-12 09:51:53', '66', '2020-03-16 11:02:16', '66'), ('18', '创建权限', '17', '0-1-2-17-', '/admin/access/create', '0', '1', '1', '2020-03-12 09:53:42', '66', '2020-03-16 11:02:16', '66'), ('19', '浏览权限', '17', '0-1-2-17-', '/admin/access/list', '0', '1', '1', '2020-03-12 09:54:02', '66', '2020-03-16 11:02:16', '66'), ('20', '编辑权限', '17', '0-1-2-17-', '/admin/access/edit', '0', '1', '1', '2020-03-12 09:54:22', '66', '2020-03-16 11:02:16', '66'), ('21', '删除权限', '17', '0-1-2-17-', '/admin/access/delete', '0', '1', '1', '2020-03-12 09:54:42', '66', '2020-03-16 11:02:16', '66'), ('22', '会员管理', '1', '0-1-', '0', '1', '0', '0', '2020-03-13 12:39:23', '66', '2020-03-16 11:02:16', '66'), ('23', '会员管理', '22', '0-1-22-', '0', '1', '0', '0', '2020-03-13 12:40:20', '66', '2020-03-16 11:02:16', '66'), ('24', '浏览会员', '23', '0-1-22-23-', '/admin/member/list', '0', '1', '1', '2020-03-13 12:40:54', '66', '2020-03-16 11:02:16', '66'), ('25', '编辑会员', '23', '0-1-22-23-', '/admin/member/edit', '0', '1', '1', '2020-03-13 12:41:21', '66', '2020-03-16 11:02:16', '66'), ('26', '浏览单个会员信息', '23', '0-1-22-23-', '/admin/member/info', '0', '1', '1', '2020-03-13 12:41:50', '66', '2020-03-16 11:02:16', '66'), ('27', '删除会员', '23', '0-1-22-23-', '/admin/member/delete', '0', '1', '1', '2020-03-13 12:42:14', '66', '2020-03-16 11:02:16', '66'), ('28', '批量删除会员', '23', '0-1-22-23-', '/admin/member/batchdelete', '0', '1', '1', '2020-03-13 12:42:38', '66', '2020-03-16 11:02:16', '66'), ('29', '菜单管理', '2', '0-1-2-', '0', '1', '0', '1', '2020-03-13 18:44:37', '66', '2020-03-16 11:02:16', '66'), ('30', '浏览菜单', '29', '0-1-2-29-', '/admin/menu/list', '0', '1', '1', '2020-03-13 18:45:07', '66', '2020-03-16 11:02:16', '66'), ('31', '创建菜单', '29', '0-1-2-29-', '/admin/menu/create', '0', '1', '1', '2020-03-13 18:45:31', '66', '2020-03-16 11:02:16', '66'), ('32', '编辑菜单', '29', '0-1-2-29-', '/admin/menu/edit', '0', '1', '1', '2020-03-13 18:45:49', '66', '2020-03-16 11:02:16', '66'), ('33', '删除菜单', '29', '0-1-2-29-', '/admin/menu/delete', '0', '1', '1', '2020-03-13 18:46:12', '66', '2020-03-16 11:02:16', '66'), ('34', '1688商品分类管理', '2', '0-1-2-', '', '1', '0', '1', '2016-08-03 17:38:46', '66', '2020-03-16 11:01:55', '66'), ('36', '1688商品分类列表接口', '34', '0-1-2-34-', '/admin/category/list', '0', '1', '1', '2016-08-03 17:38:46', '66', '2020-03-16 11:01:55', '66'), ('37', '1688商品分类创建接口', '34', '0-1-2-34-', '/admin/category/create', '0', '1', '1', '2016-08-03 17:38:46', '66', '2020-03-16 11:01:54', '66'), ('38', '1688商品分类编辑接口', '34', '0-1-2-34-', '/admin/category/edit', '0', '1', '0', '2016-08-03 17:38:46', '66', '2020-03-15 23:42:18', '66');
COMMIT;

-- ----------------------------
--  Table structure for `role`
-- ----------------------------
DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '0' COMMENT '角色',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `created_by` int unsigned NOT NULL DEFAULT '0' COMMENT '创建人',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后一次修改时间',
  `updated_by` int unsigned NOT NULL DEFAULT '0' COMMENT '最后一次修改人',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='角色表';

-- ----------------------------
--  Records of `role`
-- ----------------------------
BEGIN;
INSERT INTO `role` VALUES ('1', '超级管理员', '2018-12-25 08:50:56', '66', '2020-03-16 11:01:12', '66'), ('2', '管理员', '2019-01-04 05:36:06', '66', '2020-03-16 12:27:19', '66');
COMMIT;

-- ----------------------------
--  Table structure for `rule`
-- ----------------------------
DROP TABLE IF EXISTS `rule`;
CREATE TABLE `rule` (
  `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(16) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0' COMMENT '权限名称',
  `stats` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '状态(0为否,1为是,默认1)',
  `created_by` int unsigned NOT NULL DEFAULT '0' COMMENT '创建者',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_by` int unsigned NOT NULL DEFAULT '0' COMMENT '更新者',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='权限表';

-- ----------------------------
--  Records of `rule`
-- ----------------------------
BEGIN;
INSERT INTO `rule` VALUES ('1', '后台角色管理', '1', '66', '2020-03-12 09:42:06', '66', '2020-03-16 11:01:40'), ('2', '后台账号管理', '1', '66', '2020-03-12 09:42:20', '66', '2020-03-16 11:01:38'), ('3', '后台权限管理', '1', '66', '2020-03-12 09:42:35', '66', '2020-03-16 11:01:34'), ('4', '订单管理', '1', '66', '2020-03-12 09:42:43', '66', '2020-03-16 11:01:35'), ('5', '会员管理', '1', '66', '2020-03-12 09:42:48', '66', '2020-03-16 11:01:36'), ('6', '后台菜单管理', '1', '66', '2020-03-13 18:46:40', '66', '2020-03-13 18:46:40'), ('8', '阿里巴巴产品管理员', '0', '66', '2020-03-16 00:06:05', '66', '2020-03-16 00:21:44');
COMMIT;

-- ----------------------------
--  Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `username` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '0' COMMENT '登录名',
  `password` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '0' COMMENT '密码',
  `google_secret` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '0' COMMENT '谷歌认证器',
  `role` int unsigned NOT NULL DEFAULT '0' COMMENT '角色',
  `mobile` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '0' COMMENT '手机号码',
  `stats` tinyint unsigned NOT NULL DEFAULT '0' COMMENT '状态(0为封禁,1为允许登录,默认0)',
  `uuid` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '0' COMMENT 'uuid',
  `last_login_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '上次登录时间',
  `login_times` int unsigned NOT NULL DEFAULT '0' COMMENT '登录次数',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `created_by` int unsigned NOT NULL DEFAULT '0' COMMENT '创建人',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '最后一次修改时间',
  `updated_by` int unsigned NOT NULL DEFAULT '0' COMMENT '最后一次修改人',
  PRIMARY KEY (`id`),
  UNIQUE KEY `mobile` (`mobile`) USING BTREE,
  UNIQUE KEY `username` (`username`) USING BTREE,
  KEY `stats` (`stats`) USING BTREE,
  KEY `role` (`role`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=193 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='后台账号表';

-- ----------------------------
--  Records of `user`
-- ----------------------------
BEGIN;
INSERT INTO `user` VALUES ('66', '13333333333', '$P$BZS5YTkXJeFknzjBB5yyOZ7tqVX7GU0', 'NNXMLV2SONUMJDAP', '1', '13333333333', '1', '1lqn6jzp06pbmd9w', '2020-03-16 10:48:06', '44', '2018-12-25 08:50:48', '66', '2020-01-31 10:36:32', '66');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
