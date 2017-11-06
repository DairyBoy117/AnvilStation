<?php
function usercountry_install()
{
   global $wpdb;
    $table = $wpdb->prefix."user_countries";
    $structure = "CREATE TABLE IF NOT EXISTS `$table`(
  `id_country` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL DEFAULT '',
  `iso_code_2` char(2) NOT NULL DEFAULT '',
  `iso_code_3` char(3) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_country`),
  KEY `IDX_NAME` (`name`))CHARACTER SET utf8 COLLATE utf8_general_ci;";
    $wpdb->query($structure);
    // Populate table
  $wpdb->query("INSERT IGNORE INTO `$table` VALUES (1, 'Afghanistan', 'AF', 'AFG'),
(2, 'Albania', 'AL', 'ALB'),
(3, 'Algeria', 'DZ', 'DZA'),
(4, 'American Samoa', 'AS', 'ASM'),
(5, 'Andorra', 'AD', 'AND'),
(6, 'Angola', 'AO', 'AGO'),
(7, 'Anguilla', 'AI', 'AIA'),
(8, 'Antarctica', 'AQ', 'ATA'),
(9, 'Antigua and Barbuda', 'AG', 'ATG'),
(10, 'Argentina', 'AR', 'ARG'),
(11, 'Armenia', 'AM', 'ARM'),
(12, 'Aruba', 'AW', 'ABW'),
(13, 'Australia', 'AU', 'AUS'),
(14, 'Austria', 'AT', 'AUT'),
(15, 'Azerbaijan', 'AZ', 'AZE'),
(16, 'Bahamas', 'BS', 'BHS'),
(17, 'Bahrain', 'BH', 'BHR'),
(18, 'Bangladesh', 'BD', 'BGD'),
(19, 'Barbados', 'BB', 'BRB'),
(20, 'Belarus', 'BY', 'BLR'),
(21, 'Belgium', 'BE', 'BEL'),
(22, 'Belize', 'BZ', 'BLZ'),
(23, 'Benin', 'BJ', 'BEN'),
(24, 'Bermuda', 'BM', 'BMU'),
(25, 'Bhutan', 'BT', 'BTN'),
(26, 'Bolivia', 'BO', 'BOL'),
(27, 'Bosnia and Herzegowina', 'BA', 'BIH'),
(28, 'Botswana', 'BW', 'BWA'),
(29, 'Bouvet Island', 'BV', 'BVT'),
(30, 'Brazil', 'BR', 'BRA'),
(31, 'British Indian Ocean Territory', 'IO', 'IOT'),
(32, 'Brunei Darussalam', 'BN', 'BRN'),
(33, 'Bulgaria', 'BG', 'BGR'),
(34, 'Burkina Faso', 'BF', 'BFA'),
(35, 'Burundi', 'BI', 'BDI'),
(36, 'Cambodia', 'KH', 'KHM'),
(37, 'Cameroon', 'CM', 'CMR'),
(38, 'Canada', 'CA', 'CAN'),
(39, 'Cape Verde', 'CV', 'CPV'),
(40, 'Cayman Islands', 'KY', 'CYM'),
(41, 'Central African Republic', 'CF', 'CAF'),
(42, 'Chad', 'TD', 'TCD'),
(43, 'Chile', 'CL', 'CHL'),
(44, 'China', 'CN', 'CHN'),
(45, 'Christmas Island', 'CX', 'CXR'),
(46, 'Cocos (Keeling) Islands', 'CC', 'CCK'),
(47, 'Colombia', 'CO', 'COL'),
(48, 'Comoros', 'KM', 'COM'),
(49, 'Congo', 'CG', 'COG'),
(50, 'Cook Islands', 'CK', 'COK'),
(51, 'Costa Rica', 'CR', 'CRI'),
(52, 'Cote D\'Ivoire', 'CI', 'CIV'),
(53, 'Croatia', 'HR', 'HRV'),
(54, 'Cuba', 'CU', 'CUB'),
(55, 'Cyprus', 'CY', 'CYP'),
(56, 'Czech Republic', 'CZ', 'CZE'),
(57, 'Denmark', 'DK', 'DNK'),
(58, 'Djibouti', 'DJ', 'DJI'),
(59, 'Dominica', 'DM', 'DMA'),
(60, 'Dominican Republic', 'DO', 'DOM'),
(61, 'East Timor', 'TP', 'TMP'),
(62, 'Ecuador', 'EC', 'ECU'),
(63, 'Egypt', 'EG', 'EGY'),
(64, 'El Salvador', 'SV', 'SLV'),
(65, 'Equatorial Guinea', 'GQ', 'GNQ'),
(66, 'Eritrea', 'ER', 'ERI'),
(67, 'Estonia', 'EE', 'EST'),
(68, 'Ethiopia', 'ET', 'ETH'),
(69, 'Falkland Islands (Malvinas)', 'FK', 'FLK'),
(70, 'Faroe Islands', 'FO', 'FRO'),
(71, 'Fiji', 'FJ', 'FJI'),
(72, 'Finland', 'FI', 'FIN'),
(73, 'France', 'FR', 'FRA'),
(74, 'France, Metropolitan', 'FX', 'FXX'),
(75, 'French Guiana', 'GF', 'GUF'),
(76, 'French Polynesia', 'PF', 'PYF'),
(77, 'French Southern Territories', 'TF', 'ATF'),
(78, 'Gabon', 'GA', 'GAB'),
(79, 'Gambia', 'GM', 'GMB'),
(80, 'Georgia', 'GE', 'GEO'),
(81, 'Germany', 'DE', 'DEU'),
(82, 'Ghana', 'GH', 'GHA'),
(83, 'Gibraltar', 'GI', 'GIB'),
(84, 'Greece', 'GR', 'GRC'),
(85, 'Greenland', 'GL', 'GRL'),
(86, 'Grenada', 'GD', 'GRD'),
(87, 'Guadeloupe', 'GP', 'GLP'),
(88, 'Guam', 'GU', 'GUM'),
(89, 'Guatemala', 'GT', 'GTM'),
(90, 'Guinea', 'GN', 'GIN'),
(91, 'Guinea-bissau', 'GW', 'GNB'),
(92, 'Guyana', 'GY', 'GUY'),
(93, 'Haiti', 'HT', 'HTI'),
(94, 'Heard and Mc Donald Islands', 'HM', 'HMD'),
(95, 'Honduras', 'HN', 'HND'),
(96, 'Hong Kong', 'HK', 'HKG'),
(97, 'Hungary', 'HU', 'HUN'),
(98, 'Iceland', 'IS', 'ISL'),
(99, 'India', 'IN', 'IND'),
(100, 'Indonesia', 'ID', 'IDN'),
(101, 'Iran (Islamic Republic of)', 'IR', 'IRN'),
(102, 'Iraq', 'IQ', 'IRQ'),
(103, 'Ireland', 'IE', 'IRL'),
(104, 'Israel', 'IL', 'ISR'),
(105, 'Italy', 'IT', 'ITA'),
(106, 'Jamaica', 'JM', 'JAM'),
(107, 'Japan', 'JP', 'JPN'),
(108, 'Jordan', 'JO', 'JOR'),
(109, 'Kazakhstan', 'KZ', 'KAZ'),
(110, 'Kenya', 'KE', 'KEN'),
(111, 'Kiribati', 'KI', 'KIR'),
(112, 'Korea, Democratic People\'s Republic of', 'KP', 'PRK'),
(113, 'Korea, Republic of', 'KR', 'KOR'),
(114, 'Kuwait', 'KW', 'KWT'),
(115, 'Kyrgyzstan', 'KG', 'KGZ'),
(116, 'Lao People\'s Democratic Republic', 'LA', 'LAO'),
(117, 'Latvia', 'LV', 'LVA'),
(118, 'Lebanon', 'LB', 'LBN'),
(119, 'Lesotho', 'LS', 'LSO'),
(120, 'Liberia', 'LR', 'LBR'),
(121, 'Libyan Arab Jamahiriya', 'LY', 'LBY'),
(122, 'Liechtenstein', 'LI', 'LIE'),
(123, 'Lithuania', 'LT', 'LTU'),
(124, 'Luxembourg', 'LU', 'LUX'),
(125, 'Macau', 'MO', 'MAC'),
(126, 'Macedonia, The Former Yugoslav Republic of', 'MK', 'MKD'),
(127, 'Madagascar', 'MG', 'MDG'),
(128, 'Malawi', 'MW', 'MWI'),
(129, 'Malaysia', 'MY', 'MYS'),
(130, 'Maldives', 'MV', 'MDV'),
(131, 'Mali', 'ML', 'MLI'),
(132, 'Malta', 'MT', 'MLT'),
(133, 'Marshall Islands', 'MH', 'MHL'),
(134, 'Martinique', 'MQ', 'MTQ'),
(135, 'Mauritania', 'MR', 'MRT'),
(136, 'Mauritius', 'MU', 'MUS'),
(137, 'Mayotte', 'YT', 'MYT'),
(138, 'Mexico', 'MX', 'MEX'),
(139, 'Micronesia, Federated States of', 'FM', 'FSM'),
(140, 'Moldova, Republic of', 'MD', 'MDA'),
(141, 'Monaco', 'MC', 'MCO'),
(142, 'Mongolia', 'MN', 'MNG'),
(143, 'Montserrat', 'MS', 'MSR'),
(144, 'Morocco', 'MA', 'MAR'),
(145, 'Mozambique', 'MZ', 'MOZ'),
(146, 'Myanmar', 'MM', 'MMR'),
(147, 'Namibia', 'NA', 'NAM'),
(148, 'Nauru', 'NR', 'NRU'),
(149, 'Nepal', 'NP', 'NPL'),
(150, 'Netherlands', 'NL', 'NLD'),
(151, 'Netherlands Antilles', 'AN', 'ANT'),
(152, 'New Caledonia', 'NC', 'NCL'),
(153, 'New Zealand', 'NZ', 'NZL'),
(154, 'Nicaragua', 'NI', 'NIC'),
(155, 'Niger', 'NE', 'NER'),
(156, 'Nigeria', 'NG', 'NGA'),
(157, 'Niue', 'NU', 'NIU'),
(158, 'Norfolk Island', 'NF', 'NFK'),
(159, 'Northern Mariana Islands', 'MP', 'MNP'),
(160, 'Norway', 'NO', 'NOR'),
(161, 'Oman', 'OM', 'OMN'),
(162, 'Pakistan', 'PK', 'PAK'),
(163, 'Palau', 'PW', 'PLW'),
(164, 'Panama', 'PA', 'PAN'),
(165, 'Papua New Guinea', 'PG', 'PNG'),
(166, 'Paraguay', 'PY', 'PRY'),
(167, 'Peru', 'PE', 'PER'),
(168, 'Philippines', 'PH', 'PHL'),
(169, 'Pitcairn', 'PN', 'PCN'),
(170, 'Poland', 'PL', 'POL'),
(171, 'Portugal', 'PT', 'PRT'),
(172, 'Puerto Rico', 'PR', 'PRI'),
(173, 'Qatar', 'QA', 'QAT'),
(174, 'Reunion', 'RE', 'REU'),
(175, 'Romania', 'RO', 'ROM'),
(176, 'Russian Federation', 'RU', 'RUS'),
(177, 'Rwanda', 'RW', 'RWA'),
(178, 'Saint Kitts and Nevis', 'KN', 'KNA'),
(179, 'Saint Lucia', 'LC', 'LCA'),
(180, 'Saint Vincent and the Grenadines', 'VC', 'VCT'),
(181, 'Samoa', 'WS', 'WSM'),
(182, 'San Marino', 'SM', 'SMR'),
(183, 'Sao Tome and Principe', 'ST', 'STP'),
(184, 'Saudi Arabia', 'SA', 'SAU'),
(185, 'Senegal', 'SN', 'SEN'),
(186, 'Serbia', 'RS', 'SER'),
(187, 'Seychelles', 'SC', 'SYC'),
(188, 'Sierra Leone', 'SL', 'SLE'),
(189, 'Singapore', 'SG', 'SGP'),
(180, 'Slovakia (Slovak Republic)', 'SK', 'SVK'),
(191, 'Slovenia', 'SI', 'SVN'),
(192, 'Solomon Islands', 'SB', 'SLB'),
(193, 'Somalia', 'SO', 'SOM'),
(194, 'South Africa', 'ZA', 'ZAF'),
(195, 'South Georgia and the South Sandwich Islands', 'GS', 'SGS'),
(196, 'Spain', 'ES', 'ESP'),
(197, 'Sri Lanka', 'LK', 'LKA'),
(198, 'St. Helena', 'SH', 'SHN'),
(199, 'St. Pierre and Miquelon', 'PM', 'SPM'),
(190, 'Sudan', 'SD', 'SDN'),
(201, 'Suriname', 'SR', 'SUR'),
(202, 'Svalbard and Jan Mayen Islands', 'SJ', 'SJM'),
(203, 'Swaziland', 'SZ', 'SWZ'),
(204, 'Sweden', 'SE', 'SWE'),
(205, 'Switzerland', 'CH', 'CHE'),
(206, 'Syrian Arab Republic', 'SY', 'SYR'),
(207, 'Taiwan', 'TW', 'TWN'),
(207, 'Tajikistan', 'TJ', 'TJK'),
(208, 'Tanzania, United Republic of', 'TZ', 'TZA'),
(209, 'Thailand', 'TH', 'THA'),
(210, 'Togo', 'TG', 'TGO'),
(211, 'Tokelau', 'TK', 'TKL'),
(212, 'Tonga', 'TO', 'TON'),
(213, 'Trinidad and Tobago', 'TT', 'TTO'),
(214, 'Tunisia', 'TN', 'TUN'),
(215, 'Turkey', 'TR', 'TUR'),
(216, 'Turkmenistan', 'TM', 'TKM'),
(217, 'Turks and Caicos Islands', 'TC', 'TCA'),
(218, 'Tuvalu', 'TV', 'TUV'),
(219, 'Uganda', 'UG', 'UGA'),
(220, 'Ukraine', 'UA', 'UKR'),
(221, 'United Arab Emirates', 'AE', 'ARE'),
(222, 'United Kingdom', 'GB', 'GBR'),
(223, 'United States', 'US', 'USA'),
(224, 'United States Minor Outlying Islands', 'UM', 'UMI'),
(225, 'Uruguay', 'UY', 'URY'),
(226, 'Uzbekistan', 'UZ', 'UZB'),
(227, 'Vanuatu', 'VU', 'VUT'),
(228, 'Vatican City State (Holy See)', 'VA', 'VAT'),
(229, 'Venezuela', 'VE', 'VEN'),
(230, 'Viet Nam', 'VN', 'VNM'),
(231, 'Virgin Islands (British)', 'VG', 'VGB'),
(232, 'Virgin Islands (U.S.)', 'VI', 'VIR'),
(233, 'Wallis and Futuna Islands', 'WF', 'WLF'),
(234, 'Western Sahara', 'EH', 'ESH'),
(235, 'Yemen', 'YE', 'YEM'),
(237, 'Zaire', 'ZR', 'ZAR'),
(238, 'Zambia', 'ZM', 'ZMB'),
(239, 'Zimbabwe', 'ZW', 'ZWE');");
}
usercountry_install();
function usercountries_form($cid) {
		global $wpdb;
		$table = $wpdb->prefix."user_countries";
		$countries = $wpdb->get_results("SELECT * FROM $table ORDER BY `name`");
?><select name="usercountry_id">
	<option value="0"><?php esc_html_e('- Select -','blackfyre') ?></option>
	<?php

		foreach ($countries as $country) {
			$selected="";
			 if ($cid==$country->id_country) { $selected="selected";}

											if($country->name == 'Afghanistan'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Afghanistan', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Albania'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Albania', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Algeria'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Algeria', 'blackfyre' ).'</option>';
										}elseif($country->name == 'American Samoa'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'American Samoa', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Andorra'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Andorra', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Angola'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Angola', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Anguilla'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Anguilla', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Antarctica'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Antarctica', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Antigua and Barbuda'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Antigua and Barbuda', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Argentina'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Argentina', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Armenia'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Armenia', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Aruba'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Aruba', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Australia'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Australia', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Austria'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Austria', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Azerbaijan'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Azerbaijan', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Bahamas'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Bahamas', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Bahrain'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Bahrain', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Bangladesh'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Bangladesh', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Barbados'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Barbados', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Belarus'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Belarus', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Belgium'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Belgium', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Belize'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Belize', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Benin'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Benin', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Bermuda'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Bermuda', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Bhutan'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Bhutan', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Bolivia'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Bolivia', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Bosnia and Herzegowina'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Bosnia and Herzegowina', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Botswana'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Botswana', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Bouvet Island'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Bouvet Island', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Brazil'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Brazil', 'blackfyre' ).'</option>';
										}elseif($country->name == 'British Indian Ocean Territory'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'British Indian Ocean Territory', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Brunei Darussalam'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Brunei Darussalam', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Bulgaria'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Bulgaria', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Burkina Faso'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Burkina Faso', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Burundi'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Burundi', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Cambodia'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Cambodia', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Cameroon'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Cameroon', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Canada'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Canada', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Cape Verde'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Cape Verde', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Cayman Islands'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Cayman Islands', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Central African Republic'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Central African Republic', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Chad'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Chad', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Chile'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Chile', 'blackfyre' ).'</option>';
										}elseif($country->name == 'China'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'China', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Christmas Island'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Christmas Island', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Cocos (Keeling) Islands'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Cocos (Keeling) Islands', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Colombia'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Colombia', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Comoros'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Comoros', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Congo'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Congo', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Cook Islands'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Cook Islands', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Costa Rica'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Costa Rica', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Cote D\'Ivoire'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Cote D\'Ivoire', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Croatia'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Croatia', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Cuba'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Cuba', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Cyprus'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Cyprus', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Czech Republic'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Czech Republic', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Denmark'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Denmark', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Djibouti'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Djibouti', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Dominica'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Dominica', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Dominican Republic'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Dominican Republic', 'blackfyre' ).'</option>';
										}elseif($country->name == 'East Timor'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'East Timor', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Ecuador'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Ecuador', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Egypt'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Egypt', 'blackfyre' ).'</option>';
										}elseif($country->name == 'El Salvador'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'El Salvador', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Equatorial Guinea'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Equatorial Guinea', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Eritrea'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Eritrea', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Estonia'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Estonia', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Ethiopia'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Ethiopia', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Falkland Islands (Malvinas)'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Falkland Islands (Malvinas)', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Faroe Islands'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Faroe Islands', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Fiji'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Fiji', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Finland'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Finland', 'blackfyre' ).'</option>';
										}elseif($country->name == 'France'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'France', 'blackfyre' ).'</option>';
										}elseif($country->name == 'France, Metropolitan'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'France, Metropolitan', 'blackfyre' ).'</option>';
										}elseif($country->name == 'French Guiana'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'French Guiana', 'blackfyre' ).'</option>';
										}elseif($country->name == 'French Polynesia'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'French Polynesia', 'blackfyre' ).'</option>';
										}elseif($country->name == 'French Southern Territories'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'French Southern Territories', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Gabon'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Gabon', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Gambia'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Gambia', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Georgia'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Georgia', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Germany'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Germany', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Ghana'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Ghana', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Gibraltar'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Gibraltar', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Greece'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Greece', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Greenland'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Greenland', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Grenada'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Grenada', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Guadeloupe'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Guadeloupe', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Guam'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Guam', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Guatemala'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Guatemala', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Guinea'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Guinea', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Guinea-bissau'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Guinea-bissau', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Guyana'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Guyana', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Haiti'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Haiti', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Heard and Mc Donald Islands'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Heard and Mc Donald Islands', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Honduras'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Honduras', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Hong Kong'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Hong Kong', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Hungary'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Hungary', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Iceland'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Iceland', 'blackfyre' ).'</option>';
										}elseif($country->name == 'India'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'India', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Indonesia'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Indonesia', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Iran (Islamic Republic of)'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Iran (Islamic Republic of)', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Iraq'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Iraq', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Ireland'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Ireland', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Israel'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Israel', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Italy'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Italy', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Jamaica'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Jamaica', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Japan'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Japan', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Jordan'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Jordan', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Kazakhstan'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Kazakhstan', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Kenya'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Kenya', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Kiribati'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Kiribati', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Korea, Democratic People\'s Republic of'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Korea, Democratic People\'s Republic of', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Korea, Republic of'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Korea, Republic of', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Kuwait'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Kuwait', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Kyrgyzstan'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Kyrgyzstan', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Lao People\'s Democratic Republic'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Lao People\'s Democratic Republic', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Latvia'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Latvia', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Lebanon'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Lebanon', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Lesotho'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Lesotho', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Liberia'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Liberia', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Libyan Arab Jamahiriya'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Libyan Arab Jamahiriya', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Liechtenstein'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Liechtenstein', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Lithuania'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Lithuania', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Luxembourg'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Luxembourg', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Macau'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Macau', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Macedonia, The Former Yugoslav Republic of'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Macedonia, The Former Yugoslav Republic of', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Madagascar'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Madagascar', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Malawi'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Malawi', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Malaysia'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Malaysia', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Maldives'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Maldives', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Mali'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Mali', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Malta'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Malta', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Marshall Islands'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Marshall Islands', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Martinique'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Martinique', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Mauritania'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Mauritania', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Mauritius'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Mauritius', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Mayotte'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Mayotte', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Mexico'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Mexico', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Micronesia, Federated States of'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Micronesia, Federated States of', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Moldova, Republic of'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Moldova, Republic of', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Monaco'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Monaco', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Mongolia'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Mongolia', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Montserrat'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Montserrat', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Morocco'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Morocco', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Mozambique'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Mozambique', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Myanmar'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Myanmar', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Namibia'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Namibia', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Nauru'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Nauru', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Nepal'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Nepal', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Netherlands'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Netherlands', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Netherlands Antilles'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Netherlands Antilles', 'blackfyre' ).'</option>';
										}elseif($country->name == 'New Caledonia'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'New Caledonia', 'blackfyre' ).'</option>';
										}elseif($country->name == 'New Zealand'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'New Zealand', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Nicaragua'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Nicaragua', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Niger'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Niger', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Nigeria'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Nigeria', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Niue'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Niue', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Norfolk Island'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Norfolk Island', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Northern Mariana Islands'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Northern Mariana Islands', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Norway'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Norway', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Oman'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Oman', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Pakistan'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Pakistan', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Palau'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Palau', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Panama'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Panama', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Papua New Guinea'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Papua New Guinea', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Paraguay'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Paraguay', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Peru'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Peru', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Philippines'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Philippines', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Pitcairn'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Pitcairn', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Poland'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Poland', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Portugal'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Portugal', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Puerto Rico'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Puerto Rico', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Qatar'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Qatar', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Reunion'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Reunion', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Romania'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Romania', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Russian Federation'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Russian Federation', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Rwanda'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Rwanda', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Saint Kitts and Nevis'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Saint Kitts and Nevis', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Saint Lucia'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Saint Lucia', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Saint Vincent and the Grenadines'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Saint Vincent and the Grenadines', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Samoa'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Samoa', 'blackfyre' ).'</option>';
										}elseif($country->name == 'San Marino'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'San Marino', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Sao Tome and Principe'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Sao Tome and Principe', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Saudi Arabia'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Saudi Arabia', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Senegal'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Senegal', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Serbia'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Serbia', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Seychelles'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Seychelles', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Sierra Leone'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Sierra Leone', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Singapore'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Singapore', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Slovakia (Slovak Republic)'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Slovakia (Slovak Republic)', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Slovenia'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Slovenia', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Solomon Islands'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Solomon Islands', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Somalia'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Somalia', 'blackfyre' ).'</option>';
										}elseif($country->name == 'South Africa'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'South Africa', 'blackfyre' ).'</option>';
										}elseif($country->name == 'South Georgia and the South Sandwich Islands'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'South Georgia and the South Sandwich Islands', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Spain'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Spain', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Sri Lanka'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Sri Lanka', 'blackfyre' ).'</option>';
										}elseif($country->name == 'St. Helena'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'St. Helena', 'blackfyre' ).'</option>';
										}elseif($country->name == 'St. Pierre and Miquelon'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'St. Pierre and Miquelon', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Sudan'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Sudan', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Suriname'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Suriname', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Svalbard and Jan Mayen Islands'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Svalbard and Jan Mayen Islands', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Swaziland'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Swaziland', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Sweden'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Sweden', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Switzerland'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Switzerland', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Syrian Arab Republic'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Syrian Arab Republic', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Taiwan'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Taiwan', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Tajikistan'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Tajikistan', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Tanzania, United Republic of'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Tanzania, United Republic of', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Thailand'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Thailand', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Togo'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Togo', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Tokelau'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Tokelau', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Tonga'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Tonga', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Trinidad and Tobago'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Trinidad and Tobago', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Tunisia'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Tunisia', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Turkey'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Turkey', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Turkmenistan'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Turkmenistan', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Turks and Caicos Islands'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Turks and Caicos Islands', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Tuvalu'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Tuvalu', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Uganda'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Uganda', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Ukraine'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Ukraine', 'blackfyre' ).'</option>';
										}elseif($country->name == 'United Arab Emirates'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'United Arab Emirates', 'blackfyre' ).'</option>';
										}elseif($country->name == 'United Kingdom'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'United Kingdom', 'blackfyre' ).'</option>';
										}elseif($country->name == 'United States'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'United States', 'blackfyre' ).'</option>';
										}elseif($country->name == 'United States Minor Outlying Islands'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'United States Minor Outlying Islands', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Uruguay'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Uruguay', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Uzbekistan'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Uzbekistan', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Vanuatu'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Vanuatu', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Vatican City State (Holy See)'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Vatican City State (Holy See)', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Venezuela'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Venezuela', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Viet Nam'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Viet Nam', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Virgin Islands (British)'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Virgin Islands (British)', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Virgin Islands (U.S.)'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Virgin Islands (U.S.)', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Wallis and Futuna Islands'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Wallis and Futuna Islands', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Western Sahara'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Western Sahara', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Yemen'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Yemen', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Zaire'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Zaire', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Zambia'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Zambia', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Zimbabwe'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Zimbabwe', 'blackfyre' ).'</option>';

										}
		}
?>
	</select>
	<?php
	// display country flag in case a country is selected for this user
	}
function usercountry_field() {
	global $user_ID;
	if ( preg_match('&profile.php&', $_SERVER['REQUEST_URI'])) {
		$id = $user_ID;
	} elseif($_REQUEST['user_id']) {
		$id = $_REQUEST['user_id'];
	}
	 $usercountry_id = get_user_meta($id, 'usercountry_id');
?>
    <!-- Country profile field HTML -->
    <table class="form-table">
    <h3><?php esc_html_e('Country', 'blackfyre'); ?></h3>
    <tr>
        <th><label for="country"><?php esc_html_e("Select country", 'blackfyre'); ?></label></th>
        <?php if(!isset($usercountry_id[0]))$usercountry_id[0]=''; ?>
        <td><?php usercountries_form($usercountry_id[0]) ?>
        	<!-- <span class="description">You can write a description here if you want</span> -->
        </td>
    </tr>
     <tr>
        <th><label for="city"><?php esc_html_e('City', 'blackfyre'); ?></label></th>
         <td><input class="text-input" name="city" type="text" id="city" value="<?php the_author_meta('city', $id); ?>" /></td>
    </tr>
    </table>
<?php
} // End country field
function save_usercountry_field() {
	global $user_ID;
	if (preg_match('&profile.php&', $_SERVER['REQUEST_URI'])) {
		$id = $user_ID;
	} elseif($_REQUEST['user_id']) {
		$id = $_REQUEST['user_id'];
	}
	$usercountry = $_POST['usercountry_id'];
	update_user_meta($id, 'usercountry_id', $usercountry);
	 if (!empty($_POST['city']))
     update_user_meta($id, 'city', esc_attr($_POST['city']));
}
add_action('activate_usercountry/usercountry.php', 'usercountry_install');
add_filter('show_user_profile','usercountry_field');
add_action('edit_user_profile', 'usercountry_field');
add_action('profile_update', 'save_usercountry_field');
function usercountry_name($cid)
{
	global $wpdb;
    $table = $wpdb->prefix."user_countries";
	$cflag = $wpdb->get_row("SELECT * FROM $table WHERE id_country = '$cid'");
	if ( !$cflag )return "";
    else return $cflag->name;
}
/*** Create display function ***/
function usercountry_name_display($userid) {
		if ($userid>0) return usercountry_name(get_the_author_meta('usercountry_id',$userid));
		else return usercountry_name(get_the_author_meta('usercountry_id'));
}
?>