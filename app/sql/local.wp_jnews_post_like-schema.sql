/*!40101 SET NAMES binary*/;
/*!40014 SET FOREIGN_KEY_CHECKS=0*/;

CREATE TABLE `wp_jnews_post_like` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `date_time` datetime NOT NULL,
  `value` int(2) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
