/*!40101 SET NAMES binary*/;
/*!40014 SET FOREIGN_KEY_CHECKS=0*/;

CREATE TABLE `wp_csshero` (
  `step_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `step_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `step_type` varchar(30) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `step_name` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `step_data` mediumblob NOT NULL,
  `step_theme` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `step_context` varchar(30) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `step_active_flag` varchar(3) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  UNIQUE KEY `step_id` (`step_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
