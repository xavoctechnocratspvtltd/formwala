/*
Navicat MySQL Data Transfer

Source Server         : Localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : template_15

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-01-17 13:08:30
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
  `father_name` varchar(255) DEFAULT NULL,
  `mother_name` varchar(255) DEFAULT NULL,
  `occupation_of_father` int(11) DEFAULT NULL,
  `occupation_of_mother` varchar(255) DEFAULT NULL,
  `course_1` varchar(255) DEFAULT NULL,
  `name_of_institute_1` varchar(255) DEFAULT NULL,
  `board_university_1` varchar(255) DEFAULT NULL,
  `year_1` varchar(255) DEFAULT NULL,
  `percentage_of_marks_1` float DEFAULT NULL,
  `course_2` varchar(255) DEFAULT NULL,
  `name_of_institute_2` varchar(255) DEFAULT NULL,
  `board_university_2` varchar(255) DEFAULT NULL,
  `year_2` varchar(255) DEFAULT NULL,
  `percentage_of_marks_2` float(255,0) DEFAULT NULL,
  `course_3` varchar(255) DEFAULT NULL,
  `name_of_institute_3` varchar(255) DEFAULT NULL,
  `board_university_3` varchar(255) DEFAULT NULL,
  `year_3` varchar(255) DEFAULT NULL,
  `percentage_of_marks_3` float DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `first_college_id` int(11) DEFAULT NULL,
  `secord_college_id` int(11) DEFAULT NULL,
  `third_college_id` int(11) DEFAULT NULL,
  `father_contact_no` varchar(255) DEFAULT NULL,
  `mother_contact_no` varchar(255) DEFAULT NULL,
  `course_4` varchar(255) DEFAULT NULL,
  `name_of_institute_4` varchar(255) DEFAULT NULL,
  `board_university_4` varchar(255) DEFAULT NULL,
  `year_4` int(11) DEFAULT NULL,
  `percentage_of_marks_4` int(11) DEFAULT NULL,
  `aadhar_no` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for `formwala_applicant_course_college_asso`
-- ----------------------------
DROP TABLE IF EXISTS `formwala_applicant_course_college_asso`;
CREATE TABLE `formwala_applicant_course_college_asso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `college_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `applicant_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;


-- ----------------------------
-- Table structure for `formwala_college_course_association`
-- ----------------------------
DROP TABLE IF EXISTS `formwala_college_course_association`;
CREATE TABLE `formwala_college_course_association` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `college_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for `formwala_course`
-- ----------------------------
DROP TABLE IF EXISTS `formwala_course`;
CREATE TABLE `formwala_course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `image_id` int(10) unsigned DEFAULT NULL,
  `is_link` tinyint(1) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_image_id` (`image_id`),
  CONSTRAINT `fk_image_id` FOREIGN KEY (`image_id`) REFERENCES `filestore_file` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
