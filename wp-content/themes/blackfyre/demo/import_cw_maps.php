<?php
$wpdb->query("DROP TABLE IF EXISTS {$table_prefix}cw_maps");
$wpdb->query("CREATE TABLE IF NOT EXISTS `{$table_prefix}cw_maps` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `game_id` int(10) unsigned NOT NULL,
  `title` varchar(200) NOT NULL,
  `screenshot` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `game_id` (`game_id`,`screenshot`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;");
$wpdb->query("INSERT INTO `{$table_prefix}cw_maps` (`id`, `game_id`, `title`, `screenshot`) VALUES
(1, 1, 'Paracel Storm', 1704),
(2, 1, 'Siege of Shangai', 1705),
(3, 1, 'Golmud Railway', 1706),
(4, 1, 'Hainan Resort', 1707),
(5, 3, 'Dust 2', 1708),
(6, 3, 'Aztec', 1709),
(7, 3, 'Mirage', 1710),
(8, 3, 'Office', 1711),
(9, 2, 'Chasm', 1712),
(10, 2, 'Octane', 1713),
(11, 2, 'Freight', 1714),
(12, 2, 'Flooded', 1715),
(13, 4, 'Main', 1739),
(14, 8, 'Domination', 1740),
(15, 8, 'Arena', 1741),
(16, 6, 'Main', 1742),
(17, 5, 'Milan', 1743),
(18, 5, 'Chelsea', 1744),
(19, 5, 'Barcelona', 1745),
(20, 7, 'Main', 1746);");
?>