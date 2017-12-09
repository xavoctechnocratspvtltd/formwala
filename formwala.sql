/*
Navicat MySQL Data Transfer

Source Server         : Localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : xepan2

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-12-09 14:43:13
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `formwala_applicant`
-- ----------------------------
DROP TABLE IF EXISTS `formwala_applicant`;
CREATE TABLE `formwala_applicant` (
  `contact_id` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `local_country_id` int(11) DEFAULT NULL,
  `local_state_id` int(11) DEFAULT NULL,
  `local_city` varchar(255) DEFAULT NULL,
  `local_address` varchar(255) DEFAULT NULL,
  `local_pin_code` varchar(255) DEFAULT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `mobile_no` varchar(255) DEFAULT NULL,
  `email_id` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `marital_status` varchar(255) DEFAULT NULL,
  `blood_group` varchar(255) DEFAULT NULL,
  `guardian_name` varchar(255) DEFAULT NULL,
  `occupation_of_guardian` varchar(255) DEFAULT NULL,
  `annual_family_income` int(11) DEFAULT NULL,
  `guardian_contact_no` varchar(255) DEFAULT NULL,
  `course_1` varchar(255) DEFAULT NULL,
  `name_of_institute_1` varchar(255) DEFAULT NULL,
  `board_university_1` varchar(255) DEFAULT NULL,
  `year_1` varchar(255) DEFAULT NULL,
  `percentage_of_marks_1` float DEFAULT NULL,
  `special_subjects_1` varchar(255) NOT NULL,
  `course_2` varchar(255) DEFAULT NULL,
  `name_of_institute_2` varchar(255) DEFAULT NULL,
  `board_university_2` varchar(255) DEFAULT NULL,
  `year_2` varchar(255) DEFAULT NULL,
  `percentage_of_marks_2` float(255,0) DEFAULT NULL,
  `special_subjects_2` varchar(255) DEFAULT NULL,
  `course_3` varchar(255) DEFAULT NULL,
  `name_of_institute_3` varchar(255) DEFAULT NULL,
  `board_university_3` varchar(255) DEFAULT NULL,
  `year_3` varchar(255) DEFAULT NULL,
  `percentage_of_marks_3` float DEFAULT NULL,
  `special_subjects_3` varchar(255) DEFAULT NULL,
  `course_4` varchar(255) DEFAULT NULL,
  `name_of_institute_4` varchar(255) DEFAULT NULL,
  `board_university_4` varchar(255) DEFAULT NULL,
  `year_4` varchar(255) DEFAULT NULL,
  `percentage_of_marks_4` float DEFAULT NULL,
  `special_subjects_4` varchar(255) DEFAULT NULL,
  `course_5` varchar(255) DEFAULT NULL,
  `name_of_institute_5` varchar(255) DEFAULT NULL,
  `board_university_5` varchar(255) DEFAULT NULL,
  `year_5` varchar(255) DEFAULT NULL,
  `percentage_of_marks_5` varchar(255) DEFAULT NULL,
  `special_subjects_5` varchar(255) DEFAULT NULL,
  `course_6` varchar(255) DEFAULT NULL,
  `name_of_institute_6` varchar(255) DEFAULT NULL,
  `board_university_6` varchar(255) DEFAULT NULL,
  `year_6` varchar(255) DEFAULT NULL,
  `percentage_of_marks_6` varchar(255) DEFAULT NULL,
  `special_subjects_6` varchar(255) DEFAULT NULL,
  `course_7` varchar(255) DEFAULT NULL,
  `name_of_institute_7` varchar(255) DEFAULT NULL,
  `board_university_7` varchar(255) DEFAULT NULL,
  `year_7` varchar(255) DEFAULT NULL,
  `percentage_of_marks_7` float DEFAULT NULL,
  `special_subjects_7` varchar(255) DEFAULT NULL,
  `course_8` varchar(255) DEFAULT NULL,
  `name_of_institute_8` varchar(255) DEFAULT NULL,
  `board_university_8` varchar(255) DEFAULT NULL,
  `year_8` varchar(255) DEFAULT NULL,
  `percentage_of_marks_8` float DEFAULT NULL,
  `special_subjects_8` varchar(255) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `first_college_id` int(11) DEFAULT NULL,
  `secord_college_id` int(11) DEFAULT NULL,
  `third_college_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of formwala_applicant
-- ----------------------------
INSERT INTO `formwala_applicant` VALUES ('144621', '5', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);

-- ----------------------------
-- Table structure for `formwala_applicant_course_college_asso`
-- ----------------------------
DROP TABLE IF EXISTS `formwala_applicant_course_college_asso`;
CREATE TABLE `formwala_applicant_course_college_asso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `college_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `applicant_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of formwala_applicant_course_college_asso
-- ----------------------------

-- ----------------------------
-- Table structure for `formwala_college_course_association`
-- ----------------------------
DROP TABLE IF EXISTS `formwala_college_course_association`;
CREATE TABLE `formwala_college_course_association` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `college_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of formwala_college_course_association
-- ----------------------------
INSERT INTO `formwala_college_course_association` VALUES ('1', '144615', '1');
INSERT INTO `formwala_college_course_association` VALUES ('2', '144616', '1');
INSERT INTO `formwala_college_course_association` VALUES ('3', '144615', '2');

-- ----------------------------
-- Table structure for `formwala_course`
-- ----------------------------
DROP TABLE IF EXISTS `formwala_course`;
CREATE TABLE `formwala_course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `image_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_image_id` (`image_id`),
  CONSTRAINT `fk_image_id` FOREIGN KEY (`image_id`) REFERENCES `filestore_file` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of formwala_course
-- ----------------------------
INSERT INTO `formwala_course` VALUES ('3', 'BCA', 'Active', '8274');
INSERT INTO `formwala_course` VALUES ('4', 'MCA', 'Active', '8277');
INSERT INTO `formwala_course` VALUES ('5', 'B.Tech', 'Active', '8280');
INSERT INTO `formwala_course` VALUES ('6', 'M.Tech', 'Active', '8283');
