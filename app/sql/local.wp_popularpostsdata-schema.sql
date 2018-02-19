/*!40101 SET NAMES binary*/;
/*!40014 SET FOREIGN_KEY_CHECKS=0*/;

CREATE TABLE `wp_popularpostsdata` (
  `postid` bigint(20) NOT NULL,
  `day` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_viewed` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `pageviews` bigint(20) DEFAULT '1',
  PRIMARY KEY (`postid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
