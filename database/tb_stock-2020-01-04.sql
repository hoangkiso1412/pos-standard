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

 Date: 04/01/2020 23:37:28
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for tb_stock
-- ----------------------------
DROP TABLE IF EXISTS `tb_stock`;
CREATE TABLE `tb_stock`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NULL DEFAULT NULL,
  `warehouse_id` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `body_number` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `engine_number` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `plate_number` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `other_expense` decimal(10, 2) NULL DEFAULT NULL,
  `total` decimal(10, 2) NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `purchase_date` date NULL DEFAULT NULL,
  `sold_date` date NULL DEFAULT NULL,
  `purchase_id` int(11) NULL DEFAULT NULL,
  `sale_detail_id` int(11) NULL DEFAULT NULL,
  `selling_price` decimal(10, 2) NULL DEFAULT NULL,
  `paid_amount` decimal(10, 2) NULL DEFAULT NULL,
  `remain_amount` decimal(10, 2) NULL DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `tax` decimal(16, 2) NULL DEFAULT NULL,
  `discount` decimal(10, 2) NULL DEFAULT NULL,
  `subtotal` decimal(10, 2) NULL DEFAULT NULL,
  `totaltax` decimal(16, 2) NULL DEFAULT NULL,
  `totaldiscount` decimal(16, 2) NULL DEFAULT NULL,
  `product_des` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `unit` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `purchase_paid_amount` decimal(10, 2) NULL DEFAULT NULL,
  `purchase_remain_amount` decimal(10, 2) NULL DEFAULT NULL,
  `purchase_qty` int(11) NULL DEFAULT NULL,
  `profit_amount` decimal(10, 2) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
