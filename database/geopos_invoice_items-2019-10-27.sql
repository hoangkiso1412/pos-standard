/*
 Navicat Premium Data Transfer

 Source Server         : localhost_3307
 Source Server Type    : MySQL
 Source Server Version : 100138
 Source Host           : localhost:3307
 Source Schema         : standard-pos

 Target Server Type    : MySQL
 Target Server Version : 100138
 File Encoding         : 65001

 Date: 27/10/2019 01:17:07
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for geopos_invoice_items
-- ----------------------------
DROP TABLE IF EXISTS `geopos_invoice_items`;
CREATE TABLE `geopos_invoice_items`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL,
  `pid` int(11) NOT NULL DEFAULT 0,
  `product` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `code` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `qty` decimal(10, 2) NOT NULL DEFAULT 0.00,
  `price` decimal(16, 2) NOT NULL DEFAULT 0.00,
  `tax` decimal(16, 2) NULL DEFAULT 0.00,
  `discount` decimal(16, 2) NULL DEFAULT 0.00,
  `subtotal` decimal(16, 2) NULL DEFAULT 0.00,
  `totaltax` decimal(16, 2) NULL DEFAULT 0.00,
  `totaldiscount` decimal(16, 2) NULL DEFAULT 0.00,
  `product_des` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `i_class` int(1) NOT NULL DEFAULT 0,
  `unit` varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `product_stock_id` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `invoice`(`tid`) USING BTREE,
  INDEX `i_class`(`i_class`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
