<?php get_header();?>
<!-- Page content
    ================================================== -->
<!-- Wrap the rest of the page in another container to center all the content. -->
<div class="<?php if ( of_get_option('fullwidth') ) {  }else{ ?>container boxed<?php } ?> blog normal-page container-wrap">
	<?php if ( of_get_option('fullwidth') ) { ?> <div class="container"> <?php } ?>
  <div class="row">

    <div class="col-lg-8">

        <?php
        $category_id = of_get_option('blogcat');
        $showposts = get_option('posts_per_page');
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $new_query = new WP_Query();
        $new_query->query( 'showposts='.$showposts.'&cat='.$category_id.'&paged='.$paged );
       ?>
        <?php if ( $new_query->have_posts() ) : while ( $new_query->have_posts() ) : $new_query->the_post(); ?>
    <div class="blog-post <?php if(is_sticky()) echo 'sticky'; ?>" >




		<div class="blog-twrapper">
			<div class="blog-image right">
				 <?php
					 $key_1_value = get_post_meta($post->ID, '_smartmeta_my-awesome-field77', true);
					if($key_1_value != '') {
					  $blackfyre_allowed['iframe'] = array(
                            'src'             => array(),
                            'height'          => array(),
                            'width'           => array(),
                            'frameborder'     => array(),
                            'allowfullscreen' => array(),
                        );
                 echo wp_kses($key_1_value, $blackfyre_allowed,array('http', 'https'));
					}elseif ( has_post_thumbnail() ) { ?>
					  <a href="<?php esc_url(the_permalink()); ?>"> <?php
					   $thumb = get_post_thumbnail_id();
					   $img_url = wp_get_attachment_url( $thumb,'full'); //get img URL
					   $image = blackfyre_aq_resize( $img_url, 817, 320, true, '', true ); //resize & crop img
					   ?><img alt="img" src="<?php echo esc_url($image[0]); ?>" /></a>
                    <?php } ?>
				 <?php if ( has_post_thumbnail() or  $key_1_value != '') { ?>
				 <div class="blog-date">
				 <?php }else{?>
				 <div class="blog-date-noimg">
				 <?php } ?>
					<span class="date"><?php the_time('M'); ?><br /><?php the_time('d'); ?></span>
					<div class="plove"><?php if( function_exists('heart_love') && of_get_option('heart_rating') == '1'  )  heart_love(); ?></div>
				 </div>

						<div class="blog-rating">
						<?php
						// overall stars
						$overall_rating_1 = get_post_meta(get_the_ID(), 'overall_rating', true);
						if($overall_rating_1!="0" && $overall_rating_1=="0.5"){ ?>
						<div class="overall-score"><div class="rating r-05"></div></div>
						<?php } ?>

						<?php $overall_rating_2 = get_post_meta(get_the_ID(), 'overall_rating', true);
						if($overall_rating_2!="0" && $overall_rating_2=="1"){ ?>
						<div class="overall-score"><div class="rating r-1"></div></div>
						<?php } ?>

						<?php $overall_rating_3 = get_post_meta(get_the_ID(), 'overall_rating', true);
						if($overall_rating_3!="0" && $overall_rating_3=="1.5"){ ?>
						<div class="overall-score"><div class="rating r-15"></div></div>
						<?php } ?>

						<?php $overall_rating_4 = get_post_meta(get_the_ID(), 'overall_rating', true);
						if($overall_rating_4!="0" && $overall_rating_4=="2"){ ?>
						<div class="overall-score"><div class="rating r-2"></div></div>
						<?php } ?>

						<?php $overall_rating_5 = get_post_meta(get_the_ID(), 'overall_rating', true);
						if($overall_rating_5!="0" && $overall_rating_5=="2.5"){ ?>
						<div class="overall-score"><div class="rating r-25"></div></div>
						<?php } ?>

						<?php $overall_rating_6 = get_post_meta(get_the_ID(), 'overall_rating', true);
						if($overall_rating_6!="0" && $overall_rating_6=="3"){ ?>
						<div class="overall-score"><div class="rating r-3"></div></div>
						<?php } ?>

						<?php $overall_rating_7 = get_post_meta(get_the_ID(), 'overall_rating', true);
						if($overall_rating_7!="0" && $overall_rating_7=="3.5"){ ?>
						<div class="overall-score"><div class="rating r-35"></div></div>
						<?php } ?>

						<?php $overall_rating_8 = get_post_meta(get_the_ID(), 'overall_rating', true);
						if($overall_rating_8!="0" && $overall_rating_8=="4"){ ?>
						<div class="overall-score"><div class="rating r-4"></div></div>
						<?php } ?>

						<?php $overall_rating_9 = get_post_meta(get_the_ID(), 'overall_rating', true);
						if($overall_rating_9!="0" && $overall_rating_9=="4.5"){ ?>
						<div class="overall-score"><div class="rating r-45"></div></div>
						<?php } ?>

						<?php $overall_rating_10 = get_post_meta(get_the_ID(), 'overall_rating', true);
						if($overall_rating_10!="0" && $overall_rating_10=="5"){ ?>
						<div class="overall-score"><div class="rating r-5"></div></div>

						<?php } ?>
						 </div><!-- blog-rating -->

			</div><!-- blog-image -->

			  <div class="blog-content <?php if ( has_post_thumbnail() or  $key_1_value != '') {  }else{?> blog-content-no-img <?php } ?>">
						<h2><a href="<?php the_permalink(); ?>"> <?php the_title(); ?> </a></h2>
						<?php the_excerpt(10); ?>
			  </div><!-- blog-content -->
		  </div>


         <div class="blog-info">


                    <div class="post-pinfo">
                        <span class="fa fa-user"></span> <a data-original-title="<?php esc_html_e("View all posts by ", 'blackfyre'); ?><?php echo esc_attr(get_the_author()); ?>" data-toggle="tooltip" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo esc_attr(get_the_author()); ?></a> &nbsp;
                        <span class="fa fa-comments-o"></span>

                        <?php if ( is_plugin_active( 'disqus-comment-system/disqus.php' )){ ?>
                        <a  href="<?php echo esc_url(the_permalink()); ?>#comments" >
                        <?php comments_number( esc_html__('No comments', 'blackfyre'), esc_html__('One comment', 'blackfyre'), esc_html__('% comments', 'blackfyre')); ?></a> &nbsp;
                       <?php }else{ ?>
                         <a  href="<?php echo esc_url(the_permalink()); ?>#comments" >
                         	<?php comments_number( esc_html__('No comments', 'blackfyre'), esc_html__('One comment', 'blackfyre'), esc_html__('% comments', 'blackfyre')); ?>
                         </a> &nbsp;
                       <?php } ?>
                        <?php $posttags = get_the_tags();if ($posttags) {?>  <span class="fa fa-tags"></span>  <?php $i = 0; $len = count($posttags); foreach($posttags as $tag) { ?>  <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>"> <?php echo esc_attr($tag->name); if($i != $len - 1) echo ', '; ?> </a><?php  $i++; } }?>
                    </div><!-- post-pinfo -->

                    <a href="<?php the_permalink(); ?>" class="button-small"><?php esc_html_e("Read more", 'blackfyre'); ?></a>

                    <div class="clear"></div>

         </div><!-- blog-info -->
        </div><!-- /.blog-post -->

	 <div class="block-divider"></div>
        <?php endwhile; endif; ?>
        <div class="pagination">
            <ul>
              <li>
                <?php
            $additional_loop = new WP_Query('showposts='.$showposts.'&cat='.$category_id.'&paged='.$paged );
            $page=$additional_loop->max_num_pages;
            echo blackfyre_kriesi_pagination($additional_loop->max_num_pages);
            ?>
            <?php wp_reset_query(); ?>
              </li>
            </ul>
         </div>
        <div class="clear"></div>
</div>
    <!-- /.span8 -->
    <div class="col-lg-4 sidebar">
            <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer widgets') ) : ?>
                <?php dynamic_sidebar('three'); ?>
           <?php endif; ?>
    </div>
    <!-- /.span4 -->
  </div>
  <!-- /.row -->
 <?php if ( of_get_option('fullwidth') ) { ?> </div> <?php } ?> <!-- /container -->
</div>
<!-- /.container -->
<?php get_footer(); ?>