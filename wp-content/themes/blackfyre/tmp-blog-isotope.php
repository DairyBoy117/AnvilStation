<?php
/*
 * Template name: Blog - Isotope
*/
?>
<?php get_header();?>
<?php if (class_exists('MultiPostThumbnails')) : wp_reset_postdata(); $custombck = MultiPostThumbnails::get_post_thumbnail_url(get_post_type(), 'header-image', $post->ID, 'full'); endif; ?>
<?php if(empty($custombck)){}else{ ?>
<?php require_once(get_template_directory() .'/css/header-image-page.css.php'); ?>
<?php } ?>
<!-- Page content
================================================== -->
<!-- Wrap the rest of the page in another container to center all the content. -->
<div class="blog container">

		<div class="row">

			<?php require_once(get_template_directory() .'/blog-roll-full-tmp.php'); ?>

		</div><!-- /row -->

</div><!-- /containerblog -->

<?php get_footer(); ?>