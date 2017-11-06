<?php

add_action( 'vc_before_init', 'blackfyre_integrateWithVC' );

function blackfyre_integrateWithVC() {

global $vc_add_css_animation;
$vc_add_css_animation = array(
	'type' => 'dropdown',
	'heading' =>  esc_html__( 'CSS Animation', 'blackfyre' ),
	'param_name' => 'css_animation',
	'admin_label' => true,
	'value' => array(
		 esc_html__( 'No', 'blackfyre' ) => '',
		 esc_html__( 'Top to bottom', 'blackfyre' ) => 'top-to-bottom',
		 esc_html__( 'Bottom to top', 'blackfyre' ) => 'bottom-to-top',
		 esc_html__( 'Left to right', 'blackfyre' ) => 'left-to-right',
		 esc_html__( 'Right to left', 'blackfyre' ) => 'right-to-left',
		 esc_html__( 'Appear from center', 'blackfyre' ) => 'appear'
	),
	'description' =>  esc_html__( 'Select type of animation for element to be animated when it "enters" the browsers viewport (Note: works only in modern browsers).', 'blackfyre' )
);
$categories = get_categories(

array(
        'type'          => 'post',
        'child_of'      => 0,
        'orderby'       => 'name',
        'order'         => 'ASC',
        'hide_empty'    => 1,
        'hierarchical'  => 1,
        'taxonomy'      => 'category',
        'pad_counts'    => false

) );

foreach ($categories as $cat) {
    $cats[$cat->cat_name] = $cat->cat_ID;
}
if(!isset($cats))$cats='';


/* News Block
---------------------------------------------------------- */
vc_map( array(
    'name' => esc_html__( 'News Block', 'blackfyre' ),
    'base' => 'vc_column_news',
    'icon' => 'icon-wpb-layer-shape-text',
    'wrapper_class' => 'clearfix',
    'category' => esc_html__( 'Content', 'blackfyre' ),
    'description' => esc_html__( 'A block for news', 'blackfyre' ),
    'params' => array(
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Title (optional)', 'blackfyre' ),
            'param_name' => 'el_news_title',
            'holder' => 'div',
            'value' => '',
            'description' => esc_html__( 'Add title to your news block.', 'blackfyre' )
        ),
        array(
            'type' => 'checkbox',
            'heading' => esc_html__( 'Categories', 'blackfyre' ),
            'param_name' => 'el_news_categories',
            'description' => esc_html__( 'Select categories you want to include.', 'blackfyre' ),
            'value' => $cats,
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Number of posts to show', 'blackfyre' ),
            'param_name' => 'el_news_number_posts',
            'holder' => 'div',
            'value' => '',
            'description' => esc_html__( 'Enter number of posts you wolud like to show in this block.', 'blackfyre' )
        ),
         array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Extra class name', 'blackfyre' ),
            'param_name' => 'el_class',
            'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'blackfyre' )
        ),


    )
) );


/* News Block - Horizontal
---------------------------------------------------------- */
vc_map( array(
    'name' => esc_html__( 'News Block - Horizontal', 'blackfyre' ),
    'base' => 'vc_column_news_horizontal',
    'icon' => 'icon-wpb-layer-shape-text',
    'wrapper_class' => 'clearfix',
    'category' => esc_html__( 'Content', 'blackfyre' ),
    'description' => esc_html__( 'A block for horizontal news', 'blackfyre' ),
    'params' => array(
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Title (optional)', 'blackfyre' ),
            'param_name' => 'el_news_horizontal_title',
            'holder' => 'div',
            'value' => '',
            'description' => esc_html__( 'Add title to your news block.', 'blackfyre' )
        ),
        array(
            'type' => 'checkbox',
            'heading' => esc_html__( 'Categories', 'blackfyre' ),
            'param_name' => 'el_news_horizontal_categories',
            'description' => esc_html__( 'Select categories you want to include.', 'blackfyre' ),
            'value' => $cats,
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Number of posts to show', 'blackfyre' ),
            'param_name' => 'el_news_horizontal_number_posts',
            'holder' => 'div',
            'value' => '',
            'description' => esc_html__( 'Enter number of posts you wolud like to show in this block.', 'blackfyre' )
        ),
         array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Extra class name', 'blackfyre' ),
            'param_name' => 'el_class',
            'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'blackfyre' )
        ),


    )
) );


/* News Block - Tabbed
---------------------------------------------------------- */
vc_map( array(
    'name' => esc_html__( 'News Block - Tabbed', 'blackfyre' ),
    'base' => 'vc_column_news_tabbed',
    'icon' => 'icon-wpb-layer-shape-text',
    'wrapper_class' => 'clearfix',
    'category' => esc_html__( 'Content', 'blackfyre' ),
    'description' => esc_html__( 'A block for horizontal news', 'blackfyre' ),
    'params' => array(
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Title (optional)', 'blackfyre' ),
            'param_name' => 'el_news_tabbed_title',
            'holder' => 'div',
            'value' => '',
            'description' => esc_html__( 'Add title to your news block.', 'blackfyre' )
        ),
        array(
            'type' => 'checkbox',
            'heading' => esc_html__( 'Categories', 'blackfyre' ),
            'param_name' => 'el_news_tabbed_categories',
            'description' => esc_html__( 'Select categories you want to include.', 'blackfyre' ),
            'value' => $cats,
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Number of posts to show', 'blackfyre' ),
            'param_name' => 'el_news_tabbed_number_posts',
            'holder' => 'div',
            'value' => '',
            'description' => esc_html__( 'Enter number of posts you wolud like to show in this block.', 'blackfyre' )
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Tabs display order', 'blackfyre' ),
            'param_name' => 'el_display_order',
            'value' => array(
        esc_html__('None','blackfyre') => 'none' ,
		esc_html__('Title Asc','blackfyre') => 'title_asc' ,
		esc_html__('Title Desc','blackfyre') =>  'title_desc' ,
		esc_html__('ID Asc','blackfyre') => 'id_sort_asc',
		esc_html__('ID Desc','blackfyre') => 'id_sort_desc'

    ),
            'description' => esc_html__( 'Choose tabs display order.', 'blackfyre' )
        ),
         array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Extra class name', 'blackfyre' ),
            'param_name' => 'el_class',
            'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'blackfyre' )
        ),


    )
) );


/* Blog Block
---------------------------------------------------------- */
vc_map( array(
    'name' => esc_html__( 'Blog Block', 'blackfyre' ),
    'base' => 'vc_column_blog',
    'icon' => 'icon-wpb-layer-shape-text',
    'wrapper_class' => 'clearfix',
    'category' => esc_html__( 'Content', 'blackfyre' ),
    'description' => esc_html__( 'A blog block', 'blackfyre' ),
    'params' => array(
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Title (optional)', 'blackfyre' ),
            'param_name' => 'el_blog_title',
            'holder' => 'div',
            'value' => '',
            'description' => esc_html__( 'Add title to your news block.', 'blackfyre' )
        ),
        array(
            'type' => 'checkbox',
            'heading' => esc_html__( 'Categories', 'blackfyre' ),
            'param_name' => 'el_blog_categories',
            'description' => esc_html__( 'Select categories you want to include.', 'blackfyre' ),
            'value' => $cats,
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Number of posts to show', 'blackfyre' ),
            'param_name' => 'el_blog_number_posts',
            'holder' => 'div',
            'value' => '',
            'description' => esc_html__( 'Enter number of posts you wolud like to show in this block.', 'blackfyre' )
        ),
         array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Extra class name', 'blackfyre' ),
            'param_name' => 'el_class',
            'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'blackfyre' )
        ),


    )
) );


/* Contact Block
---------------------------------------------------------- */
vc_map( array(
    'name' => esc_html__( 'Comments Block', 'blackfyre' ),
    'base' => 'vc_comments',
    'icon' => 'icon-wpb-layer-shape-text',
    'wrapper_class' => 'clearfix',
    'category' => esc_html__( 'Content', 'blackfyre' ),
    'description' => esc_html__( 'Add comments to your page.', 'blackfyre' ),
     'params' => array(
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Title (optional)', 'blackfyre' ),
            'param_name' => 'el_comments_title',
            'holder' => 'div',
            'value' => '',
            'description' => esc_html__( 'Add title to your comments block.', 'blackfyre' )
        ),
    )

) );


/* Members Block
---------------------------------------------------------- */
vc_map( array(
    'name' => esc_html__( 'Clan info block', 'blackfyre' ),
    'base' => 'vc_members_clan_page',
    'icon' => 'icon-wpb-layer-shape-text',
    'wrapper_class' => 'clearfix',
    'category' => esc_html__( 'Clan Wars', 'blackfyre' ),
    'description' => esc_html__( 'Clan info block.', 'blackfyre' ),
    'params' => array(
     array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Clan country', 'blackfyre' ),
            'param_name' => 'el_countries',
            'value' => array(
		esc_html__('Afghanistan','blackfyre') => 'Afghanistan',
		esc_html__('Albania','blackfyre') => 'Albania',
		esc_html__('Algeria','blackfyre') => 'Algeria',
		esc_html__('Andorra','blackfyre') => 'Andorra',
		esc_html__('Angola','blackfyre') => 'Angola',
		esc_html__('Antigua and Barbuda','blackfyre') => 'Antigua and Barbuda',
		esc_html__('Argentina','blackfyre') => 'Argentina',
		esc_html__('Armenia','blackfyre') => 'Armenia',
		esc_html__('Aruba','blackfyre') => 'Aruba',
		esc_html__('Australia','blackfyre') => 'Australia',
		esc_html__('Austria','blackfyre') => 'Austria',
		esc_html__('Azerbaijan','blackfyre') => 'Azerbaijan',
		esc_html__('Afghanistan','blackfyre') => 'Afghanistan',
		esc_html__('Albania','blackfyre') => 'Albania',
		esc_html__('Algeria','blackfyre') => 'Algeria',
		esc_html__('Andorra','blackfyre') => 'Andorra',
		esc_html__('Angola','blackfyre') => 'Angola',
		esc_html__('Antigua and Barbuda','blackfyre') => 'Antigua and Barbuda',
		esc_html__('Argentina','blackfyre') => 'Argentina',
		esc_html__('Armenia','blackfyre') => 'Armenia',
		esc_html__('Aruba','blackfyre') => 'Aruba',
		esc_html__('Australia','blackfyre') => 'Australia',
		esc_html__('Austria','blackfyre') => 'Austria',
		esc_html__('Azerbaijan','blackfyre') => 'Azerbaijan',
		esc_html__('Bahamas, The','blackfyre') => 'Bahamas, The',
		esc_html__('Bahrain','blackfyre') => 'Bahrain',
		esc_html__('Bangladesh','blackfyre') => 'Bangladesh',
		esc_html__('Barbados','blackfyre') => 'Barbados',
		esc_html__('Belarus','blackfyre') => 'Belarus',
		esc_html__('Belgium','blackfyre') => 'Belgium',
		esc_html__('Belize','blackfyre') => 'Belize',
		esc_html__('Benin','blackfyre') => 'Benin',
		esc_html__('Bhutan','blackfyre') => 'Bhutan',
		esc_html__('Bolivia','blackfyre') => 'Bolivia',
		esc_html__('Bosnia and Herzegovina','blackfyre') => 'Bosnia and Herzegovina',
		esc_html__('Botswana','blackfyre') => 'Botswana',
		esc_html__('Brazil','blackfyre') => 'Brazil',
		esc_html__('Brunei ','blackfyre') => 'Brunei ',
		esc_html__('Bulgaria','blackfyre') => 'Bulgaria',
		esc_html__('Burkina Faso','blackfyre') => 'Burkina Faso',
		esc_html__('Burma','blackfyre') => 'Burma',
		esc_html__('Burundi','blackfyre') => 'Burundi',
		esc_html__('Cambodia','blackfyre') => 'Cambodia',
		esc_html__('Cameroon','blackfyre') => 'Cameroon',
		esc_html__('Canada','blackfyre') => 'Canada',
		esc_html__('Cape Verde','blackfyre') => 'Cape Verde',
		esc_html__('Central African Republic','blackfyre') => 'Central African Republic',
		esc_html__('Chad','blackfyre') => 'Chad',
		esc_html__('Chile','blackfyre') => 'Chile',
		esc_html__('China','blackfyre') => 'China',
		esc_html__('Colombia','blackfyre') => 'Colombia',
		esc_html__('Comoros','blackfyre') => 'Comoros',
		esc_html__('Congo, Democratic Republic of the','blackfyre') => 'Congo, Democratic Republic of the',
		esc_html__('Congo, Republic of the','blackfyre') => 'Congo, Republic of the',
		esc_html__('Costa Rica','blackfyre') => 'Costa Rica',
		esc_html__('Cote d\'Ivoire', 'blackfyre') => 'Cote d\'Ivoire',
		esc_html__('Croatia','blackfyre') => 'Croatia',
		esc_html__('Cuba','blackfyre') => 'Cuba',
		esc_html__('Curacao','blackfyre') => 'Curacao',
		esc_html__('Cyprus','blackfyre') => 'Cyprus',
		esc_html__('Czech Republic','blackfyre') => 'Czech Republic',
		esc_html__('Denmark','blackfyre') => 'Denmark',
		esc_html__('Djibouti','blackfyre') => 'Djibouti',
		esc_html__('Dominica','blackfyre') => 'Dominica',
		esc_html__('Dominican Republic','blackfyre') => 'Dominican Republic',
		esc_html__('Ecuador','blackfyre') => 'Ecuador',
		esc_html__('Egypt','blackfyre') => 'Egypt',
		esc_html__('El Salvador','blackfyre') => 'El Salvador',
		esc_html__('Equatorial Guinea','blackfyre') => 'Equatorial Guinea',
		esc_html__('Eritrea','blackfyre') => 'Eritrea',
		esc_html__('Estonia','blackfyre') => 'Estonia',
		esc_html__('Ethiopia','blackfyre') => 'Ethiopia',
		esc_html__('Fiji','blackfyre') => 'Fiji',
		esc_html__('Finland','blackfyre') => 'Finland',
		esc_html__('France','blackfyre') => 'France',
		esc_html__('Gabon','blackfyre') => 'Gabon',
		esc_html__('Gambia, The','blackfyre') => 'Gambia, The',
		esc_html__('Georgia','blackfyre') => 'Georgia',
		esc_html__('Germany','blackfyre') => 'Germany',
		esc_html__('Ghana','blackfyre') => 'Ghana',
		esc_html__('Greece','blackfyre') => 'Greece',
		esc_html__('Grenada','blackfyre') => 'Grenada',
		esc_html__('Guatemala','blackfyre') => 'Guatemala',
		esc_html__('Guinea','blackfyre') => 'Guinea',
		esc_html__('Guinea-Bissau','blackfyre') => 'Guinea-Bissau',
		esc_html__('Guyana','blackfyre') => 'Guyana',
		esc_html__('Haiti','blackfyre') => 'Haiti',
		esc_html__('Holy See','blackfyre') => 'Holy See',
		esc_html__('Honduras','blackfyre') => 'Honduras',
		esc_html__('Hong Kong','blackfyre') => 'Hong Kong',
		esc_html__('Hungary','blackfyre') => 'Hungary',
		esc_html__('Iceland','blackfyre') => 'Iceland',
		esc_html__('India','blackfyre') => 'India',
		esc_html__('Indonesia','blackfyre') => 'Indonesia',
		esc_html__('Iran','blackfyre') => 'Iran',
		esc_html__('Iraq','blackfyre') => 'Iraq',
		esc_html__('Ireland','blackfyre') => 'Ireland',
		esc_html__('Israel','blackfyre') => 'Israel',
		esc_html__('Italy','blackfyre') => 'Italy',
		esc_html__('Jamaica','blackfyre') => 'Jamaica',
		esc_html__('Japan','blackfyre') => 'Japan',
		esc_html__('Jordan','blackfyre') => 'Jordan',
		esc_html__('Kazakhstan','blackfyre') => 'Kazakhstan',
		esc_html__('Kenya','blackfyre') => 'Kenya',
		esc_html__('Kiribati','blackfyre') => 'Kiribati',
		esc_html__('Korea, North','blackfyre') => 'Korea, North',
		esc_html__('Korea, South','blackfyre') => 'Korea, South',
		esc_html__('Kosovo','blackfyre') => 'Kosovo',
		esc_html__('Kuwait','blackfyre') => 'Kuwait',
		esc_html__('Kyrgyzstan','blackfyre') => 'Kyrgyzstan',
		esc_html__('Laos','blackfyre') => 'Laos',
		esc_html__('Latvia','blackfyre') => 'Latvia',
		esc_html__('Lebanon','blackfyre') => 'Lebanon',
		esc_html__('Lesotho','blackfyre') => 'Lesotho',
		esc_html__('Liberia','blackfyre') => 'Liberia',
		esc_html__('Libya','blackfyre') => 'Libya',
		esc_html__('Liechtenstein','blackfyre') => 'Liechtenstein',
		esc_html__('Lithuania','blackfyre') => 'Lithuania',
		esc_html__('Luxembourg','blackfyre') => 'Luxembourg',
		esc_html__('Macau','blackfyre') => 'Macau',
		esc_html__('Macedonia','blackfyre') => 'Macedonia',
		esc_html__('Madagascar','blackfyre') => 'Madagascar',
		esc_html__('Malawi','blackfyre') => 'Malawi',
		esc_html__('Malaysia','blackfyre') => 'Malaysia',
		esc_html__('Maldives','blackfyre') => 'Maldives',
		esc_html__('Mali','blackfyre') => 'Mali',
		esc_html__('Malta','blackfyre') => 'Malta',
		esc_html__('Marshall Islands','blackfyre') => 'Marshall Islands',
		esc_html__('Mauritania','blackfyre') => 'Mauritania',
		esc_html__('Mauritius','blackfyre') => 'Mauritius',
		esc_html__('Mexico','blackfyre') => 'Mexico',
		esc_html__('Micronesia','blackfyre') => 'Micronesia',
		esc_html__('Moldova','blackfyre') => 'Moldova',
		esc_html__('Monaco','blackfyre') => 'Monaco',
		esc_html__('Mongolia','blackfyre') => 'Mongolia',
		esc_html__('Montenegro','blackfyre') => 'Montenegro',
		esc_html__('Morocco','blackfyre') => 'Morocco',
		esc_html__('Mozambique','blackfyre') => 'Mozambique',
		esc_html__('Namibia','blackfyre') => 'Namibia',
		esc_html__('Nauru','blackfyre') => 'Nauru',
		esc_html__('Nepal','blackfyre') => 'Nepal',
		esc_html__('Netherlands','blackfyre') => 'Netherlands',
		esc_html__('Netherlands Antilles','blackfyre') => 'Netherlands Antilles',
		esc_html__('New Zealand','blackfyre') => 'New Zealand',
		esc_html__('Nicaragua','blackfyre') => 'Nicaragua',
		esc_html__('Niger','blackfyre') => 'Niger',
		esc_html__('Nigeria','blackfyre') => 'Nigeria',
		esc_html__('North Korea','blackfyre') => 'North Korea',
		esc_html__('Norway','blackfyre') => 'Norway',
		esc_html__('Oman','blackfyre') => 'Oman',
		esc_html__('Pakistan','blackfyre') => 'Pakistan',
		esc_html__('Palau','blackfyre') => 'Palau',
		esc_html__('Palestinian Territories','blackfyre') => 'Palestinian Territories',
		esc_html__('Panama','blackfyre') => 'Panama',
		esc_html__('Papua New Guinea','blackfyre') => 'Papua New Guinea',
		esc_html__('Paraguay','blackfyre') => 'Paraguay',
		esc_html__('Peru','blackfyre') => 'Peru',
		esc_html__('Philippines','blackfyre') => 'Philippines',
		esc_html__('Poland','blackfyre') => 'Poland',
		esc_html__('Portugal','blackfyre') => 'Portugal',
		esc_html__('Qatar','blackfyre') => 'Qatar',
		esc_html__('Romania','blackfyre') => 'Romania',
		esc_html__('Russia','blackfyre') => 'Russia',
		esc_html__('Rwanda','blackfyre') => 'Rwanda',
		esc_html__('Saint Kitts and Nevis','blackfyre') => 'Saint Kitts and Nevis',
		esc_html__('Saint Lucia','blackfyre') => 'Saint Lucia',
		esc_html__('Saint Vincent and the Grenadines','blackfyre') => 'Saint Vincent and the Grenadines',
		esc_html__('Samoa ','blackfyre') => 'Samoa ',
		esc_html__('San Marino','blackfyre') => 'San Marino',
		esc_html__('Sao Tome and Principe','blackfyre') => 'Sao Tome and Principe',
		esc_html__('Saudi Arabia','blackfyre') => 'Saudi Arabia',
		esc_html__('Senegal','blackfyre') => 'Senegal',
		esc_html__('Serbia','blackfyre') => 'Serbia',
		esc_html__('Seychelles','blackfyre') => 'Seychelles',
		esc_html__('Sierra Leone','blackfyre') => 'Sierra Leone',
		esc_html__('Singapore','blackfyre') => 'Singapore',
		esc_html__('Sint Maarten','blackfyre') => 'Sint Maarten',
		esc_html__('Slovakia','blackfyre') => 'Slovakia',
		esc_html__('Slovenia','blackfyre') => 'Slovenia',
		esc_html__('Solomon Islands','blackfyre') => 'Solomon Islands',
		esc_html__('Somalia','blackfyre') => 'Somalia',
		esc_html__('South Africa','blackfyre') => 'South Africa',
		esc_html__('South Korea','blackfyre') => 'South Korea',
		esc_html__('South Sudan','blackfyre') => 'South Sudan',
		esc_html__('Spain ','blackfyre') => 'Spain ',
		esc_html__('Sri Lanka','blackfyre') => 'Sri Lanka',
		esc_html__('Sudan','blackfyre') => 'Sudan',
		esc_html__('Suriname','blackfyre') => 'Suriname',
		esc_html__('Swaziland ','blackfyre') => 'Swaziland ',
		esc_html__('Sweden','blackfyre') => 'Sweden',
		esc_html__('Switzerland','blackfyre') => 'Switzerland',
		esc_html__('Syria','blackfyre') => 'Syria',
		esc_html__('Taiwan','blackfyre') => 'Taiwan',
		esc_html__('Tajikistan','blackfyre') => 'Tajikistan',
		esc_html__('Tanzania','blackfyre') => 'Tanzania',
		esc_html__('Thailand ','blackfyre') => 'Thailand ',
		esc_html__('Timor-Leste','blackfyre') => 'Timor-Leste',
		esc_html__('Togo','blackfyre') => 'Togo',
		esc_html__('Tonga','blackfyre') => 'Tonga',
		esc_html__('Trinidad and Tobago','blackfyre') => 'Trinidad and Tobago',
		esc_html__('Tunisia','blackfyre') => 'Tunisia',
		esc_html__('Turkey','blackfyre') => 'Turkey',
		esc_html__('Turkmenistan','blackfyre') => 'Turkmenistan',
		esc_html__('Tuvalu','blackfyre') => 'Tuvalu',
		esc_html__('Uganda','blackfyre') => 'Uganda',
		esc_html__('Ukraine','blackfyre') => 'Ukraine',
		esc_html__('United Arab Emirates','blackfyre') => 'United Arab Emirates',
		esc_html__('United Kingdom','blackfyre') => 'United Kingdom',
		esc_html__('United States of America','blackfyre') => 'United States of America',
		esc_html__('Uruguay','blackfyre') => 'Uruguay',
		esc_html__('Uzbekistan','blackfyre') => 'Uzbekistan',
		esc_html__('Vanuatu','blackfyre') => 'Vanuatu',
		esc_html__('Venezuela','blackfyre') => 'Venezuela',
		esc_html__('Vietnam','blackfyre') => 'Vietnam',
		esc_html__('Yemen','blackfyre') => 'Yemen',
		esc_html__('Zambia','blackfyre') => 'Zambia',
		esc_html__('Zimbabwe','blackfyre') => 'Zimbabwe',

    ),
            'description' => esc_html__( 'Choose your clan country.', 'blackfyre' )
        ),
     array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Clan language', 'blackfyre' ),
            'param_name' => 'el_languages',
            'value' => array(
		esc_html__('Abkhaz', 'blackfyre') => 'Abkhaz',
		esc_html__('Adyghe','blackfyre') => 'Adyghe',
		esc_html__('Afrikaans','blackfyre') => 'Afrikaans' ,
		esc_html__('Akan','blackfyre') => 'Akan' ,
		esc_html__('American Sign Language','blackfyre') => 'American Sign Language',
		esc_html__('Amharic','blackfyre') => 'Amharic',
		esc_html__('Ancient Greek','blackfyre') => 'Ancient Greek',
		esc_html__('Arabic','blackfyre') => 'Arabic',
		esc_html__('Aragonese','blackfyre') => 'Aragonese',
		esc_html__('Armenian','blackfyre') => 'Armenian',
		esc_html__('Aymara','blackfyre') => 'Aymara',
		esc_html__('Balinese','blackfyre') => 'Balinese',
		esc_html__('Basque','blackfyre') => 'Basque' ,
		esc_html__('Betawi','blackfyre') => 'Betawi',
		esc_html__('Bosnian','blackfyre') => 'Bosnian',
		esc_html__('Breton','blackfyre') =>  'Breton',
		esc_html__('Bulgarian','blackfyre') => 'Bulgarian',
		esc_html__('Cantonese','blackfyre') => 'Cantonese' ,
		esc_html__('Catalan','blackfyre') => 'Catalan' ,
		esc_html__('Cherokee','blackfyre') => 'Cherokee',
		esc_html__('Chickasaw','blackfyre') => 'Chickasaw' ,
		esc_html__('Chinese','blackfyre') => 'Chinese'  ,
		esc_html__('Coptic','blackfyre') =>  'Coptic',
		esc_html__('Cornish','blackfyre') => 'Cornish',
		esc_html__('Corsican','blackfyre') => 'Corsican',
		esc_html__('Crimean Tatar','blackfyre') => 'Crimean Tatar',
		esc_html__('Croatian','blackfyre') => 'Croatian',
		esc_html__('Czech','blackfyre') =>  'Czech',
		esc_html__('Danish','blackfyre') => 'Danish' ,
		esc_html__('Dawro','blackfyre') => 'Dawro' ,
		esc_html__('Dutch','blackfyre') => 'Dutch',
		esc_html__('English','blackfyre') =>  'English' ,
		esc_html__('Esperanto','blackfyre') =>  'Esperanto',
		esc_html__('Estonian','blackfyre') => 'Estonian',
		esc_html__('Ewe','blackfyre') => 'Ewe',
		esc_html__('Fiji Hindi','blackfyre') => 'Fiji Hindi' ,
		esc_html__('Filipino','blackfyre') => 'Filipino' ,
		esc_html__('Finnish','blackfyre') =>'Finnish' ,
		esc_html__('French','blackfyre') =>'French' ,
		esc_html__('Galician','blackfyre') => 'Galician',
		esc_html__('Georgian','blackfyre') => 'Georgian',
		esc_html__('German','blackfyre') => 'German' ,
		esc_html__('Greek, Modern','blackfyre') => 'Greek, Modern' ,
		esc_html__('Greenlandic','blackfyre') =>  'Greenlandic' ,
		esc_html__('Haitian Creole','blackfyre') => 'Haitian Creole' ,
		esc_html__('Hawaiian','blackfyre') =>  'Hawaiian',
		esc_html__('Hebrew','blackfyre') =>  'Hebrew',
		esc_html__('Hindi','blackfyre') =>  'Hindi',
		esc_html__('Hungarian','blackfyre') => 'Hungarian' ,
		esc_html__('Icelandic','blackfyre') =>  'Icelandic',
		esc_html__('Indonesian','blackfyre') => 'Indonesian' ,
		esc_html__('Interlingua','blackfyre') => 'Interlingua' ,
		esc_html__('Inuktitut','blackfyre') =>'Inuktitut' ,
		esc_html__('Irish','blackfyre') => 'Irish' ,
		esc_html__('Italian','blackfyre') => 'Italian',
		esc_html__('Japanese','blackfyre') =>  'Japanese',
		esc_html__('Kabardian','blackfyre') =>  'Kabardian',
		esc_html__('Kannada','blackfyre') =>  'Kannada',
		esc_html__('Kashubian','blackfyre') =>  'Kashubian' ,
		esc_html__('Khmer','blackfyre') => 'Khmer' ,
		esc_html__('Kinyarwanda','blackfyre') => 'Kinyarwanda' ,
		esc_html__('Korean','blackfyre') =>  'Korean' ,
		esc_html__('Kurdish/Kurdî','blackfyre') => 'Kurdish/Kurdî',
		esc_html__('Ladin','blackfyre') =>'Ladin' ,
		esc_html__('Latgalian','blackfyre') => 'Latgalian',
		esc_html__('Latin','blackfyre') => 'Latin',
		esc_html__('Lingala','blackfyre') =>  'Lingala',
		esc_html__('Livonian','blackfyre') =>  'Livonian',
		esc_html__('Lojban','blackfyre') => 'Lojban',
		esc_html__('Low German','blackfyre') =>  'Low German',
		esc_html__('Lower Sorbian','blackfyre') =>  'Lower Sorbian',
		esc_html__('Macedonian','blackfyre') => 'Macedonian',
		esc_html__('Malay','blackfyre') =>  'Malay',
		esc_html__('Malayalam','blackfyre') => 'Malayalam',
		esc_html__('Mandarin','blackfyre') => 'Mandarin',
		esc_html__('Manx','blackfyre') => 'Manx' ,
		esc_html__('Maori','blackfyre') =>  'Maori',
		esc_html__('Mauritian Creole','blackfyre') => 'Mauritian Creole',
		esc_html__('Min Nan','blackfyre') => 'Min Nan',
		esc_html__('Mongolian','blackfyre') => 'Mongolian',
		esc_html__('Norwegian','blackfyre') => 'Norwegian',
		esc_html__('Old Armenian','blackfyre') => 'Old Armenian',
		esc_html__('Old English','blackfyre') =>  'Old English',
		esc_html__('Old French','blackfyre') =>'Old French' ,
		esc_html__('Old Norse','blackfyre') =>'Old Norse' ,
		esc_html__('Old Prussian','blackfyre') => 'Old Prussian',
		esc_html__('Oriya','blackfyre') => 'Oriya',
		esc_html__('Pangasinan','blackfyre') => 'Pangasinan',
		esc_html__('Papiamentu','blackfyre') =>  'Papiamentu',
		esc_html__('Pashto','blackfyre') => 'Pashto',
		esc_html__('Persian','blackfyre') => 'Persian',
		esc_html__('Pitjantjatjara','blackfyre') => 'Pitjantjatjara',
		esc_html__('Polish','blackfyre') =>'Polish' ,
		esc_html__('Portuguese','blackfyre') => 'Portuguese',
		esc_html__('Proto-Slavic','blackfyre') => 'Proto-Slavic',
		esc_html__('Rapa Nui','blackfyre') => 'Rapa Nui',
		esc_html__('Romanian','blackfyre') =>'Romanian' ,
		esc_html__('Russian','blackfyre') => 'Russian',
		esc_html__('Sanskrit','blackfyre') =>  'Sanskrit',
		esc_html__('Scots','blackfyre') => 'Scots',
		esc_html__('Scottish Gaelic','blackfyre') =>'Scottish Gaelic' ,
		esc_html__('Serbian','blackfyre') =>'Serbian' ,
		esc_html__('Serbo-Croatian','blackfyre') => 'Serbo-Croatian',
		esc_html__('Sina Bidoyoh','blackfyre') => 'Sina Bidoyoh',
		esc_html__('Sinhalese','blackfyre') => 'Sinhalese',
		esc_html__('Slovak','blackfyre') => 'Slovak',
		esc_html__('Slovene','blackfyre') => 'Slovene',
		esc_html__('Spanish','blackfyre') =>'Spanish' ,
		esc_html__('Swahili','blackfyre') => 'Swahili',
		esc_html__('Swedish','blackfyre') => 'Swedish',
		esc_html__('Tagalog','blackfyre') => 'Tagalog',
		esc_html__('Tajik','blackfyre') => 'Tajik',
		esc_html__('Tamil','blackfyre') =>'Tamil',
		esc_html__('Tarantino','blackfyre') => 'Tarantino',
		esc_html__('Telugu','blackfyre') => 'Telugu',
		esc_html__('Thai','blackfyre') => 'Thai',
		esc_html__('Tok Pisin','blackfyre') => 'Tok Pisin' ,
		esc_html__('Turkish','blackfyre') => 'Turkish' ,
		esc_html__('Twi','blackfyre') => 'Twi' ,
		esc_html__('Ukrainian','blackfyre') =>'Ukrainian' ,
		esc_html__('Upper Sorbian','blackfyre') =>'Upper Sorbian' ,
		esc_html__('Urdu','blackfyre') => 'Urdu' ,
		esc_html__('Uzbek','blackfyre') =>  'Uzbek' ,
		esc_html__('Venetian','blackfyre') => 'Venetian',
		esc_html__('Vietnamese','blackfyre') => 'Vietnamese',
		esc_html__('Vilamovian','blackfyre') => 'Vilamovian' ,
		esc_html__('Volapük','blackfyre') => 'Volapük',
		esc_html__('Võro','blackfyre') => 'Võro' ,
		esc_html__('Welsh','blackfyre') =>  'Welsh' ,
		esc_html__('Xhosa','blackfyre') => 'Xhosa',
		esc_html__('Yiddish','blackfyre') => 'Yiddish' ,

    ),
            'description' => esc_html__( 'Choose your clan language.', 'blackfyre' )
        ),
         array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Founded date', 'blackfyre' ),
            'param_name' => 'el_founded',
            'holder' => 'div',
            'value' => '',
            'description' => esc_html__( 'Add date when your clan was created.', 'blackfyre' )
        ),
         array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Link text 1', 'blackfyre' ),
            'param_name' => 'el_link_text1',
            'holder' => 'div',
            'value' => '',
            'description' => esc_html__( 'Add your link text here.', 'blackfyre' )
        ),
         array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Link 1', 'blackfyre' ),
            'param_name' => 'el_link1',
            'holder' => 'div',
            'value' => '',
            'description' => esc_html__( 'Add your link here.', 'blackfyre' )
        ),
         array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Link text 2', 'blackfyre' ),
            'param_name' => 'el_link_text2',
            'holder' => 'div',
            'value' => '',
            'description' => esc_html__( 'Add your link text here.', 'blackfyre' )
        ),
         array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Link 2', 'blackfyre' ),
            'param_name' => 'el_link2',
            'holder' => 'div',
            'value' => '',
            'description' => esc_html__( 'Add your link here.', 'blackfyre' )
        ),
         array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Link text 3', 'blackfyre' ),
            'param_name' => 'el_link_text3',
            'holder' => 'div',
            'value' => '',
            'description' => esc_html__( 'Add your link text here.', 'blackfyre' )
        ),
         array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Link 3', 'blackfyre' ),
            'param_name' => 'el_link3',
            'holder' => 'div',
            'value' => '',
            'description' => esc_html__( 'Add your link  here.', 'blackfyre' )
        ),
         array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Link text 4', 'blackfyre' ),
            'param_name' => 'el_link_text4',
            'holder' => 'div',
            'value' => '',
            'description' => esc_html__( 'Add your link text here.', 'blackfyre' )
        ),
         array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Link 4', 'blackfyre' ),
            'param_name' => 'el_link4',
            'holder' => 'div',
            'value' => '',
            'description' => esc_html__( 'Add your link here.', 'blackfyre' )
        ),
         array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Link text 5', 'blackfyre' ),
            'param_name' => 'el_link_text5',
            'holder' => 'div',
            'value' => '',
            'description' => esc_html__( 'Add your link text here.', 'blackfyre' )
        ),
         array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Link 5', 'blackfyre' ),
            'param_name' => 'el_link5',
            'holder' => 'div',
            'value' => '',
            'description' => esc_html__( 'Add your link here.', 'blackfyre' )
        ),
     )
) );

/* Clan Games Block
---------------------------------------------------------- */

global $wpClanWars;
$games = $wpClanWars->get_game('id=all&orderby=title&order=asc');

 foreach ( $games as $game ) {
 		$gms[$game->title] = $game->id;
 }

if(!isset($gms))$gms='';
vc_map( array(
    'name' => esc_html__( 'Games Block', 'blackfyre' ),
    'base' => 'vc_clan_games',
    'icon' => 'icon-wpb-layer-shape-text',
    'wrapper_class' => 'clearfix',
    'category' => esc_html__( 'Clan Wars', 'blackfyre' ),
    'description' => esc_html__( 'A list of games that you can select.', 'blackfyre' ),
    'params' => array(
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Title (optional)', 'blackfyre' ),
            'param_name' => 'el_games_title',
            'holder' => 'div',
            'value' => '',
            'description' => esc_html__( 'Add title to your games block.', 'blackfyre' )
        ),
        array(
            'type' => 'checkbox',
            'heading' => esc_html__( 'Games', 'blackfyre' ),
            'param_name' => 'el_games',
            'description' => esc_html__( 'Select games that your clan play.', 'blackfyre' ),
            'value' => $gms
        ),
         array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Extra class name', 'blackfyre' ),
            'param_name' => 'el_class',
            'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'blackfyre' )
        ),


    )
) );



/* Clan Matches Block
---------------------------------------------------------- */
vc_map( array(
    'name' => esc_html__( 'Matches Block', 'blackfyre' ),
    'base' => 'vc_latest_matches',
    'icon' => 'icon-wpb-layer-shape-text',
    'wrapper_class' => 'clearfix',
    'category' => esc_html__( 'Clan Wars', 'blackfyre' ),
    'description' => esc_html__( 'List of matches.', 'blackfyre' ),
    'params' => array(
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Title (optional)', 'blackfyre' ),
            'param_name' => 'el_matches_title',
            'holder' => 'div',
            'value' => '',
            'description' => esc_html__( 'Add title to your matches block.', 'blackfyre' )
        ),
         array(
            'type' => 'checkbox',
            'heading' => esc_html__( 'Games', 'blackfyre' ),
            'param_name' => 'el_match_games',
            'description' => esc_html__( 'Select games for which you want to display matches.', 'blackfyre' ),
            'value' => $gms
        ),
          array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Show matches', 'blackfyre' ),
            'param_name' => 'el_matches_number',
            'holder' => 'div',
            'value' => '',
            'description' => esc_html__( 'Add number of matches you want to display.', 'blackfyre' )
        ),
          array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Hide older than', 'blackfyre' ),
            'param_name' => 'el_matches_hide',
            'holder' => 'div',
             'value' =>  array(
             esc_html__('Show all', 'blackfyre') => 'all',
            esc_html__('1 week', 'blackfyre') => '1w',
            esc_html__('2 weeks', 'blackfyre') => '2w',
            esc_html__('3 weeks', 'blackfyre') => '3w',
            esc_html__('1 month', 'blackfyre') => '1m',
            esc_html__('2 months', 'blackfyre') => '2m',
            esc_html__('3 months', 'blackfyre') => '3m',
            esc_html__('6 months', 'blackfyre') => '6m',
            esc_html__('1 year', 'blackfyre')=> '1y'
            ),
            'description' => esc_html__( 'Hide matches older than.', 'blackfyre' )
        ),
         array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Extra class name', 'blackfyre' ),
            'param_name' => 'el_class',
            'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'blackfyre' )
        ),

    )
) );

/* Clans  Block
---------------------------------------------------------- */
vc_map( array(
    'name' => esc_html__( 'Clans Block', 'blackfyre' ),
    'base' => 'vc_clans',
    'icon' => 'icon-wpb-layer-shape-text',
    'wrapper_class' => 'clearfix',
    'category' => esc_html__( 'Clan Wars', 'blackfyre' ),
    'description' => esc_html__( 'List of clans.', 'blackfyre' ),
    'params' => array(
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Title (optional)', 'blackfyre' ),
            'param_name' => 'el_clans_title',
            'holder' => 'div',
            'value' => '',
            'description' => esc_html__( 'Add title to your matches block.', 'blackfyre' )
        ),
          array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Number of clans to show', 'blackfyre' ),
            'param_name' => 'el_clans_number',
            'holder' => 'div',
            'value' => '',
            'description' => esc_html__( 'Add number of clans that you want to display.', 'blackfyre' )
        ),
         array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Extra class name', 'blackfyre' ),
            'param_name' => 'el_class',
            'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'blackfyre' )
        ),

    )
) );

/* Contact Block
---------------------------------------------------------- */
vc_map( array(
    'name' => esc_html__( 'Contact Block', 'blackfyre' ),
    'base' => 'vc_contact',
    'icon' => 'icon-wpb-layer-shape-text',
    'wrapper_class' => 'clearfix',
    'category' => esc_html__( 'Content', 'blackfyre' ),
    'description' => esc_html__( 'A block with contact form.', 'blackfyre' ),
    'params' => array(
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Title (optional)', 'blackfyre' ),
            'param_name' => 'el_contact_title',
            'holder' => 'div',
            'value' => '',
            'description' => esc_html__( 'Add title to your contact block.', 'blackfyre' )
        )
    )
) );


/* Social Block
---------------------------------------------------------- */
vc_map( array(
    'name' => esc_html__( 'Social media Block', 'blackfyre' ),
    'base' => 'vc_social',
    'icon' => 'icon-wpb-layer-shape-text',
    'wrapper_class' => 'clearfix',
    'category' => esc_html__( 'Content', 'blackfyre' ),
    'description' => esc_html__( 'Add social media links', 'blackfyre' ),
    'params' => array(
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Title (optional)', 'blackfyre' ),
            'param_name' => 'el_social_title',
            'holder' => 'div',
            'value' => '',
            'description' => esc_html__( 'Add title to your social media block.', 'blackfyre' )
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Rss link', 'blackfyre' ),
            'param_name' => 'el_social_rss',
            'holder' => 'div',
            'value' => '',
            'description' => esc_html__( 'Add link to your Rss feed.', 'blackfyre' )
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Dribbble link', 'blackfyre' ),
            'param_name' => 'el_social_dribbble',
            'holder' => 'div',
            'value' => '',
            'description' => esc_html__( 'Add link to your Dribbble profile.', 'blackfyre' )
        ),
         array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Vimeo link', 'blackfyre' ),
            'param_name' => 'el_social_vimeo',
            'holder' => 'div',
            'value' => '',
            'description' => esc_html__( 'Add link to your Vimeo profile.', 'blackfyre' )
        ),
         array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Youtube link', 'blackfyre' ),
            'param_name' => 'el_social_youtube',
            'holder' => 'div',
            'value' => '',
            'description' => esc_html__( 'Add link to your Youtube profile.', 'blackfyre' )
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Twitch link', 'blackfyre' ),
            'param_name' => 'el_social_twitch',
            'holder' => 'div',
            'value' => '',
            'description' => esc_html__( 'Add link to your Twitch profile.', 'blackfyre' )
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Steam link', 'blackfyre' ),
            'param_name' => 'el_social_steam',
            'holder' => 'div',
            'value' => '',
            'description' => esc_html__( 'Add link to your Steam profile.', 'blackfyre' )
        ),
         array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Pinterest link', 'blackfyre' ),
            'param_name' => 'el_social_pinterest',
            'holder' => 'div',
            'value' => '',
            'description' => esc_html__( 'Add link to your Pinterest profile.', 'blackfyre' )
        ),
         array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Google+ link', 'blackfyre' ),
            'param_name' => 'el_social_google',
            'holder' => 'div',
            'value' => '',
            'description' => esc_html__( 'Add link to your Google+ profile.', 'blackfyre' )
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Twitter link', 'blackfyre' ),
            'param_name' => 'el_social_twitter',
            'holder' => 'div',
            'value' => '',
            'description' => esc_html__( 'Add link to your Twitter profile.', 'blackfyre' )
        ),
         array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Facebook link', 'blackfyre' ),
            'param_name' => 'el_social_facebook',
            'holder' => 'div',
            'value' => '',
            'description' => esc_html__( 'Add link to your Facebook profile.', 'blackfyre' )
        ),

    )
) );


/* Hover image */
vc_map( array(
	'name' => esc_html__( 'Hover Image', 'blackfyre' ),
	'base' => 'vc_hover_image',
	'icon' => 'icon-wpb-single-image',
	'category' => esc_html__( 'Content', 'blackfyre' ),
	'description' => esc_html__( 'Hover image with CSS animation', 'blackfyre' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Widget title', 'blackfyre' ),
			'param_name' => 'title',
			'description' => esc_html__( 'Enter text used as widget title (Note: located above content element).', 'blackfyre' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Image source', 'blackfyre' ),
			'param_name' => 'source',
			'value' => array(
				__( 'Media library', 'blackfyre' ) => 'media_library',
				__( 'External link', 'blackfyre' ) => 'external_link',
				__( 'Featured Image', 'blackfyre' ) => 'featured_image'
			),
			'std' => 'media_library',
			'description' => esc_html__( 'Select image source.', 'blackfyre' )
		),
		array(
			'type' => 'attach_image',
			'heading' => esc_html__( 'Image', 'blackfyre' ),
			'param_name' => 'image',
			'value' => '',
			'description' => esc_html__( 'Select image from media library.', 'blackfyre' ),
			'dependency' => array(
				'element' => 'source',
				'value' => 'media_library'
			),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'External link', 'blackfyre' ),
			'param_name' => 'custom_src',
			'description' => esc_html__( 'Select external link.', 'blackfyre' ),
			'dependency' => array(
				'element' => 'source',
				'value' => 'external_link'
			),
		),


		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Caption', 'blackfyre' ),
			'param_name' => 'caption',
			'description' => esc_html__( 'Enter text for image caption.', 'blackfyre' ),
			'dependency' => array(
				'element' => 'source',
				'value' => 'external_link'
			),
		),
		$vc_add_css_animation,
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Extra class name', 'blackfyre' ),
			'param_name' => 'el_class',
			'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'blackfyre' )
		),
		array(
			'type' => 'css_editor',
			'heading' => esc_html__( 'CSS box', 'blackfyre' ),
			'param_name' => 'css',
			'group' => esc_html__( 'Design Options', 'blackfyre' )
		),
		// backward compatibility. since 4.6
		array(
			'type' => 'hidden',
			'param_name' => 'img_link_large'
		)
	)
) );


/* Text Block
---------------------------------------------------------- */
$allowed_tags = array(
	'p' => array(),
);
vc_map( array(
	'name' => esc_html__( 'Boxed Text Block', 'blackfyre' ),
	'base' => 'vc_column_boxed_text',
	'icon' => 'icon-wpb-layer-shape-text',
	'wrapper_class' => 'clearfix',
	'category' => esc_html__( 'Content', 'blackfyre' ),
	'description' => esc_html__( 'A block of text with WYSIWYG editor', 'blackfyre' ),
	'params' => array(
	 array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Title (optional)', 'blackfyre' ),
            'param_name' => 'el_text_title',
            'holder' => 'div',
            'value' => '',
            'description' => esc_html__( 'Add title to your text block.', 'blackfyre' )
        ),
        array(
            'type' => 'checkbox',
            'heading' => esc_html__( 'Remove background.', 'blackfyre' ),
            'param_name' => 'remove_boxed',
            'description' => esc_html__( 'Remove the blocks background', 'blackfyre' ),
            'value' => array( esc_html__( 'Yes, please', 'blackfyre' ) => 'Yes' )
        ),
		array(
			'type' => 'textarea_html',
			'holder' => 'div',
			'heading' => esc_html__( 'Text', 'blackfyre' ),
			'param_name' => 'content',
			'value' => wp_kses(__('<p>I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>', 'blackfyre' ), $allowed_tags)
		),
		$vc_add_css_animation,
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Extra class name', 'blackfyre' ),
			'param_name' => 'el_class',
			'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'blackfyre' )
		),
		array(
			'type' => 'css_editor',
			'heading' => esc_html__( 'CSS box', 'blackfyre' ),
			'param_name' => 'css',
			'group' => esc_html__( 'Design Options', 'blackfyre' )
		)
	)
) );


/* Popular Posts
---------------------------------------------------------- */
vc_map( array(
    'name' => esc_html__( 'Popular Posts Block', 'blackfyre' ),
    'base' => 'vc_popular_posts',
    'icon' => 'icon-wpb-layer-shape-text',
    'wrapper_class' => 'clearfix',
    'category' => esc_html__( 'Content', 'blackfyre' ),
    'description' => esc_html__( 'A block for popular posts', 'blackfyre' ),
    'params' => array(
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Title (optional)', 'blackfyre' ),
            'param_name' => 'el_pp_title',
            'holder' => 'div',
            'value' => '',
            'description' => esc_html__( 'Add title to your popular posts block.', 'blackfyre' )
        ),
        array(
            'type' => 'checkbox',
            'heading' => esc_html__( 'Categories', 'blackfyre' ),
            'param_name' => 'el_pp_categories',
            'description' => esc_html__( 'Select categories you want to include.', 'blackfyre' ),
            'value' => $cats,
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Number of posts to show', 'blackfyre' ),
            'param_name' => 'el_pp_number_posts',
            'holder' => 'div',
            'value' => '',
            'description' => esc_html__( 'Enter number of posts you wolud like to show in this block.', 'blackfyre' )
        ),
         array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Extra class name', 'blackfyre' ),
            'param_name' => 'el_class',
            'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'blackfyre' )
        ),


    )
) );


}