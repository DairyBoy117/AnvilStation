<?php
$el_blog_number_posts = $el_blog_categories =  $el_blog_title = $el_class = '';
$posts = array();
extract( shortcode_atts( array(
    'el_blog_title' => '',
    'el_blog_number_posts' => '',
    'el_class' => '',
    'el_blog_categories' => ''
), $atts ) );
if(empty($css)) $css = '';
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_text_column wpb_content_element ' . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
?>

<div class="<?php echo esc_attr($css_class); if(!empty($el_class)) echo esc_attr($el_class); ?>">
    <div class="wpb_wrapper">
        <div class="title-wrapper">
            <h3 class="widget-title"><i class="fa fa-newspaper-o"></i> <?php if(!empty($el_blog_title)) echo esc_attr($el_blog_title); ?></h3>
            <div class="clear"></div>
        </div>

           <?php

                    $ct = array();
                    if ( $el_blog_categories != '' ) {
                        $el_blog_categories = explode( ",", $el_blog_categories );
                        foreach ( $el_blog_categories as $category ) {
                            array_push( $ct, $category );
                        }
                    }

        $posts = new WP_Query(array(
                        'showposts' => $el_blog_number_posts,
                        'category__in' => $ct
                    ));

       ?>
        <?php if ( $posts->have_posts() ) : while ( $posts->have_posts() ) : $posts->the_post(); ?>
			<?php require(get_template_directory() .'/blog-roll.php'); ?>
        <?php endwhile; endif; wp_reset_postdata(); ?>
        <div class="clear"></div>

    </div><!--wpb_wrapper -->
</div>