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

 Date: 27/10/2019 01:16:45
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for geopos_invoices
-- ----------------------------
DROP TABLE IF EXISTS `geopos_invoices`;
CREATE TABLE `geopos_invoices`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL,
  `invoicedate` date NOT NULL,
  `invoiceduedate` date NOT NULL,
  `subtotal` decimal(16, 2) NULL DEFAULT 0.00,
  `shipping` decimal(16, 2) NULL DEFAULT 0.00,
  `ship_tax` decimal(16, 2) NULL DEFAULT NULL,
  `ship_tax_type` enum('incl','excl','off') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'off',
  `discount` decimal(16, 2) NULL DEFAULT 0.00,
  `discount_rate` decimal(10, 2) NULL DEFAULT 0.00,
  `tax` decimal(16, 2) NULL DEFAULT 0.00,
  `total` decimal(16, 2) NULL DEFAULT 0.00,
  `pmethod` varchar(14) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `notes` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `status` enum('paid','due','canceled','partial') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'due',
  `csd` int(5) NOT NULL DEFAULT 0,
  `eid` int(4) NOT NULL,
  `pamnt` decimal(16, 2) NULL DEFAULT 0.00,
  `items` decimal(10, 2) NOT NULL,
  `taxstatus` enum('yes','no','incl','cgst','igst') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'yes',
  `discstatus` tinyint(1) NOT NULL,
  `format_discount` enum('%','flat','b_p','bflat') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '%',
  `refer` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `term` int(3) NOT NULL,
  `multi` int(4) NULL DEFAULT NULL,
  `i_class` int(1) NOT NULL DEFAULT 0,
  `loc` int(4) NOT NULL,
  `r_time` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `customer_info` varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `eid`(`eid`) USING BTREE,
  INDEX `csd`(`csd`) USING BTREE,
  INDEX `invoice`(`tid`) USING BTREE,
  INDEX `i_class`(`i_class`) USING BTREE,
  INDEX `loc`(`loc`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
