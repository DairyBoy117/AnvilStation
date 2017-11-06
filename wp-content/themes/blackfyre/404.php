<?php get_header(); ?>
    <div class="<?php if ( of_get_option('fullwidth') ) {  }else{ ?>container<?php } ?> normal-page">   	<?php if ( of_get_option('fullwidth') ) { ?> <div class="container"> <?php } ?>        <div class="row">
            <div class="span12">
               <div class="four0four">
                    <p class="huge"><i class="fa fa-exclamation-triangle"></i> OOPS! 404</p>
                    <?php esc_html_e("Page not found, sorry", 'blackfyre') ?> :(
               </div>
            </div>
       </div>		<?php if ( of_get_option('fullwidth') ) { ?> </div> <?php } ?> <!-- /container -->    </div> <!-- /container -->
<?php get_footer(); ?>