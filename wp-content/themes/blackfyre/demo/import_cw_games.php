<?php
$wpdb->query("DROP TABLE IF EXISTS {$table_prefix}cw_games");
$wpdb->query("CREATE TABLE IF NOT EXISTS `{$table_prefix}cw_games` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `abbr` varchar(20) DEFAULT NULL,
  `icon` bigint(20) unsigned DEFAULT NULL,
  `g_banner_file` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `g_banner_file` (`g_banner_file`),
  KEY `icon` (`icon`),
  KEY `title` (`title`),
  KEY `abbr` (`abbr`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;");
$wpdb->query("INSERT INTO `{$table_prefix}cw_games` (`id`, `title`, `abbr`, `icon`, `g_banner_file`) VALUES
(1, 'Battlefield 4', 'BF4', 1637, 1638),
(2, 'Call of Duty', 'CoD', 1639, 1640),
(3, 'Counter Strike: GO', 'CS:GO', 1641, 1642),
(4, 'Dota 2', 'Dota 2', 1643, 1644),
(5, 'Fifa 2015', 'FF15', 1645, 1646),
(6, 'League of Legends', 'LoL', 1647, 1648),
(7, 'Starcraft 2', 'SC2', 1649, 1650),
(8, 'Smite', 'Smite', 1651, 1652);");
?>