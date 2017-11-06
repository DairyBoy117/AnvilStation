<?php
$wpdb->query("DROP TABLE IF EXISTS {$table_prefix}users");
$wpdb->query("CREATE TABLE IF NOT EXISTS `{$table_prefix}users` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_login` varchar(60) NOT NULL DEFAULT '',
  `user_pass` varchar(64) NOT NULL DEFAULT '',
  `user_nicename` varchar(50) NOT NULL DEFAULT '',
  `user_email` varchar(100) NOT NULL DEFAULT '',
  `user_url` varchar(100) NOT NULL DEFAULT '',
  `user_registered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_activation_key` varchar(60) NOT NULL DEFAULT '',
  `user_status` int(11) NOT NULL DEFAULT '0',
  `display_name` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`),
  KEY `user_login_key` (`user_login`),
  KEY `user_nicename` (`user_nicename`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;");
$wpdb->query("
INSERT INTO `{$table_prefix}users` (`ID`, `user_login`, `user_pass`, `user_nicename`, `user_email`, `user_url`, `user_registered`, `user_activation_key`, `user_status`, `display_name`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'sdasdasds@gmail.com', 'http://www.skywarriorthemes.com', '2015-02-19 14:06:08', '', 0, 'admin'),
(2, 'wooteam', '21232f297a57a5a743894a0e4a801fc3', 'wooteam', '', '', '2015-02-19 14:30:44', '', 0, 'wooteam'),
(3, 'HotShot', '21232f297a57a5a743894a0e4a801fc3', 'hotshot', 'a@a.com', 'http://skywarriorthemes.com', '2015-02-21 13:54:17', '', 0, 'HotShot'),
(4, 'Raaaa', '21232f297a57a5a743894a0e4a801fc3', 'raaaa', 'as@s.com', 'http://skywarriorthemes.com', '2015-02-21 14:02:41', '', 0, 'Raaaa'),
(5, 'g0dspeed', '21232f297a57a5a743894a0e4a801fc3', 'g0dspeed', 'asb@s.com', 'http://skkywarriorthemes.com', '2015-02-21 14:03:56', '', 0, 'g0dspeed'),
(6, 'Kiotsuke', '21232f297a57a5a743894a0e4a801fc3', 'kiotsuke', 'ar@s.com', 'http://skywarriorthemes.com', '2015-02-21 14:05:11', '', 0, 'Kyōsuke'),
(16, 'Byrewthf', '21232f297a57a5a743894a0e4a801fc3', 'byrewthf', '1@123.com', '', '2015-02-28 17:37:25', '', 0, 'Byrewthf'),
(15, 'Pyrotek', '21232f297a57a5a743894a0e4a801fc3', 'pyrotek', 'asd123@asd.com', '', '2015-02-28 16:32:44', '', 0, 'Pyrotek'),
(17, 'Labsolinte', '21232f297a57a5a743894a0e4a801fc3', 'labsolinte', 'labodkkw9@gmail.com', 'http://skywarriorthemes.com', '2015-02-28 17:43:19', '', 0, 'Labsolinte'),
(18, 'FoxSlay', '21232f297a57a5a743894a0e4a801fc3', 'foxslay', '4@123.com', 'http://skywarriorthemes.com', '2015-02-28 17:50:38', '', 0, 'FoxSlay'),
(19, 'Herkethn', '21232f297a57a5a743894a0e4a801fc3', 'herkethn', '23@90.com', '', '2015-02-28 17:51:13', '', 0, 'Herkethn'),
(20, 'Kanettalk', '21232f297a57a5a743894a0e4a801fc3', 'kanettalk', '87@sdf.xom', '', '2015-02-28 17:54:51', '', 0, 'Kanettalk'),
(21, 'LaughAsh', '21232f297a57a5a743894a0e4a801fc3', 'laughash', '45@asd.com', '', '2015-02-28 18:04:38', '', 0, 'LaughAsh'),
(22, 'Kashinepr', '21232f297a57a5a743894a0e4a801fc3', 'kashinepr', '56@asd.com', '', '2015-02-28 18:07:10', '', 0, 'Kashinepr'),
(23, 'MineCozy', '21232f297a57a5a743894a0e4a801fc3', 'minecozy', 'a@fhfg.com', '', '2015-02-28 18:10:03', '', 0, 'MineCozy'),
(24, 'CraziiV2', '21232f297a57a5a743894a0e4a801fc3', 'craziiv2', '43@gmail.com', 'http://skywarriorthemes.com', '2015-02-28 18:10:48', '', 0, 'CraziiV2'),
(25, 'Olignium', '21232f297a57a5a743894a0e4a801fc3', 'olignium', '15@gmail.com', 'http://skywarriorthemes.com', '2015-02-28 18:24:49', '', 0, 'Olignium'),
(26, 'Magnics', '21232f297a57a5a743894a0e4a801fc3', 'magnics', '67@gmail.coms', 'http://skywarriorthemes.com', '2015-02-28 18:31:28', '', 0, 'Magnics'),
(29, 'Energet', '21232f297a57a5a743894a0e4a801fc3', 'energet', '45@gmail.com', 'http://skywarriorthemes.com', '2015-02-28 18:39:50', '', 0, 'Energet'),
(30, 'Aseravela', '21232f297a57a5a743894a0e4a801fc3', 'aseravela', '12@gmail.com', 'http:/skywarriorthemes.com', '2015-03-01 06:31:57', '', 0, 'Aseravela'),
(32, 'Herosipage', '21232f297a57a5a743894a0e4a801fc3', 'herosipage', 'asd@asd.com', 'http://www.skywarriorthemes.com', '2015-03-01 08:40:07', '', 0, 'Herosipage'),
(33, 'KurisuPrime', '21232f297a57a5a743894a0e4a801fc3', 'kurisuprime', 'a123@asd.com', 'http://www.skywarriorthemes.com', '2015-03-01 08:42:30', '', 0, 'KurisuPrime'),
(34, 'BurntRaw', '21232f297a57a5a743894a0e4a801fc3', 'burntraw', '3as@asd.com', 'http://www.skywarriorthemes.com', '2015-03-01 08:45:18', '', 0, 'BurntRaw'),
(35, 'Ravagericom', '21232f297a57a5a743894a0e4a801fc3', 'ravagericom', 'ado@sog.com', 'http://www.skywarriorthemes.com', '2015-03-01 08:48:14', '', 0, 'Ravagericom');");
?>