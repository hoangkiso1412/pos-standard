/*
 Navicat Premium Data Transfer

 Source Server         : localhost_3307
 Source Server Type    : MySQL
 Source Server Version : 100138
 Source Host           : localhost:3307
 Source Schema         : pos-moto

 Target Server Type    : MySQL
 Target Server Version : 100138
 File Encoding         : 65001

 Date: 12/12/2019 00:16:25
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for geopos_register
-- ----------------------------
DROP TABLE IF EXISTS `geopos_register`;
CREATE TABLE `geopos_register`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `o_date` datetime(0) NOT NULL,
  `c_date` datetime(0) NOT NULL,
  `cash` decimal(16, 2) NOT NULL,
  `card` decimal(16, 2) NOT NULL,
  `bank` decimal(16, 2) NOT NULL,
  `cheque` decimal(16, 2) NOT NULL,
  `r_change` decimal(16, 2) NOT NULL,
  `active` int(1) NOT NULL DEFAULT 0,
  `in_amount` decimal(16, 2) NULL DEFAULT 0.00,
  `out_amount` decimal(16, 2) NULL DEFAULT 0.00,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `active`(`active`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for geopos_transactions
-- ----------------------------
DROP TABLE IF EXISTS `geopos_transactions`;
CREATE TABLE `geopos_transactions`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `acid` int(11) NOT NULL,
  `account` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `type` enum('Income','Expense','Transfer') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `cat` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `debit` decimal(16, 2) NULL DEFAULT 0.00,
  `credit` decimal(16, 2) NULL DEFAULT 0.00,
  `payer` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `payerid` int(11) NOT NULL DEFAULT 0,
  `method` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `date` date NOT NULL,
  `tid` int(11) NOT NULL DEFAULT 0,
  `eid` int(11) NOT NULL,
  `note` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `ext` int(1) NULL DEFAULT 0,
  `loc` int(4) NULL DEFAULT NULL,
  `other_id` int(11) NULL DEFAULT 0,
  `remain_amount` decimal(16, 2) NOT NULL DEFAULT 0.00,
  `cash_id` int(11) NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `loc`(`loc`) USING BTREE,
  INDEX `acid`(`acid`) USING BTREE,
  INDEX `eid`(`eid`) USING BTREE,
  INDEX `tid`(`tid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 26 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
