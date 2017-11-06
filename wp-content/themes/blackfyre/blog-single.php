<div class="blog-post"><!-- blog-post -->

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
                  <?php
                   $thumb = get_post_thumbnail_id();
                   $img_url = wp_get_attachment_url( $thumb,'full'); //get img URL
                   $image = blackfyre_aq_resize( $img_url, 817, 320, true, '', true ); //resize & crop img
                   ?><img alt="img" src="<?php echo esc_url($image[0]); ?>" />
              <?php }else{ ?>
                 <img alt="img" src="<?php echo esc_url(get_template_directory_uri()); ?>/img/defaults/default-banner.jpg" />
             <?php } ?>
             <div class="blog-date">
                <span class="date"><?php the_time('M'); ?><br /><?php the_time('d'); ?></span>
                <div class="plove"><?php if( function_exists('heart_love') && of_get_option('heart_rating') == '1'  ) heart_love(); ?></div>
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

	<div class="blog-info"><!-- blog-info -->
		<div class="post-pinfo">

			<a data-original-title="<?php esc_html_e("View all posts by", 'blackfyre'); ?> <?php echo esc_attr(get_the_author()); ?>" data-toggle="tooltip" href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ))); ?>"><?php echo get_avatar( get_the_author_meta('ID'), 60, '', 'author image', array('class' => 'authorimg') ); ?> by <?php echo esc_attr(get_the_author()); ?></a>
			<i>|</i>
			<?php $postcats = wp_get_post_categories($post->ID); if ($postcats) {?>  <?php foreach($postcats as $c) {$cat = get_category( $c ); ?>  <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>"> <?php echo esc_attr($cat->cat_name) . ' '; ?> </a><?php } ?> 	<i>|</i> <?php } ?>


			<?php if ( is_plugin_active( 'disqus-comment-system/disqus.php' )){ ?>
	        <a  href="<?php echo the_permalink(); ?>#comments" >
	        <?php comments_number( esc_html__('0 Comments', 'blackfyre'), esc_html__('1 Comment', 'blackfyre'), esc_html__('% Comments', 'blackfyre') ) ?> </a>
	       <?php }else{ ?>
	        <a data-original-title="<?php comments_number( esc_html__('No comments in this post', 'blackfyre'), esc_html__('One comment in this post', 'blackfyre'), esc_html__('% comments in this post', 'blackfyre')); ?>" href="<?php echo the_permalink(); ?>#comments" data-toggle="tooltip">
	         <?php comments_number( esc_html__('0 Comments', 'blackfyre'), esc_html__('1 Comment', 'blackfyre'), esc_html__('% Comments', 'blackfyre') ) ?></a>

	       <?php } ?>

			<i>|</i>
	       <span class="date"> <?php the_time('d'); ?> <?php the_time('M'); ?> <?php the_time('Y'); ?></span>

		</div>
		 <?php if(of_get_option('share_this')){ ?>
                    <div class="sharepost">
                        <span class='st_sharethis_hcount' displayText='ShareThis'></span>
                        <span class='st_facebook_hcount' displayText='Facebook'></span>
                        <span class='st_twitter_hcount' displayText='Tweet'></span>
                        <span class='st_reddit_hcount' displayText='Red1dit'></span>
                        <span class='st_email_hcount' displayText='Email'></span>
                    </div>
                    <?php } ?>
	<div class="clear"></div>
	</div><!-- blog-info -->


	<!-- post ratings -->
    <?php
    $overall_rating = get_post_meta($post->ID, 'overall_rating', true);
    $rating_one = get_post_meta($post->ID, 'creteria_1', true);
    $rating_two = get_post_meta($post->ID, 'creteria_2', true);
    $rating_three = get_post_meta($post->ID, 'creteria_3', true);
    $rating_four = get_post_meta($post->ID, 'creteria_4', true);
    $rating_five = get_post_meta($post->ID, 'creteria_5', true);

    if($overall_rating== NULL or $rating_one== NULL && $rating_two== NULL && $rating_three== NULL && $rating_four== NULL && $rating_five== NULL ){

    }else{
    	if(of_get_option('rating_type') == 'stars'){
    	 require(get_template_directory() .'/post-rating.php');
    	 }else{
    	 require(get_template_directory() .'/post-rating-num.php');
    	 }

	} ?><!-- /post ratings -->


	<div class="blog-content wcontainer"><!-- /.blog-content -->
		<?php the_content();?>
	</div><!-- /.blog-content -->

	<div class="clear"></div>
</div><!-- /.blog-post -->