
<?php
$categories = wp_get_post_categories(get_the_ID());
if(!isset($categories[0]))$categories[0]='';
$cat_data = get_option("category_$categories[0]");

$overall_rating = get_post_meta(get_the_ID(), 'overall_rating', true);

if(!empty($overall_rating)){ ?>
	<div class="carousel_rating carousel_rating_number">
<?php }

if($overall_rating != "0" && $overall_rating=="0.5"){
?>

		<b style="text-shadow: 0px 0px 10px <?php echo esc_attr($cat_data["catBG"]); ?>"><i class="fa fa-trophy"></i> 0.5</b>/5

	<?php } ?>

	<?php
if($overall_rating != "0" && $overall_rating == "1"){
	?>

		<b style="text-shadow: 0px 0px 10px <?php echo esc_attr($cat_data["catBG"]); ?>"><i class="fa fa-trophy"></i> 1</b>/5

	<?php } ?>

	<?php
if($overall_rating != "0" && $overall_rating == "1.5"){
	?>

		<b style="text-shadow: 0px 0px 10px <?php echo esc_attr($cat_data["catBG"]); ?>"><i class="fa fa-trophy"></i> 1.5</b>/5

	<?php } ?>

	<?php
if($overall_rating != "0" && $overall_rating == "2"){
	?>

		<b style="text-shadow: 0px 0px 10px <?php echo esc_attr($cat_data["catBG"]); ?>"><i class="fa fa-trophy"></i> 2</b>/5

	<?php } ?>

	<?php
if($overall_rating != "0" && $overall_rating == "2.5"){
	?>

		<b style="text-shadow: 0px 0px 10px <?php echo esc_attr($cat_data["catBG"]); ?>"><i class="fa fa-trophy"></i> 2.5</b>/5

	<?php } ?>

	<?php
if($overall_rating != "0" && $overall_rating == "3"){
	?>

		<b style="text-shadow: 0px 0px 10px <?php echo esc_attr($cat_data["catBG"]); ?>"><i class="fa fa-trophy"></i> 3</b>/5

	<?php } ?>

	<?php
if($overall_rating != "0" && $overall_rating == "3.5"){
	?>

		<b style="text-shadow: 0px 0px 10px <?php echo esc_attr($cat_data["catBG"]); ?>"><i class="fa fa-trophy"></i> 3.5</b>/5

	<?php } ?>

	<?php
if($overall_rating != "0" && $overall_rating == "4"){
	?>

		<b style="text-shadow: 0px 0px 10px <?php echo esc_attr($cat_data["catBG"]); ?>"><i class="fa fa-trophy"></i> 4</b>/5

	<?php } ?>

	<?php
if($overall_rating != "0" && $overall_rating == "4.5"){
	?>

		<b style="text-shadow: 0px 0px 10px <?php echo esc_attr($cat_data["catBG"]); ?>"><i class="fa fa-trophy"></i> 4.5</b>/5

	<?php } ?>

	<?php
if($overall_rating != "0" && $overall_rating == "5"){
	?>

		<b style="text-shadow: 0px 0px 10px <?php echo esc_attr($cat_data["catBG"]); ?>"><i class="fa fa-trophy"></i> 5</b>/5

	<?php }
if(!empty($overall_rating)){ ?>
	</div><!-- blog-rating -->
<?php } ?>
