<?php
 /*
 * Template Name: List of clans for selected game
 */
?>
<?php get_header(); ?>
<?php if (class_exists('BlackfyreMultiPostThumbnails')) : wp_reset_postdata(); $custombck = BlackfyreMultiPostThumbnails::get_post_thumbnail_url(get_post_type(), 'header-image', $post->ID, 'full'); endif; ?>
<?php if(empty($custombck)){}else{ ?>
<?php require_once(get_template_directory() .'/css/header-image-page.css.php'); ?>
<?php } ?>
<?php if(isset($_GET['gid'])) $gid = $_GET['gid']; ?>
<div class="page normal-page all-clans-page container">

        <div class="row">

            <form class="all-clans-form">
                <label> <input type="text" autocomplete="off" name="clan_name" id="clan_name" placeholder="<?php esc_html_e('Search Clans...', 'blackfyre')?>">
                	<input type="button" id="members_search_submit" name="members_search_submit" value="Search">
                </label>
            </form>

            <div class="col-lg-12 col-md-12">

            <div id="buddypress">
                <div class="wpb_wrapper" id="members">
                    <?php blackfyre_list_all_clans_for_selected_game($gid); ?>
                </div>
            </div>

			<script>

                jQuery('#members_search_submit').on('click', function(event){
                    event.preventDefault();
                    jQuery('#members').load(ajaxurl, {
                        "action":"blackfyre_list_all_clans_for_selected_game_ajax",
						"href": '&page=1&term='+jQuery('#clan_name').val()
                        });
                });


                jQuery('#members').on('click', '.pagination a', function(event){
                    event.preventDefault();
                    jQuery('#members').load(ajaxurl, {
                        "action":"blackfyre_list_all_clans_for_selected_game_ajax",
                        "href":jQuery(this).attr('href')
                        });
                });
            </script>


            <div class="clear"></div>
            </div>
        </div>

</div>
<?php get_footer(); ?>