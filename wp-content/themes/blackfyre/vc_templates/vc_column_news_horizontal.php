<?php
$el_news_horizontal_number_posts = $el_news_horizontal_categories =  $el_news_horizontal_title = $el_class = '';
$posts = array();
extract( shortcode_atts( array(
    'el_news_horizontal_title' => '',
    'el_news_horizontal_number_posts' => '',
    'el_class' => '',
    'el_news_horizontal_categories' => ''
), $atts ) );
if(empty($css))$css = '';
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_text_column wpb_content_element ' . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
?>

<div class="<?php echo esc_attr($css_class); if(!empty($el_class)) echo esc_attr($el_class); ?>">
    <div class="wpb_wrapper">
        <div class="title-wrapper">
            <h3 class="widget-title"><i class="fa fa-newspaper-o"></i> <?php if(!empty($el_news_horizontal_title)) echo esc_attr($el_news_horizontal_title); ?></h3>
            <div class="clear"></div>
        </div>
        <?php
                    // Categories
                    $ct = array();
                    if ( $el_news_horizontal_categories != '' ) {
                        $el_news_horizontal_categories = explode( ",", $el_news_horizontal_categories );
                        foreach ( $el_news_horizontal_categories as $category ) {
                            array_push( $ct, $category );
                        }
                    }

                    $posts = new WP_Query(array(
                        'showposts' => $el_news_horizontal_number_posts,
                        'category__in' => $ct
                    ));
        ?>
        <div class="wcontainer">
          <ul class="newsbv">
               <?php while ( $posts->have_posts() ) : $posts->the_post(); ?>

                <li class="<?php if( $posts->current_post == 0 && !is_paged() ) { ?>newsbv-item-first<?php }else{ echo 'newsbv-item'; }?>">
                <div class="newsb-thumbnail">
                <a rel="bookmark" href="<?php the_permalink(); ?>">


                    <?php if(has_post_thumbnail()){


                            $thumb = get_post_thumbnail_id();
                            $img_url = wp_get_attachment_url( $thumb,'full'); //get img URL

                            if($posts->current_post == 0){
                            $image = blackfyre_aq_resize( $img_url, 305, 305, true, '', true ); //resize & crop img

                                }else{
                            $image = blackfyre_aq_resize( $img_url, 75, 75, true, '', true ); //resize & crop img
                                }
                            ?>
                            <img src="<?php echo esc_url($image[0]); ?>" alt="<?php the_title(); ?>" />

                    <?php } else{
                                if($posts->current_post == 0){ ?>
                                <img src="<?php echo get_template_directory_uri().'/img/defaults/305x305.jpg'?> " alt="<?php the_title(); ?>" />
                            <?php }else{ ?>
                                <img src="<?php echo get_template_directory_uri().'/img/defaults/75x75.jpg'?> " alt="<?php the_title(); ?>" />
                    <?php   }

                     }  ?>

                    <div class="clear"></div>
                </a>
                </div>
                <h4 class="newsb-title"><a rel="bookmark" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                <p class="post-meta">
                    <i class="fa fa-calendar"></i> <?php the_time(get_option('date_format')); ?> -
                      <?php if ( is_plugin_active( 'disqus-comment-system/disqus.php' )){ ?>
                        <a  href="<?php echo the_permalink(); ?>#comments" >
                        <i class="fa fa-comments-o"></i> <?php comments_number( __('0', 'blackfyre'), __('1', 'blackfyre'), __('%', 'blackfyre') ); ?></a> &nbsp;
                       <?php }else{ ?>
                         <a  href="<?php echo esc_url(the_permalink()); ?>#comments" >
                         	<?php comments_number( esc_html__('No comments', 'blackfyre'), esc_html__('One comment', 'blackfyre'), esc_html__('% comments', 'blackfyre')); ?>
                         </a> &nbsp;
                       <?php } ?>
                 </p>
                <?php   if( $posts->current_post == 0 && !is_paged() ) : ?>
                <?php global $more; $more = 1; echo blackfyre_html_cut(get_the_content(),198); echo '[...]'; ?>
                <?php endif; ?>
                <div class="clear"></div>
                </li>


               <?php endwhile; ?>
                </ul>
            <div class="clear"></div>
        </div>
    </div>
</div>