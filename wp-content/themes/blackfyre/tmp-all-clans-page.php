<?php
/*
 * Template name: All clans page
*/
?>
<?php get_header(); ?>
<?php if (class_exists('BlackfyreMultiPostThumbnails')) : $custombck = BlackfyreMultiPostThumbnails::get_post_thumbnail_url(get_post_type(), 'header-image', $post->ID, 'full'); endif; ?>
<?php if(empty($custombck)){}else{ ?>
<style>
    body.page{
    background-image:url(<?php echo esc_url($custombck); ?>) !important;
    background-position:center top !important;
    background-repeat:  no-repeat !important;
}
</style>
<?php } ?>
<div class="page normal-page all-clans-page <?php if ( of_get_option('fullwidth') ) {  }else{ echo "container"; } ?>">
      <?php if ( of_get_option('fullwidth') ) { ?><div class="container"><?php } ?>
        <div class="row">

            <form class="all-clans-form">
                <label> <input type="text" autocomplete="off" name="clan_name" id="clan_name" placeholder="<?php esc_html_e('Search Teams...', 'blackfyre')?>">
                	<input type="button" id="members_search_submit" name="members_search_submit" value="Search">
                </label>
            </form>

            <div class="col-lg-12 col-md-12">

            <div id="buddypress">
                <div class="wpb_wrapper" id="members">
                    <?php blackfyre_all_clans_pagination_v2()?>
                </div>
            </div>

			<script>

                jQuery('#members_search_submit').on('click', function(event){
                    event.preventDefault();
                    jQuery('#members').load(ajaxurl, {
                        "action":"blackfyre_all_clans_pagination_v2_ajax",
						"href": '?page=1&term='+jQuery('#clan_name').val()
                        });
                });


                jQuery('#members').on('click', '.pagination a', function(event){
                    event.preventDefault();
                    jQuery('#members').load(ajaxurl, {
                        "action":"blackfyre_all_clans_pagination_v2_ajax",
                        "href":jQuery(this).attr('href')
                        });
                });
            </script>


            <div class="clear"></div>
            </div>
        </div>
     <?php if ( of_get_option('fullwidth') ) { ?></div><?php } ?>
</div>
<?php get_footer(); ?>