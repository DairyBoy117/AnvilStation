<?php
$el_news_tabbed_number_posts = $el_news_tabbed_categories =  $el_news_tabbed_title = $el_class = $el_display_order = '';
$posts = array();
extract( shortcode_atts( array(
    'el_news_tabbed_title' => '',
    'el_news_tabbed_number_posts' => '',
    'el_class' => '',
    'el_news_tabbed_categories' => '',
    'el_display_order'  => ''
), $atts ) );
if(empty($css)) $css = '';
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_text_column wpb_content_element ' . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
wp_enqueue_script('jquery-ui-tabs');
?>

<div class="<?php echo esc_attr($css_class); if(!empty($el_class)) echo esc_attr($el_class); ?>">
    <div class="wpb_wrapper">
        <div class="title-wrapper">
            <h3 class="widget-title"><i class="fa fa-newspaper-o"></i> <?php if(!empty($el_news_tabbed_title)) echo esc_attr($el_news_tabbed_title); ?></h3>
            <div class="clear"></div>
        </div>
        <div class="news_tabbed">
        <div id="block_tabs_<?php echo  rand(1, 100); ?>" class="block_tabs">
            <div class="tab-inner">
                <ul class="nav cf nav-tabs">

                 <?php

                    $ct = array();
                    if ( $el_news_tabbed_categories != '' ) {
                        $el_news_tabbed_categories = explode( ",", $el_news_tabbed_categories );
                        foreach ( $el_news_tabbed_categories as $category ) {
                            array_push( $ct, $category );
                        }
                    }
					if($el_display_order == 'title_asc'){$order_by = 'name'; $order = 'ASC'; }
                    if($el_display_order == 'title_desc'){$order_by = 'name'; $order = 'DESC'; }
					if($el_display_order == 'id_sort_asc'){$order_by = 'term_id'; $order = 'ASC'; }
					if($el_display_order == 'id_sort_desc'){$order_by = 'term_id'; $order = 'DESC'; }

                    $args = array( 'taxonomy' => 'category', 'hide_empty' => true, 'include' => $ct, 'order' => $order, 'orderby' => $order_by  );
                    $terms = get_terms('category', $args);

                    $count = count($terms); $i=0;
                    if ($count > 0) {

                    foreach ($terms as $term) {
                    $i++;

                    echo '<li >
                            <a href="#tab-' .esc_attr($i).'">' . esc_attr($term->name) . '</a>
                        </li>';
                                                }
                                    }  ?>
                </ul>
                <div class="wcontainer">
                <?php
                $j=0;
                foreach ($terms as $term) {
                $j++;
                $termsarray=array();
                $termsarray[]= $term->term_id; ?>
                    <div class="tab tab-content" id="tab-<?php echo esc_attr($j); ?>" >
                        <ul class="newsbv">
                        <?php $post_ids = get_objects_in_term( $termsarray, 'category' ); ?>

                            <?php query_posts(array(  'posts_per_page' => $el_news_tabbed_number_posts, 'post__in' => $post_ids )); ?>
                            <?php $i = 0; ?>
                            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                                <li class="<?php if( $i == 0 ) { ?>newsbv-item-first<?php }else{ echo 'newsbv-item'; }?>">
                                    <div class="newsb-thumbnail">
                                        <a rel="bookmark" href="<?php the_permalink(); ?>">


                                            <?php if(strlen( $img = get_the_post_thumbnail( get_the_ID(), array( 150, 150 ) ) ) ){

                                                    $thumb = get_post_thumbnail_id();
                                                    $img_url = wp_get_attachment_url( $thumb,'full'); //get img URL

                                                    if($i == 0){
                                                    $image = blackfyre_aq_resize( $img_url, 422, 422, true, '', true ); //resize & crop img

                                                        }else{
                                                    $image = blackfyre_aq_resize( $img_url, 75, 75, true, '', true ); //resize & crop img
                                                        }
                                                    ?>
                                                    <img src="<?php echo esc_url($image[0]); ?>" alt="<?php the_title(); ?>" />

                                            <?php } else{
                                                        if($i == 0){ ?>
                                                        <img src="<?php echo get_template_directory_uri().'/img/defaults/305x305.jpg'?> " alt="<?php the_title(); ?>" />
                                                    <?php }else{  ?>
                                                        <img src="<?php echo get_template_directory_uri().'/img/defaults/75x75.jpg'?> " alt="<?php the_title(); ?>" />
                                            <?php   }

                                                }?>
                                            <span class="overlay-link"></span>
                                        </a>
                                    </div><!--newsb-thumbnail -->

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
                                        <?php if( $i == 0 ) : ?>
                                        <?php global $more; $more = 1; echo blackfyre_html_cut(get_the_content(),198);echo '[...]' ?>
                                        <?php endif; ?>

                                </li>
                        <?php $i++; endwhile;endif; ?>

                    <?php wp_reset_query(); ?>
                        </ul>
                        <div class="clear"></div>
                    </div><!--tab-content -->
                 <?php } ?>
            </div>
        </div>
    </div>
</div>
    </div>
</div>