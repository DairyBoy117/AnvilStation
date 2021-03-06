<?php
/*
 * Template name: All matches page
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
<div class="page normal-page <?php if ( of_get_option('fullwidth') ) {  }else{ echo "container"; } ?>">
      <?php if ( of_get_option('fullwidth') ) { ?><div class="container"><?php } ?>
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <?php while ( have_posts() ) : the_post(); ?>
                <?php echo do_shortcode('[wp-clanwars]') ?>
                <?php endwhile; // end of the loop. ?>
            <div class="clear"></div>
            </div>
        </div>
     <?php if ( of_get_option('fullwidth') ) { ?></div><?php } ?>
</div>
<?php get_footer(); ?>