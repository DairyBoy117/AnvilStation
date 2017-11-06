<?php
$a_id = bp_displayed_user_id();
$user = get_userdata($a_id);

 ?>
    <div class="col-lg-8 col-md-8 block">
        <div class="title-wrapper">
        	<h3 class="widget-title"><i class="fa fa-bullhorn"></i> <?php esc_html_e('INTRODUCTION','blackfyre'); ?></h3>
        </div>
        <div class="wcontainer">
            <?php if(get_the_author_meta('description', $a_id)){
                    echo nl2br(get_the_author_meta('description', $a_id));
            } ?>
        </div>
    </div>


		<div class="col-lg-4 col-md-4">
			<div class="block">
	        	<div class="title-wrapper">
	         		<h3 class="widget-title"><i class="fa fa-info-circle"></i> <?php esc_html_e('ABOUT ','blackfyre');  ?> </h3>
				</div>
				<ul class="about-profile">

	            <!--name-->
	            <?php if(get_the_author_meta('first_name', $a_id)){ ?>
	            	<li><strong><?php esc_html_e('NAME: ','blackfyre'); ?></strong>
	            	<?php echo get_the_author_meta('first_name', $a_id); ?>
	            <?php if(get_the_author_meta('last_name', $a_id)){
	                  echo get_the_author_meta('last_name', $a_id);
	            } ?> </li>
	            <?php } ?>
	            <!--name-->



	             <!--location-->
	            <?php
	            if(get_the_author_meta('usercountry_id', $a_id)){
	            $cid = get_the_author_meta('usercountry_id', $a_id);

	            global $wpdb;
	            $table = $wpdb->prefix."user_countries";
	            $countries = $wpdb->get_results("SELECT * FROM $table ORDER BY name");
	            foreach ($countries as $country) {
	                if ($cid==$country->id_country) { $count = $country->name;}
	            }
				?>
	            <li><strong> <?php esc_html_e('LOCATION: ','blackfyre');?></strong> <?php echo esc_attr($count);

	                if(get_the_author_meta('city', $a_id))
	                {echo ', ';echo get_the_author_meta('city', $a_id);} ?>
	            </li>
                <?php } ?>
	            <!--location-->

	            <!--age-->
	            <?php if(get_the_author_meta('age', $a_id) && get_the_author_meta('age', $a_id) != 'none'){ ?>

	            <li><strong><?php esc_html_e('AGE: ','blackfyre');?></strong>
                     <?php
                    $age_base = get_the_author_meta('age', $a_id);

                    $age = DateTime::createFromFormat('d/m/Y', $age_base);

                    if(!$age){
                    $age = DateTime::createFromFormat('m/d/Y', $age_base);
                    }

                    if(!$age){
                    $age = DateTime::createFromFormat('Y-m-d', $age_base);
                    }

                    if(!$age){
                    $age = DateTime::createFromFormat('F j, Y', $age_base);
                    }


                    $age = $age->format('Y-m-d');
                    $age = floor((time() - strtotime($age)) / 31556926);
                    echo $age;

                } ?>
                </li>


	            <!--age-->
					<li>
	            <!--joined-->
	           <strong> <?php esc_html_e('JOINED: ','blackfyre'); ?></strong>
	            <?php echo date("M, Y", strtotime(get_userdata($a_id)->user_registered)); ?>

	            <!--joined-->
					</li>
				  <?php
	            	global $wpdb;
					$custom_profile_fields = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'bp_xprofile_fields');

					if (is_array($custom_profile_fields)) {
						foreach ($custom_profile_fields as $field) {
							if($field->id == 1)continue;
							$query = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$wpdb->prefix.'bp_xprofile_data WHERE user_id= %s AND field_id= %s LIMIT 1' , $a_id, $field->id ));

                            if (isset($query->value)) {
								echo "<li>";
								echo "<strong>".strtoupper($field->name).": </strong>";
								$first = true;
								if (is_serialized($query->value)) {
									$row = unserialize($query->value);
									foreach ($row as $hold) {
										if ($first == true) {
											echo esc_attr($hold);
											$first = false;
										} else {
											echo ", ".esc_attr($hold);
										}
									}
								} else {
									echo esc_attr($query->value);
								}


								echo "</li>";
							}

						}
					}



	            ?>
	            <!--website-->
	            <?php if(get_the_author_meta('user_url', $a_id)){ ?>
	            <li><strong><?php esc_html_e('WEBSITE: ','blackfyre');?></strong>
	               <a target="_blank" href=" <?php echo get_the_author_meta('user_url', $a_id); ?>">   <?php
                     echo get_the_author_meta('user_url', $a_id); ?>
                 </a>
	            </li>
                <?php } ?>
	            <!--website-->

			<?php
			/*
			global $wpdb;
			$a_id = bp_displayed_user_id();
			$custom_profile_fields = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'bp_xprofile_fields');
			if (is_array($custom_profile_fields)) {
				foreach ($custom_profile_fields as $field) {

				bp_member_profile_data(array('field' => $field->name));

				}
			}
			 */

			?>

			</ul>

	        </div>

	         <!--clan-->
                <?php $posts = blackfyre_get_user_clans($a_id);

                if(!empty($posts)){ ?>

			<div class="block profile-clans">
	        	<div class="title-wrapper">
	         		<h3 class="widget-title"><i class="fa fa-crosshairs"></i> <?php esc_html_e('Clans ','blackfyre');  ?> </h3>
				</div>
				<ul class="about-profile">
                <?php
	                    foreach ($posts as $post) {
                                $post = get_post($post);
                                $photo = get_post_meta($post->ID, 'clan_photo',true);
                                if(empty($photo)) $photo = get_template_directory_uri().'/img/defaults/default-clan-50x50.jpg';
	                             echo '<li><a href="'.get_permalink($post->ID).'"><div class="pclan-img"><img alt="img" src="'.esc_url($photo).'"/></div> <div class="pclan-title">'.$post->post_title.'</div><div class="clear"></div></a></li>';
	                        }
	            }
	            wp_reset_query();
	             ?>

	             </ul>
	            <!--clan-->
	        </div>
       </div>
