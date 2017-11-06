<div class="blog-rating">
<?php
$categories = wp_get_post_categories(get_the_ID());
if(!isset($categories[0]))$categories[0]='';
$cat_data = get_option("category_$categories[0]");

$overall_rating = get_post_meta(get_the_ID(), 'overall_rating', true);

if(!empty($overall_rating)){ ?>
	<div class="overall-score">
<?php }

if($overall_rating != "0" && $overall_rating=="0.5"){
?>
	<div class="rating">
		<i class="fa fa-star-half-o"></i>
		<i class="fa fa-star-o"></i>
		<i class="fa fa-star-o"></i>
		<i class="fa fa-star-o"></i>
		<i class="fa fa-star-o"></i>
	</div>
	<?php } ?>

	<?php
if($overall_rating != "0" && $overall_rating == "1"){
	?>
	<div class="rating">
		<i class="fa fa-star"></i>
		<i class="fa fa-star-o"></i>
		<i class="fa fa-star-o"></i>
		<i class="fa fa-star-o"></i>
		<i class="fa fa-star-o"></i>
	</div>
	<?php } ?>

	<?php
if($overall_rating != "0" && $overall_rating == "1.5"){
	?>
	<div class="rating">
	<i class="fa fa-star"></i>
	<i class="fa fa-star-half-o"></i>
	<i class="fa fa-star-o"></i>
	<i class="fa fa-star-o"></i>
	<i class="fa fa-star-o"></i>
	</div>
	<?php } ?>

	<?php
if($overall_rating != "0" && $overall_rating == "2"){
	?>
	<div class="rating">
		<i class="fa fa-star"></i>
		<i class="fa fa-star"></i>
		<i class="fa fa-star-o"></i>
		<i class="fa fa-star-o"></i>
		<i class="fa fa-star-o"></i>
	</div>
	<?php } ?>

	<?php
if($overall_rating != "0" && $overall_rating == "2.5"){
	?>
	<div class="rating">
		<i class="fa fa-star"></i>
		<i class="fa fa-star"></i>
		<i class="fa fa-star-half-o"></i>
		<i class="fa fa-star-o"></i>
		<i class="fa fa-star-o"></i>
	</div>
	<?php } ?>

	<?php
if($overall_rating != "0" && $overall_rating == "3"){
	?>
	<div class="rating">
		<i class="fa fa-star"></i>
		<i class="fa fa-star"></i>
		<i class="fa fa-star"></i>
		<i class="fa fa-star-o"></i>
		<i class="fa fa-star-o"></i>
	</div>
	<?php } ?>

	<?php
if($overall_rating != "0" && $overall_rating == "3.5"){
	?>
	<div class="rating">
		<i class="fa fa-star"></i>
		<i class="fa fa-star"></i>
		<i class="fa fa-star"></i>
		<i class="fa fa-star-half-o"></i>
		<i class="fa fa-star-o"></i>
	</div>
	<?php } ?>

	<?php
if($overall_rating != "0" && $overall_rating == "4"){
	?>
	<div class="rating">
		<i class="fa fa-star"></i>
		<i class="fa fa-star"></i>
		<i class="fa fa-star"></i>
		<i class="fa fa-star"></i>
		<i class="fa fa-star-o"></i>
	</div>
	<?php } ?>

	<?php
if($overall_rating != "0" && $overall_rating == "4.5"){
	?>
	<div class="rating">
		<i class="fa fa-star"></i>
		<i class="fa fa-star"></i>
		<i class="fa fa-star"></i>
		<i class="fa fa-star"></i>
		<i class="fa fa-star-half-o"></i>

	</div>
	<?php } ?>

	<?php
if($overall_rating != "0" && $overall_rating == "5"){
	?>
	<div class="rating">
		<i class="fa fa-star"></i>
		<i class="fa fa-star"></i>
		<i class="fa fa-star"></i>
		<i class="fa fa-star"></i>
		<i class="fa fa-star"></i>
	</div>
	<?php }
if(!empty($overall_rating)){ ?>
	</div><!-- blog-rating -->
<?php } ?>
</div>