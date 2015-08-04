/*
Navicat MySQL Data Transfer

Source Server         : Mysql - Localhost
Source Server Version : 50516
Source Host           : localhost:3306
Source Database       : standarisasi_kemendagri

Target Server Type    : MYSQL
Target Server Version : 50516
File Encoding         : 65001

Date: 2015-08-04 18:06:45
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `idx_level_user`
-- ----------------------------
DROP TABLE IF EXISTS `idx_level_user`;
CREATE TABLE `idx_level_user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nama_level` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of idx_level_user
-- ----------------------------
INSERT INTO `idx_level_user` VALUES ('2', 'Assesor');
INSERT INTO `idx_level_user` VALUES ('3', 'Kepala LSP');
INSERT INTO `idx_level_user` VALUES ('4', 'Manajer Sertifikasi');
INSERT INTO `idx_level_user` VALUES ('5', 'Bendahara');
INSERT INTO `idx_level_user` VALUES ('6', 'Komisi Sertifikasi');
INSERT INTO `idx_level_user` VALUES ('7', 'Admin TUK');
INSERT INTO `idx_level_user` VALUES ('99', 'Super Admin');

-- ----------------------------
-- Table structure for `idx_menu_module`
-- ----------------------------
DROP TABLE IF EXISTS `idx_menu_module`;
CREATE TABLE `idx_menu_module` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nama_module` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of idx_menu_module
-- ----------------------------
INSERT INTO `idx_menu_module` VALUES ('1', 'Dashboard');
INSERT INTO `idx_menu_module` VALUES ('2', 'Manajemen Konten');
INSERT INTO `idx_menu_module` VALUES ('3', 'Master Data');
INSERT INTO `idx_menu_module` VALUES ('4', 'Sertifikasi');
INSERT INTO `idx_menu_module` VALUES ('5', 'PAK');
INSERT INTO `idx_menu_module` VALUES ('6', 'Laporan');

-- ----------------------------
-- Table structure for `idx_menu_policy`
-- ----------------------------
DROP TABLE IF EXISTS `idx_menu_policy`;
CREATE TABLE `idx_menu_policy` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `idx_submodule_id` bigint(20) DEFAULT NULL,
  `idx_level_user_id` int(11) DEFAULT NULL,
  `is_access` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of idx_menu_policy
-- ----------------------------
INSERT INTO `idx_menu_policy` VALUES ('1', '1', '99', '1');
INSERT INTO `idx_menu_policy` VALUES ('2', '2', '99', '1');
INSERT INTO `idx_menu_policy` VALUES ('3', '3', '99', '1');
INSERT INTO `idx_menu_policy` VALUES ('4', '4', '99', '1');
INSERT INTO `idx_menu_policy` VALUES ('5', '5', '99', '1');
INSERT INTO `idx_menu_policy` VALUES ('6', '6', '99', '1');
INSERT INTO `idx_menu_policy` VALUES ('7', '7', '99', '1');
INSERT INTO `idx_menu_policy` VALUES ('8', '8', '99', '1');
INSERT INTO `idx_menu_policy` VALUES ('9', '9', '99', '1');
INSERT INTO `idx_menu_policy` VALUES ('10', '10', '99', '1');
INSERT INTO `idx_menu_policy` VALUES ('11', '11', '99', '1');
INSERT INTO `idx_menu_policy` VALUES ('12', '12', '99', '1');
INSERT INTO `idx_menu_policy` VALUES ('13', '13', '99', '1');
INSERT INTO `idx_menu_policy` VALUES ('14', '14', '99', '1');
INSERT INTO `idx_menu_policy` VALUES ('15', '15', '99', '1');
INSERT INTO `idx_menu_policy` VALUES ('16', '16', '99', '1');
INSERT INTO `idx_menu_policy` VALUES ('17', '17', '99', '1');
INSERT INTO `idx_menu_policy` VALUES ('18', '18', '99', '1');
INSERT INTO `idx_menu_policy` VALUES ('19', '19', '99', '1');
INSERT INTO `idx_menu_policy` VALUES ('20', '20', '99', '1');
INSERT INTO `idx_menu_policy` VALUES ('21', '21', '99', '1');
INSERT INTO `idx_menu_policy` VALUES ('22', '22', '99', '1');
INSERT INTO `idx_menu_policy` VALUES ('23', '23', '99', '1');
INSERT INTO `idx_menu_policy` VALUES ('24', '24', '99', '1');
INSERT INTO `idx_menu_policy` VALUES ('25', '25', '99', '1');
INSERT INTO `idx_menu_policy` VALUES ('26', '26', '99', '1');
INSERT INTO `idx_menu_policy` VALUES ('27', '27', '99', '1');
INSERT INTO `idx_menu_policy` VALUES ('28', '28', '99', '1');
INSERT INTO `idx_menu_policy` VALUES ('29', '15', '2', '1');
INSERT INTO `idx_menu_policy` VALUES ('30', '16', '2', '1');
INSERT INTO `idx_menu_policy` VALUES ('31', '17', '2', '1');
INSERT INTO `idx_menu_policy` VALUES ('32', '20', '2', '1');
INSERT INTO `idx_menu_policy` VALUES ('33', '21', '2', '1');
INSERT INTO `idx_menu_policy` VALUES ('34', '15', '5', '1');
INSERT INTO `idx_menu_policy` VALUES ('35', '18', '5', '1');
INSERT INTO `idx_menu_policy` VALUES ('36', '29', '99', '1');
INSERT INTO `idx_menu_policy` VALUES ('37', '15', '7', '1');
INSERT INTO `idx_menu_policy` VALUES ('38', '19', '7', '1');
INSERT INTO `idx_menu_policy` VALUES ('39', '30', '99', '1');
INSERT INTO `idx_menu_policy` VALUES ('40', '31', '99', '1');

-- ----------------------------
-- Table structure for `idx_menu_submodule`
-- ----------------------------
DROP TABLE IF EXISTS `idx_menu_submodule`;
CREATE TABLE `idx_menu_submodule` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `idx_module_id` bigint(20) DEFAULT NULL,
  `nama_submodule` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of idx_menu_submodule
-- ----------------------------
INSERT INTO `idx_menu_submodule` VALUES ('1', '2', 'Main Menu');
INSERT INTO `idx_menu_submodule` VALUES ('2', '2', 'Berita');
INSERT INTO `idx_menu_submodule` VALUES ('3', '2', 'Petunjuk Dokumen');
INSERT INTO `idx_menu_submodule` VALUES ('4', '2', 'FAQ');
INSERT INTO `idx_menu_submodule` VALUES ('5', '3', 'Main Menu');
INSERT INTO `idx_menu_submodule` VALUES ('6', '3', 'Manajemen User');
INSERT INTO `idx_menu_submodule` VALUES ('7', '3', 'Program Studi');
INSERT INTO `idx_menu_submodule` VALUES ('8', '3', 'Lembaga/Instansi');
INSERT INTO `idx_menu_submodule` VALUES ('9', '3', 'Hirarki Aparatur');
INSERT INTO `idx_menu_submodule` VALUES ('10', '3', 'Persyaratan Sertifikasi');
INSERT INTO `idx_menu_submodule` VALUES ('11', '3', 'Uji Mandiri');
INSERT INTO `idx_menu_submodule` VALUES ('12', '3', 'Manajemen TUK');
INSERT INTO `idx_menu_submodule` VALUES ('13', '3', 'Jadwal Ujian');
INSERT INTO `idx_menu_submodule` VALUES ('14', '3', 'Voucher');
INSERT INTO `idx_menu_submodule` VALUES ('15', '4', 'Main Menu');
INSERT INTO `idx_menu_submodule` VALUES ('16', '4', 'Registrasi Peserta');
INSERT INTO `idx_menu_submodule` VALUES ('17', '4', 'Asesmen Mandiri');
INSERT INTO `idx_menu_submodule` VALUES ('18', '4', 'Pembayaran');
INSERT INTO `idx_menu_submodule` VALUES ('19', '4', 'Uji Tulis');
INSERT INTO `idx_menu_submodule` VALUES ('20', '4', 'Uji Simulasi');
INSERT INTO `idx_menu_submodule` VALUES ('21', '4', 'Wawancara');
INSERT INTO `idx_menu_submodule` VALUES ('22', '4', 'Hasil Akhir');
INSERT INTO `idx_menu_submodule` VALUES ('23', '4', 'Print Sertifikat');
INSERT INTO `idx_menu_submodule` VALUES ('24', '5', 'Main Menu');
INSERT INTO `idx_menu_submodule` VALUES ('25', '5', 'PAK Inpassing');
INSERT INTO `idx_menu_submodule` VALUES ('26', '5', 'PAK Result');
INSERT INTO `idx_menu_submodule` VALUES ('27', '6', 'Main Menu');
INSERT INTO `idx_menu_submodule` VALUES ('28', '6', 'Peserta');
INSERT INTO `idx_menu_submodule` VALUES ('29', '3', 'Pangkat/Golongan');
INSERT INTO `idx_menu_submodule` VALUES ('30', '4', 'Remedial Peserta');
INSERT INTO `idx_menu_submodule` VALUES ('31', '3', 'Bank Soal');

-- ----------------------------
-- Table structure for `tbl_user_admin`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_user_admin`;
CREATE TABLE `tbl_user_admin` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `real_name` varchar(255) NOT NULL,
  `level_admin` tinyint(4) NOT NULL COMMENT '99- Admin, 55 Assesor',
  `email` varchar(255) NOT NULL,
  `aktif` tinyint(4) NOT NULL,
  `nip_user` varchar(255) NOT NULL,
  `idx_tuk_id` int(11) DEFAULT NULL,
  `idx_keahlian` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_user_admin
-- ----------------------------
INSERT INTO `tbl_user_admin` VALUES ('1', 'admin', 'qy5gfT2w5Ui4EoScdFtoOFePOW5Tiq+IeV9et6cEbt4cwBGcPzWhZXGidlZi1qwBOpuUcK5peVG/4SVzF9BoTg==', 'Administrator', '99', 'admin@diklat.com', '1', '1101010010101', null, null);
