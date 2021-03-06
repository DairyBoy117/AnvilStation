<?php
/*
* Single Post Template: Full width
*/
?>
<?php get_header(); ?>

 <!-- Page content
================================================== -->
<!-- Wrap the rest of the page in another container to center all the content. -->
<div class=" blog blog-ind container">
	<div class="row">

		<div class="col-lg-12 col-md-12">

				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					<?php require_once (get_template_directory() .'/blog-single.php'); ?>
				<?php endwhile; endif; ?>
				<div class="clear"></div>

				<div class="pagination">
						<?php
						$args = array(
			                'before'           => '<ul>',
			                'after'            => '</ul>',
			                'link_before'      => '',
			                'link_after'       => '',
			                'next_or_number'   => 'next_and_number',
			                'separator'        => '',
			                'nextpagelink'     => '&raquo;',
			                'previouspagelink' => '&laquo;',
			                'pagelink'         => '%',
			                'echo'             => 1
        				);
        				wp_link_pages($args); ?>
				</div>

				<?php if(comments_open()){ ?>
					<div id="comments"  class="block-divider"></div>
					<?php comments_template('/short-comments-blog.php'); ?>
				<?php } ?>

		</div><!-- /.span12 -->

	</div><!-- /row -->

</div><!-- /blog -->

<?php get_footer(); ?>