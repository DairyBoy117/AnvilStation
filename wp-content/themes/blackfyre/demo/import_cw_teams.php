<?php
$wpdb->query("DROP TABLE IF EXISTS {$table_prefix}cw_teams  ");
$wpdb->query("CREATE TABLE IF NOT EXISTS `{$table_prefix}cw_teams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `logo` bigint(20) unsigned DEFAULT NULL,
  `home_team` tinyint(1) DEFAULT '0',
  `post_id` int(30) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `home_team` (`home_team`),
  KEY `title` (`title`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;");
$wpdb->query("INSERT INTO `{$table_prefix}cw_teams` (`id`, `title`, `logo`, `home_team`, `post_id`) VALUES
(6, 'Fnatic', 1718, 0, 1716),
(7, 'Meet Your Makers', 1721, 0, 1719),
(8, 'Navi', 1725, 0, 1723),
(5, 'Skywarrior', 1703, 0, 1702),
(9, 'Cloud 9', 1730, 0, 1728),
(10, 'Virtus Pro', 1735, 0, 1733),
(11, 'eLevate', 1959, 0, 1957);");
?>