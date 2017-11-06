<?php
// overall stars
$overall_rating = get_post_meta($post->ID, 'overall_rating', true);
$categories = wp_get_post_categories(get_the_ID());
$cat_data = get_option("category_$categories[0]");


if($overall_rating != "0" && $overall_rating == "0.5"){ ?>
<div class="post-review post-review-numbers">
<div class="overall-score" >
	<b style="color: <?php echo esc_attr($cat_data["catBG"]); ?>"><i class="fa fa-trophy"></i> 0.5</b>/5
</div>
<?php } ?>

<?php
if($overall_rating != "0" && $overall_rating == "1"){ ?>
<div class="post-review post-review-numbers">
<div class="overall-score" >
	<b style="color: <?php echo esc_attr($cat_data["catBG"]); ?>"><i class="fa fa-trophy"></i> 1</b>/5
</div>
<?php } ?>

<?php
if($overall_rating != "0" && $overall_rating == "1.5"){ ?>
<div class="post-review post-review-numbers">
<div class="overall-score" >
	<b style="color: <?php echo esc_attr($cat_data["catBG"]); ?>"><i class="fa fa-trophy"></i> 1.5</b>/5
</div>
<?php } ?>

<?php
if($overall_rating != "0" && $overall_rating == "2"){ ?>
<div class="post-review post-review-numbers">
<div class="overall-score" >
	<b style="color: <?php echo esc_attr($cat_data["catBG"]); ?>"><i class="fa fa-trophy"></i> 2</b>/5
</div>
<?php } ?>

<?php
if($overall_rating != "0" && $overall_rating == "2.5"){ ?>
<div class="post-review post-review-numbers">
<div class="overall-score" >
	<b style="color: <?php echo esc_attr($cat_data["catBG"]); ?>"><i class="fa fa-trophy"></i> 2.5</b>/5
</div>
<?php } ?>

<?php
if($overall_rating != "0" && $overall_rating == "3"){ ?>
<div class="post-review post-review-numbers">
<div class="overall-score" >
	<b style="color: <?php echo esc_attr($cat_data["catBG"]); ?>"><i class="fa fa-trophy"></i> 3</b>/5
</div>
<?php } ?>

<?php
if($overall_rating != "0" && $overall_rating == "3.5"){ ?>
<div class="post-review post-review-numbers">
<div class="overall-score" >
	<b style="color: <?php echo esc_attr($cat_data["catBG"]); ?>"><i class="fa fa-trophy"></i> 3.5</b>/5
</div>
<?php } ?>

<?php
if($overall_rating != "0" && $overall_rating == "4"){ ?>
<div class="post-review post-review-numbers">
<div class="overall-score" >
	<b style="color: <?php echo esc_attr($cat_data["catBG"]); ?>"><i class="fa fa-trophy"></i> 4</b>/5
</div>
<?php } ?>

<?php
if($overall_rating != "0" && $overall_rating == "4.5"){ ?>
<div class="post-review post-review-numbers">
<div class="overall-score" >
	<b style="color: <?php echo esc_attr($cat_data["catBG"]); ?>"><i class="fa fa-trophy"></i> 4.5</b>/5
</div>
<?php } ?>

<?php
if($overall_rating != "0" && $overall_rating == "5"){ ?>
<div class="post-review post-review-numbers">
<div class="overall-score" >
	<b style="color: <?php echo esc_attr($cat_data["catBG"]); ?>"><i class="fa fa-trophy"></i> 5</b>/5
</div>

<?php } ?>

<?php if(  get_post_meta($post->ID, 'creteria_1_text', true) != '' or get_post_meta($post->ID, 'creteria_2_text', true) != '' or get_post_meta($post->ID, 'creteria_3_text', true) != '' or get_post_meta($post->ID, 'creteria_4_text', true) != '' or get_post_meta($post->ID, 'creteria_5_text', true) != '' ){ ?>

<ul>

<?php
$rating_1 = get_post_meta($post->ID, 'creteria_1', true);
$rating_1_text = get_post_meta($post->ID, 'creteria_1_text', true);


if($rating_1 != "0" && $rating_1 == "0.5" && $rating_1_text != "" ){
?>
<li><?php echo  esc_attr($rating_1_text); ?>
	<div class="progress">
	  <div class="progress-bar" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 10%; background: <?php echo esc_attr($cat_data["catBG"]); ?>" >
	    0.5/5
	  </div>
	</div>
</li>
<?php } ?>


<?php
if($rating_1 != "0" && $rating_1 == "1" && $rating_1_text != "" ){
?>
<li><?php echo  esc_attr($rating_1_text); ?>
	<div class="progress">
	  <div class="progress-bar" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%; background: <?php echo esc_attr($cat_data["catBG"]); ?>" >
	    1/5
	  </div>
	</div>
</li>
<?php } ?>

<?php
if($rating_1 != "0" && $rating_1 == "1.5" && $rating_1_text != "" ){
?>
<li><?php echo  esc_attr($rating_1_text); ?>
	<div class="progress">
	  <div class="progress-bar" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width: 30%; background: <?php echo esc_attr($cat_data["catBG"]); ?>" >
	    1.5/5
	  </div>
	</div>
</li>
<?php } ?>

<?php
if($rating_1 != "0" && $rating_1 == "2" && $rating_1_text != "" ){
?>
<li><?php echo  esc_attr($rating_1_text); ?>
	<div class="progress">
	  <div class="progress-bar" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%; background: <?php echo esc_attr($cat_data["catBG"]); ?>" >
	    2/5
	  </div>
	</div>
</li>
<?php } ?>

<?php
if($rating_1 != "0" && $rating_1 == "2.5" && $rating_1_text != "" ){
?>
<li><?php echo  esc_attr($rating_1_text); ?>
	<div class="progress">
	  <div class="progress-bar" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%; background: <?php echo esc_attr($cat_data["catBG"]); ?>" >
	    2.5/5
	  </div>
	</div>
</li>
<?php } ?>

<?php
if($rating_1 != "0" && $rating_1 == "3" && $rating_1_text != "" ){
?>
<li><?php echo  esc_attr($rating_1_text); ?>
	<div class="progress">
	  <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%; background: <?php echo esc_attr($cat_data["catBG"]); ?>" >
	    3/5
	  </div>
	</div>
</li>
<?php } ?>


<?php
if($rating_1 != "0" && $rating_1 == "3.5" && $rating_1_text != "" ){
?>
<li><?php echo  esc_attr($rating_1_text); ?>
	<div class="progress">
	  <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width: 70%; background: <?php echo esc_attr($cat_data["catBG"]); ?>" >
	    3.5/5
	  </div>
	</div>
</li>
<?php } ?>

<?php
if($rating_1 != "0" && $rating_1 == "4" && $rating_1_text != "" ){
?>
<li><?php echo  esc_attr($rating_1_text); ?>
	<div class="progress">
	  <div class="progress-bar" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%; background: <?php echo esc_attr($cat_data["catBG"]); ?>" >
	    4/5
	  </div>
	</div>
</li>
<?php } ?>

<?php
if($rating_1 != "0" && $rating_1 == "4.5" && $rating_1_text != "" ){
?>
<li><?php echo  esc_attr($rating_1_text); ?>
	<div class="progress">
	  <div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width: 90%; background: <?php echo esc_attr($cat_data["catBG"]); ?>" >
	    4.5/5
	  </div>
	</div>
</li>
<?php } ?>

<?php
if($rating_1 != "0" && $rating_1 == "5" && $rating_1_text != "" ){
?>
<li><?php echo  esc_attr($rating_1_text); ?>
	<div class="progress">
	  <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%; background: <?php echo esc_attr($cat_data["catBG"]); ?>" >
	    5/5
	  </div>
	</div>
</li>
<?php }


// creteria two  start
?>

<?php
$rating_2 = get_post_meta($post->ID, 'creteria_2', true);
$rating_2_text = get_post_meta($post->ID, 'creteria_2_text', true);


if($rating_2 != "0" && $rating_2 == "0.5" && $rating_2_text != "" ){
?>
<li><?php echo  esc_attr($rating_2_text); ?>
	<div class="progress">
	  <div class="progress-bar" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 10%; background: <?php echo esc_attr($cat_data["catBG"]); ?>" >
	    0.5/5
	  </div>
	</div>
</li>
<?php } ?>


<?php
if($rating_2 != "0" && $rating_2 == "1" && $rating_2_text != "" ){
?>
<li><?php echo  esc_attr($rating_2_text); ?>
	<div class="progress">
	  <div class="progress-bar" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%; background: <?php echo esc_attr($cat_data["catBG"]); ?>" >
	    1/5
	  </div>
	</div>
</li>
<?php } ?>

<?php
if($rating_2 != "0" && $rating_2 == "1.5" && $rating_2_text != "" ){
?>
<li><?php echo  esc_attr($rating_2_text); ?>
	<div class="progress">
	  <div class="progress-bar" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width: 30%; background: <?php echo esc_attr($cat_data["catBG"]); ?>" >
	    1.5/5
	  </div>
	</div>
</li>
<?php } ?>

<?php
if($rating_2 != "0" && $rating_2 == "2" && $rating_2_text != "" ){
?>
<li><?php echo  esc_attr($rating_2_text); ?>
	<div class="progress">
	  <div class="progress-bar" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%; background: <?php echo esc_attr($cat_data["catBG"]); ?>" >
	    2/5
	  </div>
	</div>
</li>
<?php } ?>

<?php
if($rating_2 != "0" && $rating_2 == "2.5" && $rating_2_text != "" ){
?>
<li><?php echo  esc_attr($rating_2_text); ?>
	<div class="progress">
	  <div class="progress-bar" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%; background: <?php echo esc_attr($cat_data["catBG"]); ?>" >
	    2.5/5
	  </div>
	</div>
</li>
<?php } ?>

<?php
if($rating_2 != "0" && $rating_2 == "3" && $rating_2_text != "" ){
?>
<li><?php echo  esc_attr($rating_2_text); ?>
	<div class="progress">
	  <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%; background: <?php echo esc_attr($cat_data["catBG"]); ?>" >
	    3/5
	  </div>
	</div>
</li>
<?php } ?>


<?php
if($rating_2 != "0" && $rating_2 == "3.5" && $rating_2_text != "" ){
?>
<li><?php echo  esc_attr($rating_2_text); ?>
	<div class="progress">
	  <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width: 70%; background: <?php echo esc_attr($cat_data["catBG"]); ?>" >
	    3.5/5
	  </div>
	</div>
</li>
<?php } ?>

<?php
if($rating_2 != "0" && $rating_2 == "4" && $rating_2_text != "" ){
?>
<li><?php echo  esc_attr($rating_2_text); ?>
	<div class="progress">
	  <div class="progress-bar" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%; background: <?php echo esc_attr($cat_data["catBG"]); ?>" >
	    4/5
	  </div>
	</div>
</li>
<?php } ?>

<?php
if($rating_2 != "0" && $rating_2 == "4.5" && $rating_2_text != "" ){
?>
<li><?php echo  esc_attr($rating_2_text); ?>
	<div class="progress">
	  <div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width: 90%; background: <?php echo esc_attr($cat_data["catBG"]); ?>" >
	    4.5/5
	  </div>
	</div>
</li>
<?php } ?>

<?php
if($rating_2 != "0" && $rating_2 == "5" && $rating_2_text != "" ){
?>
<li><?php echo  esc_attr($rating_2_text); ?>
	<div class="progress">
	  <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%; background: <?php echo esc_attr($cat_data["catBG"]); ?>" >
	    5/5
	  </div>
	</div>
</li>
<?php }

// creteria three start

?>

<?php
$rating_3 = get_post_meta($post->ID, 'creteria_3', true);
$rating_3_text = get_post_meta($post->ID, 'creteria_3_text', true);


if($rating_3 != "0" && $rating_3 == "0.5" && $rating_3_text != "" ){
?>
<li><?php echo  esc_attr($rating_3_text); ?>
	<div class="progress">
	  <div class="progress-bar" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 10%; background: <?php echo esc_attr($cat_data["catBG"]); ?>" >
	    0.5/5
	  </div>
	</div>
</li>
<?php } ?>


<?php
if($rating_3 != "0" && $rating_3 == "1" && $rating_3_text != "" ){
?>
<li><?php echo  esc_attr($rating_3_text); ?>
	<div class="progress">
	  <div class="progress-bar" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%; background: <?php echo esc_attr($cat_data["catBG"]); ?>" >
	    1/5
	  </div>
	</div>
</li>
<?php } ?>

<?php
if($rating_3 != "0" && $rating_3 == "1.5" && $rating_3_text != "" ){
?>
<li><?php echo  esc_attr($rating_3_text); ?>
	<div class="progress">
	  <div class="progress-bar" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width: 30%; background: <?php echo esc_attr($cat_data["catBG"]); ?>" >
	    1.5/5
	  </div>
	</div>
</li>
<?php } ?>

<?php
if($rating_3 != "0" && $rating_3 == "2" && $rating_3_text != "" ){
?>
<li><?php echo  esc_attr($rating_3_text); ?>
	<div class="progress">
	  <div class="progress-bar" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%; background: <?php echo esc_attr($cat_data["catBG"]); ?>" >
	    2/5
	  </div>
	</div>
</li>
<?php } ?>

<?php
if($rating_3 != "0" && $rating_3 == "2.5" && $rating_3_text != "" ){
?>
<li><?php echo  esc_attr($rating_3_text); ?>
	<div class="progress">
	  <div class="progress-bar" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%; background: <?php echo esc_attr($cat_data["catBG"]); ?>" >
	    2.5/5
	  </div>
	</div>
</li>
<?php } ?>

<?php
if($rating_3 != "0" && $rating_3 == "3" && $rating_3_text != "" ){
?>
<li><?php echo  esc_attr($rating_3_text); ?>
	<div class="progress">
	  <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%; background: <?php echo esc_attr($cat_data["catBG"]); ?>" >
	    3/5
	  </div>
	</div>
</li>
<?php } ?>


<?php
if($rating_3 != "0" && $rating_3 == "3.5" && $rating_3_text != "" ){
?>
<li><?php echo  esc_attr($rating_3_text); ?>
	<div class="progress">
	  <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width: 70%; background: <?php echo esc_attr($cat_data["catBG"]); ?>" >
	    3.5/5
	  </div>
	</div>
</li>
<?php } ?>

<?php
if($rating_3 != "0" && $rating_3 == "4" && $rating_3_text != "" ){
?>
<li><?php echo  esc_attr($rating_3_text); ?>
	<div class="progress">
	  <div class="progress-bar" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%; background: <?php echo esc_attr($cat_data["catBG"]); ?>" >
	    4/5
	  </div>
	</div>
</li>
<?php } ?>

<?php
if($rating_3 != "0" && $rating_3 == "4.5" && $rating_3_text != "" ){
?>
<li><?php echo  esc_attr($rating_3_text); ?>
	<div class="progress">
	  <div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width: 90%; background: <?php echo esc_attr($cat_data["catBG"]); ?>" >
	    4.5/5
	  </div>
	</div>
</li>
<?php } ?>

<?php
if($rating_3 != "0" && $rating_3 == "5" && $rating_3_text != "" ){
?>
<li><?php echo  esc_attr($rating_3_text); ?>
	<div class="progress">
	  <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%; background: <?php echo esc_attr($cat_data["catBG"]); ?>" >
	    5/5
	  </div>
	</div>
</li>
<?php }


// creteria four start

?>

<?php
$rating_4 = get_post_meta($post->ID, 'creteria_4', true);
$rating_4_text = get_post_meta($post->ID, 'creteria_4_text', true);


if($rating_4 != "0" && $rating_4 == "0.5" && $rating_4_text != "" ){
?>
<li><?php echo  esc_attr($rating_4_text); ?>
	<div class="progress">
	  <div class="progress-bar" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 10%; background: <?php echo esc_attr($cat_data["catBG"]); ?>" >
	    0.5/5
	  </div>
	</div>
</li>
<?php } ?>


<?php
if($rating_4 != "0" && $rating_4 == "1" && $rating_4_text != "" ){
?>
<li><?php echo  esc_attr($rating_4_text); ?>
	<div class="progress">
	  <div class="progress-bar" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%; background: <?php echo esc_attr($cat_data["catBG"]); ?>" >
	    1/5
	  </div>
	</div>
</li>
<?php } ?>

<?php
if($rating_4 != "0" && $rating_4 == "1.5" && $rating_4_text != "" ){
?>
<li><?php echo  esc_attr($rating_4_text); ?>
	<div class="progress">
	  <div class="progress-bar" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width: 30%; background: <?php echo esc_attr($cat_data["catBG"]); ?>" >
	    1.5/5
	  </div>
	</div>
</li>
<?php } ?>

<?php
if($rating_4 != "0" && $rating_4 == "2" && $rating_4_text != "" ){
?>
<li><?php echo  esc_attr($rating_4_text); ?>
	<div class="progress">
	  <div class="progress-bar" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%; background: <?php echo esc_attr($cat_data["catBG"]); ?>" >
	    2/5
	  </div>
	</div>
</li>
<?php } ?>

<?php
if($rating_4 != "0" && $rating_4 == "2.5" && $rating_4_text != "" ){
?>
<li><?php echo  esc_attr($rating_4_text); ?>
	<div class="progress">
	  <div class="progress-bar" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%; background: <?php echo esc_attr($cat_data["catBG"]); ?>" >
	    2.5/5
	  </div>
	</div>
</li>
<?php } ?>

<?php
if($rating_4 != "0" && $rating_4 == "3" && $rating_4_text != "" ){
?>
<li><?php echo  esc_attr($rating_4_text); ?>
	<div class="progress">
	  <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%; background: <?php echo esc_attr($cat_data["catBG"]); ?>" >
	    3/5
	  </div>
	</div>
</li>
<?php } ?>


<?php
if($rating_4 != "0" && $rating_4 == "3.5" && $rating_4_text != "" ){
?>
<li><?php echo  esc_attr($rating_4_text); ?>
	<div class="progress">
	  <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width: 70%; background: <?php echo esc_attr($cat_data["catBG"]); ?>" >
	    3.5/5
	  </div>
	</div>
</li>
<?php } ?>

<?php
if($rating_4 != "0" && $rating_4 == "4" && $rating_4_text != "" ){
?>
<li><?php echo  esc_attr($rating_4_text); ?>
	<div class="progress">
	  <div class="progress-bar" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%; background: <?php echo esc_attr($cat_data["catBG"]); ?>" >
	    4/5
	  </div>
	</div>
</li>
<?php } ?>

<?php
if($rating_4 != "0" && $rating_4 == "4.5" && $rating_4_text != "" ){
?>
<li><?php echo  esc_attr($rating_4_text); ?>
	<div class="progress">
	  <div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width: 90%; background: <?php echo esc_attr($cat_data["catBG"]); ?>" >
	    4.5/5
	  </div>
	</div>
</li>
<?php } ?>

<?php
if($rating_4 != "0" && $rating_4 == "5" && $rating_4_text != "" ){
?>
<li><?php echo  esc_attr($rating_4_text); ?>
	<div class="progress">
	  <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%; background: <?php echo esc_attr($cat_data["catBG"]); ?>" >
	    5/5
	  </div>
	</div>
</li>
<?php }
// creteria Five start

?>

<?php
$rating_5 = get_post_meta($post->ID, 'creteria_5', true);
$rating_5_text = get_post_meta($post->ID, 'creteria_5_text', true);


if($rating_5 != "0" && $rating_5 == "0.5" && $rating_5_text != "" ){
?>
<li><?php echo  esc_attr($rating_5_text); ?>
	<div class="progress">
	  <div class="progress-bar" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 10%; background: <?php echo esc_attr($cat_data["catBG"]); ?>" >
	    0.5/5
	  </div>
	</div>
</li>
<?php } ?>


<?php
if($rating_5 != "0" && $rating_5 == "1" && $rating_5_text != "" ){
?>
<li><?php echo  esc_attr($rating_5_text); ?>
	<div class="progress">
	  <div class="progress-bar" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%; background: <?php echo esc_attr($cat_data["catBG"]); ?>" >
	    1/5
	  </div>
	</div>
</li>
<?php } ?>

<?php
if($rating_5 != "0" && $rating_5 == "1.5" && $rating_5_text != "" ){
?>
<li><?php echo  esc_attr($rating_5_text); ?>
	<div class="progress">
	  <div class="progress-bar" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width: 30%; background: <?php echo esc_attr($cat_data["catBG"]); ?>" >
	    1.5/5
	  </div>
	</div>
</li>
<?php } ?>

<?php
if($rating_5 != "0" && $rating_5 == "2" && $rating_5_text != "" ){
?>
<li><?php echo  esc_attr($rating_5_text); ?>
	<div class="progress">
	  <div class="progress-bar" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%; background: <?php echo esc_attr($cat_data["catBG"]); ?>" >
	    2/5
	  </div>
	</div>
</li>
<?php } ?>

<?php
if($rating_5 != "0" && $rating_5 == "2.5" && $rating_5_text != "" ){
?>
<li><?php echo  esc_attr($rating_5_text); ?>
	<div class="progress">
	  <div class="progress-bar" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%; background: <?php echo esc_attr($cat_data["catBG"]); ?>" >
	    2.5/5
	  </div>
	</div>
</li>
<?php } ?>

<?php
if($rating_5 != "0" && $rating_5 == "3" && $rating_5_text != "" ){
?>
<li><?php echo  esc_attr($rating_5_text); ?>
	<div class="progress">
	  <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%; background: <?php echo esc_attr($cat_data["catBG"]); ?>" >
	    3/5
	  </div>
	</div>
</li>
<?php } ?>


<?php
if($rating_5 != "0" && $rating_5 == "3.5" && $rating_5_text != "" ){
?>
<li><?php echo  esc_attr($rating_5_text); ?>
	<div class="progress">
	  <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width: 70%; background: <?php echo esc_attr($cat_data["catBG"]); ?>" >
	    3.5/5
	  </div>
	</div>
</li>
<?php } ?>

<?php
if($rating_5 != "0" && $rating_5 == "4" && $rating_5_text != "" ){
?>
<li><?php echo  esc_attr($rating_5_text); ?>
	<div class="progress">
	  <div class="progress-bar" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%; background: <?php echo esc_attr($cat_data["catBG"]); ?>" >
	    4/5
	  </div>
	</div>
</li>
<?php } ?>

<?php
if($rating_5 != "0" && $rating_5 == "4.5" && $rating_5_text != "" ){
?>
<li><?php echo  esc_attr($rating_5_text); ?>
	<div class="progress">
	  <div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width: 90%; background: <?php echo esc_attr($cat_data["catBG"]); ?>" >
	    4.5/5
	  </div>
	</div>
</li>
<?php } ?>

<?php
if($rating_5 != "0" && $rating_5 == "5" && $rating_5_text != "" ){
?>
<li><?php echo  esc_attr($rating_5_text); ?>
	<div class="progress">
	  <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%; background: <?php echo esc_attr($cat_data["catBG"]); ?>" >
	    5/5
	  </div>
	</div>
</li>
<?php }
?>

</ul>

<?php } ?>
<?php if($overall_rating != "0"){ ?>
</div>
<?php } ?>