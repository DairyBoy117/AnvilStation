<?php get_header(); ?>
    <div class="<?php if ( of_get_option('fullwidth') ) {  }else{ ?>container<?php } ?> normal-page">
            <div class="span12">
               <div class="four0four">
                    <p class="huge"><i class="fa fa-exclamation-triangle"></i> OOPS! 404</p>
                    <?php esc_html_e("Page not found, sorry", 'blackfyre') ?> :(
               </div>
            </div>
       </div>
<?php get_footer(); ?>