<?php /* Template Name: Temporary Landing Page */ ?>

<?php get_header();?>
<!-- Page content
    ================================================== -->
<!-- Wrap the rest of the page in another container to center all the content. -->
<div class="<?php if ( of_get_option('fullwidth') ) {  }else{ ?>container boxed<?php } ?> blog normal-page container-wrap">
	<?php if ( of_get_option('fullwidth') ) { ?> <div class="container"> <?php } ?>

  <h2></h2>

  <div class="row">

    <div class="col-lg-12">

        
        
	</div>

  </div>
  <!-- /.row -->
 <?php if ( of_get_option('fullwidth') ) { ?> </div> <?php } ?> <!-- /container -->
</div>
<!-- /.container -->
<?php get_footer(); ?>