

	<?php
// overall stars
$overall_rating_1 = get_post_meta($post->ID, 'overall_rating', true);
if($overall_rating_1!="0" && $overall_rating_1=="0.5"){ ?>
<div class="post-review">
<div class="overall-score"><div class="rating r-05"></div></div>
<?php } ?>

<?php $overall_rating_2 = get_post_meta($post->ID, 'overall_rating', true);
if($overall_rating_2!="0" && $overall_rating_2=="1"){ ?>
<div class="post-review">
<div class="overall-score"><div class="rating r-1"></div></div>
<?php } ?>

<?php $overall_rating_3 = get_post_meta($post->ID, 'overall_rating', true);
if($overall_rating_3!="0" && $overall_rating_3=="1.5"){ ?>
<div class="post-review">
<div class="overall-score"><div class="rating r-15"></div></div>
<?php } ?>

<?php $overall_rating_4 = get_post_meta($post->ID, 'overall_rating', true);
if($overall_rating_4!="0" && $overall_rating_4=="2"){ ?>
<div class="post-review">
<div class="overall-score"><div class="rating r-2"></div></div>
<?php } ?>

<?php $overall_rating_5 = get_post_meta($post->ID, 'overall_rating', true);
if($overall_rating_5!="0" && $overall_rating_5=="2.5"){ ?>
<div class="post-review">
<div class="overall-score"><div class="rating r-25"></div></div>
<?php } ?>

<?php $overall_rating_6 = get_post_meta($post->ID, 'overall_rating', true);
if($overall_rating_6!="0" && $overall_rating_6=="3"){ ?>
<div class="post-review">
<div class="overall-score"><div class="rating r-3"></div></div>
<?php } ?>

<?php $overall_rating_7 = get_post_meta($post->ID, 'overall_rating', true);
if($overall_rating_7!="0" && $overall_rating_7=="3.5"){ ?>
<div class="post-review">
<div class="overall-score"><div class="rating r-35"></div></div>
<?php } ?>

<?php $overall_rating_8 = get_post_meta($post->ID, 'overall_rating', true);
if($overall_rating_8!="0" && $overall_rating_8=="4"){ ?>
<div class="post-review">
<div class="overall-score"><div class="rating r-4"></div></div>
<?php } ?>

<?php $overall_rating_9 = get_post_meta($post->ID, 'overall_rating', true);
if($overall_rating_9!="0" && $overall_rating_9=="4.5"){ ?>
<div class="post-review">
<div class="overall-score"><div class="rating r-45"></div></div>
<?php } ?>

<?php $overall_rating_10 = get_post_meta($post->ID, 'overall_rating', true);
if($overall_rating_10!="0" && $overall_rating_10=="5"){ ?>
<div class="post-review">
<div class="overall-score"><div class="rating r-5"></div></div>

<?php } ?>

<?php if(  get_post_meta($post->ID, 'creteria_1_text', true) != '' or get_post_meta($post->ID, 'creteria_2_text', true) != '' or get_post_meta($post->ID, 'creteria_3_text', true) != '' or get_post_meta($post->ID, 'creteria_4_text', true) != '' or get_post_meta($post->ID, 'creteria_5_text', true) != '' ){ ?>

<ul>

<?php
$rating_1 = get_post_meta($post->ID, 'creteria_1', true);
$rating_1_text = get_post_meta($post->ID, 'creteria_1_text', true);
if($rating_1!="0" && $rating_1=="0.5" && $rating_1_text!="" ){
?>
<li><?php echo  esc_attr(get_post_meta($post->ID, 'creteria_1_text', true)); ?> <span class="score"><div class="rating r-05"></div></span></li>
<?php } ?>


<?php $rating_2 = get_post_meta($post->ID, 'creteria_1', true);
$rating_2_text = get_post_meta($post->ID, 'creteria_1_text', true);
if($rating_2!="0" && $rating_2=="1" && $rating_2_text!="" ){
?>
<li><?php echo  esc_attr(get_post_meta($post->ID, 'creteria_1_text', true)); ?> <span class="score"><div class="rating r-1"></div></span></li>
<?php } ?>

<?php $rating_3 = get_post_meta($post->ID, 'creteria_1', true);
$rating_3_text = get_post_meta($post->ID, 'creteria_1_text', true);
if($rating_3!="0" && $rating_3=="1.5" && $rating_3_text!="" ){
?>
<li><?php echo  esc_attr(get_post_meta($post->ID, 'creteria_1_text', true)); ?> <span class="score"><div class="rating r-15"></div></span></li>
<?php } ?>

<?php $rating_4 = get_post_meta($post->ID, 'creteria_1', true);
$rating_4_text = get_post_meta($post->ID, 'creteria_1_text', true);
if($rating_4!="0" && $rating_4=="2" && $rating_4_text!="" ){
?>
<li><?php echo  esc_attr(get_post_meta($post->ID, 'creteria_1_text', true)); ?> <span class="score"><div class="rating r-2"></div></span></li>
<?php } ?>

<?php $rating_5 = get_post_meta($post->ID, 'creteria_1', true);
$rating_5_text = get_post_meta($post->ID, 'creteria_1_text', true);
if($rating_5!="0" && $rating_5=="2.5" && $rating_5_text!="" ){
?>
<li><?php echo  esc_attr(get_post_meta($post->ID, 'creteria_1_text', true)); ?> <span class="score"><div class="rating r-25"></div></span></li>
<?php } ?>

<?php $rating_6 = get_post_meta($post->ID, 'creteria_1', true);
$rating_6_text = get_post_meta($post->ID, 'creteria_1_text', true);
if($rating_6!="0" && $rating_6=="3" && $rating_6_text!="" ){
?>
<li><?php echo  esc_attr(get_post_meta($post->ID, 'creteria_1_text', true)); ?> <span class="score"><div class="rating r-3"></div></span></li>
<?php } ?>


<?php $rating_7 = get_post_meta($post->ID, 'creteria_1', true);
$rating_7_text = get_post_meta($post->ID, 'creteria_1_text', true);
if($rating_7!="0" && $rating_7=="3.5" && $rating_7_text!="" ){
?>
<li><?php echo  esc_attr(get_post_meta($post->ID, 'creteria_1_text', true)); ?> <span class="score"><div class="rating r-35"></div></span></li>
<?php } ?>

<?php $rating_8 = get_post_meta($post->ID, 'creteria_1', true);
$rating_8_text = get_post_meta($post->ID, 'creteria_1_text', true);
if($rating_8!="0" && $rating_8=="4" && $rating_8_text!="" ){
?>
<li><?php echo  esc_attr(get_post_meta($post->ID, 'creteria_1_text', true)); ?> <span class="score"><div class="rating r-4"></div></span></li>
<?php } ?>

<?php $rating_9 = get_post_meta($post->ID, 'creteria_1', true);
$rating_9_text = get_post_meta($post->ID, 'creteria_1_text', true);
if($rating_9!="0" && $rating_9=="4.5" && $rating_9_text!="" ){
?>
<li><?php echo  esc_attr(get_post_meta($post->ID, 'creteria_1_text', true)); ?> <span class="score"><div class="rating r-45"></div></span></li>
<?php } ?>

<?php $rating_10 = get_post_meta($post->ID, 'creteria_1', true);
$rating_10_text = get_post_meta($post->ID, 'creteria_1_text', true);
if($rating_10!="0" && $rating_10=="5" && $rating_10_text!="" ){
?>
<li><?php echo  esc_attr(get_post_meta($post->ID, 'creteria_1_text', true)); ?> <span class="score"><div class="rating r-5"></div></span></li>
<?php }
// creteria two  start

?>


<?php $creteria_2_1 = get_post_meta($post->ID, 'creteria_2', true);
$creteria_text_2_1 = get_post_meta($post->ID, 'creteria_2_text', true);
if($creteria_2_1!="0" && $creteria_2_1=="0.5" && $creteria_text_2_1!="" ){
?>
<li><?php echo  esc_attr($creteria_text_2_1); ?> <span class="score"><div class="rating r-05"></div></span></li>
<?php } ?>


<?php $creteria_2_2 = get_post_meta($post->ID, 'creteria_2', true);
$creteria_text_2_2 = get_post_meta($post->ID, 'creteria_2_text', true);
if($creteria_2_2!="0" && $creteria_2_2=="1" && $creteria_text_2_2!="" ){
?>
<li><?php echo  esc_attr($creteria_text_2_2); ?> <span class="score"><div class="rating r-1"></div></span></li>
<?php } ?>

<?php $creteria_2_3 = get_post_meta($post->ID, 'creteria_2', true);
$creteria_text_2_3 = get_post_meta($post->ID, 'creteria_2_text', true);
if($creteria_2_3!="0" && $creteria_2_3=="1.5" && $creteria_text_2_3!="" ){
?>
<li><?php echo  esc_attr($creteria_text_2_3); ?> <span class="score"><div class="rating r-15"></div></span></li>
<?php } ?>

<?php $creteria_2_4 = get_post_meta($post->ID, 'creteria_2', true);
$creteria_text_2_4 = get_post_meta($post->ID, 'creteria_2_text', true);
if($creteria_2_4!="0" && $creteria_2_4=="2" && $creteria_text_2_4!="" ){
?>
<li><?php echo  esc_attr($creteria_text_2_4); ?> <span class="score"><div class="rating r-2"></div></span></li>
<?php } ?>

<?php $creteria_2_5 = get_post_meta($post->ID, 'creteria_2', true);
$creteria_text_2_5 = get_post_meta($post->ID, 'creteria_2_text', true);
if($creteria_2_5!="0" && $creteria_2_5=="2.5" && $creteria_text_2_5!="" ){
?>
<li><?php echo  esc_attr($creteria_text_2_5); ?> <span class="score"><div class="rating r-25"></div></span></li>
<?php } ?>

<?php $creteria_2_6 = get_post_meta($post->ID, 'creteria_2', true);
$creteria_text_2_6 = get_post_meta($post->ID, 'creteria_2_text', true);
if($creteria_2_6!="0" && $creteria_2_6=="3" && $creteria_text_2_6!="" ){
?>
<li><?php echo  esc_attr($creteria_text_2_6); ?> <span class="score"><div class="rating r-3"></div></span></li>
<?php } ?>


<?php $creteria_2_7 = get_post_meta($post->ID, 'creteria_2', true);
$creteria_text_2_7 = get_post_meta($post->ID, 'creteria_2_text', true);
if($creteria_2_7!="0" && $creteria_2_7=="3.5" && $creteria_text_2_7!="" ){
?>
<li><?php echo  esc_attr($creteria_text_2_7); ?> <span class="score"><div class="rating r-35"></div></span></li>
<?php } ?>

<?php $creteria_2_8 = get_post_meta($post->ID, 'creteria_2', true);
$creteria_text_2_8 = get_post_meta($post->ID, 'creteria_2_text', true);
if($creteria_2_8!="0" && $creteria_2_8=="4" && $creteria_text_2_8!="" ){
?>
<li><?php echo  esc_attr($creteria_text_2_8); ?> <span class="score"><div class="rating r-4"></div></span></li>
<?php } ?>

<?php $creteria_2_9 = get_post_meta($post->ID, 'creteria_2', true);
$creteria_text_2_9 = get_post_meta($post->ID, 'creteria_2_text', true);
if($creteria_2_9!="0" && $creteria_2_9=="4.5" && $rating_9_text!="" ){
?>
<li><?php echo  esc_attr($creteria_text_2_9); ?> <span class="score"><div class="rating r-45"></div></span></li>
<?php } ?>

<?php $creteria_2_10 = get_post_meta($post->ID, 'creteria_2', true);
$creteria_text_2_10 = get_post_meta($post->ID, 'creteria_2_text', true);
if($creteria_2_10!="0" && $creteria_2_10=="5" && $creteria_text_2_10!="" ){
?>
<li><?php echo  esc_attr($creteria_text_2_10); ?> <span class="score"><div class="rating r-5"></div></span></li>
<?php }
// creteria three start

?>


<?php $creteria_3_1 = get_post_meta($post->ID, 'creteria_3', true);
$creteria_text_3_1 = get_post_meta($post->ID, 'creteria_3_text', true);
if($creteria_3_1!="0" && $creteria_3_1=="0.5" && $creteria_text_3_1!="" ){
?>
<li><?php echo  esc_attr($creteria_text_3_1); ?> <span class="score"><div class="rating r-05"></div></span></li>
<?php } ?>


<?php $creteria_3_2 = get_post_meta($post->ID, 'creteria_3', true);
$creteria_text_3_2 = get_post_meta($post->ID, 'creteria_3_text', true);
if($creteria_3_2!="0" && $creteria_3_2=="1" && $creteria_text_3_2!="" ){
?>
<li><?php echo  esc_attr($creteria_text_3_2); ?> <span class="score"><div class="rating r-1"></div></span></li>
<?php } ?>

<?php $creteria_3_3 = get_post_meta($post->ID, 'creteria_3', true);
$creteria_text_3_3 = get_post_meta($post->ID, 'creteria_3_text', true);
if($creteria_3_3!="0" && $creteria_3_3=="1.5" && $creteria_text_3_3!="" ){
?>
<li><?php echo  esc_attr($creteria_text_3_3); ?> <span class="score"><div class="rating r-15"></div></span></li>
<?php } ?>

<?php $creteria_3_4 = get_post_meta($post->ID, 'creteria_3', true);
$creteria_text_3_4 = get_post_meta($post->ID, 'creteria_3_text', true);
if($creteria_3_4!="0" && $creteria_3_4=="2" && $creteria_text_3_4!="" ){
?>
<li><?php echo  esc_attr($creteria_text_3_4); ?> <span class="score"><div class="rating r-2"></div></span></li>
<?php } ?>

<?php $creteria_3_5 = get_post_meta($post->ID, 'creteria_3', true);
$creteria_text_3_5 = get_post_meta($post->ID, 'creteria_3_text', true);
if($creteria_3_5!="0" && $creteria_3_5=="2.5" && $creteria_text_3_5!="" ){
?>
<li><?php echo esc_attr($creteria_text_3_5); ?> <span class="score"><div class="rating r-25"></div></span></li>
<?php } ?>

<?php $creteria_3_6 = get_post_meta($post->ID, 'creteria_3', true);
$creteria_text_3_6 = get_post_meta($post->ID, 'creteria_3_text', true);
if($creteria_3_6!="0" && $creteria_3_6=="3" && $creteria_text_3_6!="" ){
?>
<li><?php echo  esc_attr($creteria_text_3_6); ?> <span class="score"><div class="rating r-3"></div></span></li>
<?php } ?>


<?php $creteria_3_7 = get_post_meta($post->ID, 'creteria_3', true);
$creteria_text_3_7 = get_post_meta($post->ID, 'creteria_3_text', true);
if($creteria_3_7!="0" && $creteria_3_7=="3.5" && $creteria_text_3_7!="" ){
?>
<li><?php echo  esc_attr($creteria_text_3_7); ?> <span class="score"><div class="rating r-35"></div></span></li>
<?php } ?>

<?php $creteria_3_8 = get_post_meta($post->ID, 'creteria_3', true);
$creteria_text_3_8 = get_post_meta($post->ID, 'creteria_3_text', true);
if($creteria_3_8!="0" && $creteria_3_8=="4" && $creteria_text_3_8!="" ){
?>
<li><?php echo  esc_attr($creteria_text_3_8); ?> <span class="score"><div class="rating r-4"></div></span></li>
<?php } ?>

<?php $creteria_3_9 = get_post_meta($post->ID, 'creteria_3', true);
$creteria_text_3_9 = get_post_meta($post->ID, 'creteria_3_text', true);
if($creteria_3_9!="0" && $creteria_3_9=="4.5" && $creteria_text_3_9!="" ){
?>
<li><?php echo  esc_attr($creteria_text_3_9); ?> <span class="score"><div class="rating r-45"></div></span></li>
<?php } ?>

<?php $creteria_3_10 = get_post_meta($post->ID, 'creteria_3', true);
$creteria_text_3_10 = get_post_meta($post->ID, 'creteria_3_text', true);
if($creteria_3_10!="0" && $creteria_3_10=="5" && $creteria_text_3_10!="" ){
?>
<li><?php echo  esc_attr($creteria_text_3_10); ?> <span class="score"><div class="rating r-5"></div></span></li>
<?php }
// creteria four start

?>

<?php $creteria_4_1 = get_post_meta($post->ID, 'creteria_4', true);
$creteria_text_4_1 = get_post_meta($post->ID, 'creteria_4_text', true);
if($creteria_4_1!="0" && $creteria_4_1=="0.5" && $creteria_text_4_1!="" ){
?>
<li><?php echo  esc_attr($creteria_text_4_1); ?> <span class="score"><div class="rating r-05"></div></span></li>
<?php } ?>


<?php $creteria_4_2 = get_post_meta($post->ID, 'creteria_4', true);
$creteria_text_4_2 = get_post_meta($post->ID, 'creteria_4_text', true);
if($creteria_4_2!="0" && $creteria_4_2=="1" && $creteria_text_4_2!="" ){
?>
<li><?php echo  esc_attr($creteria_text_4_2); ?> <span class="score"><div class="rating r-1"></div></span></li>
<?php } ?>

<?php $creteria_4_3 = get_post_meta($post->ID, 'creteria_4', true);
$creteria_text_4_3 = get_post_meta($post->ID, 'creteria_4_text', true);
if($creteria_4_3!="0" && $creteria_4_3=="1.5" && $creteria_text_4_3!="" ){
?>
<li><?php echo  esc_attr($creteria_text_4_3); ?> <span class="score"><div class="rating r-15"></div></span></li>
<?php } ?>

<?php $creteria_4_4 = get_post_meta($post->ID, 'creteria_4', true);
$creteria_text_4_4 = get_post_meta($post->ID, 'creteria_4_text', true);
if($creteria_4_4!="0" && $creteria_4_4=="2" && $creteria_text_4_4!="" ){
?>
<li><?php echo esc_attr($creteria_text_4_4); ?> <span class="score"><div class="rating r-2"></div></span></li>
<?php } ?>

<?php $creteria_4_5 = get_post_meta($post->ID, 'creteria_4', true);
$creteria_text_4_5 = get_post_meta($post->ID, 'creteria_4_text', true);
if($creteria_4_5!="0" && $creteria_4_5=="2.5" && $creteria_text_4_5!="" ){
?>
<li><?php echo esc_attr($creteria_text_4_5); ?> <span class="score"><div class="rating r-25"></div></span></li>
<?php } ?>

<?php $creteria_4_6 = get_post_meta($post->ID, 'creteria_4', true);
$creteria_text_4_6 = get_post_meta($post->ID, 'creteria_4_text', true);
if($creteria_4_6!="0" && $creteria_4_6=="3" && $creteria_text_4_6!="" ){
?>
<li><?php echo esc_attr($creteria_text_4_6); ?> <span class="score"><div class="rating r-3"></div></span></li>
<?php } ?>


<?php $creteria_4_7 = get_post_meta($post->ID, 'creteria_4', true);
$creteria_text_4_7 = get_post_meta($post->ID, 'creteria_4_text', true);
if($creteria_4_7!="0" && $creteria_4_7=="3.5" && $creteria_text_4_7!="" ){
?>
<li><?php echo esc_attr($creteria_text_4_7); ?> <span class="score"><div class="rating r-35"></div></span></li>
<?php } ?>

<?php $creteria_4_8 = get_post_meta($post->ID, 'creteria_4', true);
$creteria_text_4_8 = get_post_meta($post->ID, 'creteria_4_text', true);
if($creteria_4_8!="0" && $creteria_4_8=="4" && $creteria_text_4_8!="" ){
?>
<li><?php echo  esc_attr($creteria_text_4_8); ?> <span class="score"><div class="rating r-4"></div></span></li>
<?php } ?>

<?php $creteria_4_9 = get_post_meta($post->ID, 'creteria_4', true);
$creteria_text_4_9 = get_post_meta($post->ID, 'creteria_4_text', true);
if($creteria_4_9!="0" && $creteria_4_9=="4.5" && $creteria_text_4_9!="" ){
?>
<li><?php echo esc_attr($creteria_text_4_9); ?> <span class="score"><div class="rating r-45"></div></span></li>
<?php } ?>

<?php $creteria_4_10 = get_post_meta($post->ID, 'creteria_4', true);
$creteria_text_4_10 = get_post_meta($post->ID, 'creteria_4_text', true);
if($creteria_4_10!="0" && $creteria_4_10=="5" && $creteria_text_4_10!="" ){
?>
<li><?php echo  esc_attr($creteria_text_4_10); ?> <span class="score"><div class="rating r-5"></div></span></li>
<?php }
// creteria Five start

?>


<?php $creteria_5_1 = get_post_meta($post->ID, 'creteria_5', true);
$creteria_text_5_1 = get_post_meta($post->ID, 'creteria_5_text', true);
if($creteria_5_1!="0" && $creteria_5_1=="0.5" && $creteria_text_5_1!="" ){
?>
<li><?php echo  esc_attr($creteria_text_5_1); ?> <span class="score"><div class="rating r-05"></div></span></li>
<?php } ?>


<?php $creteria_5_2 = get_post_meta($post->ID, 'creteria_5', true);
$creteria_text_5_2 = get_post_meta($post->ID, 'creteria_5_text', true);
if($creteria_5_2!="0" && $creteria_5_2=="1" && $creteria_text_5_2!="" ){
?>
<li><?php echo esc_attr($creteria_text_5_2); ?> <span class="score"><div class="rating r-1"></div></span></li>
<?php } ?>

<?php $creteria_5_3 = get_post_meta($post->ID, 'creteria_5', true);
$creteria_text_5_3 = get_post_meta($post->ID, 'creteria_5_text', true);
if($creteria_5_3!="0" && $creteria_5_3=="1.5" && $creteria_text_5_3!="" ){
?>
<li><?php echo  esc_attr($creteria_text_5_3); ?> <span class="score"><div class="rating r-15"></div></span></li>
<?php } ?>

<?php $creteria_5_4 = get_post_meta($post->ID, 'creteria_5', true);
$creteria_text_5_4 = get_post_meta($post->ID, 'creteria_5_text', true);
if($creteria_5_4!="0" && $creteria_5_4=="2" && $creteria_text_5_4!="" ){
?>
<li><?php echo esc_attr($creteria_text_5_4); ?> <span class="score"><div class="rating r-2"></div></span></li>
<?php } ?>

<?php $creteria_5_5 = get_post_meta($post->ID, 'creteria_5', true);
$creteria_text_5_5 = get_post_meta($post->ID, 'creteria_5_text', true);
if($creteria_5_5!="0" && $creteria_5_5=="2.5" && $creteria_text_5_5!="" ){
?>
<li><?php echo  esc_attr($creteria_text_5_5); ?> <span class="score"><div class="rating r-25"></div></span></li>
<?php } ?>

<?php $creteria_5_6 = get_post_meta($post->ID, 'creteria_5', true);
$creteria_text_5_6 = get_post_meta($post->ID, 'creteria_5_text', true);
if($creteria_5_6!="0" && $creteria_5_6=="3" && $creteria_text_5_6!="" ){
?>
<li><?php echo  esc_attr($creteria_text_5_6); ?> <span class="score"><div class="rating r-3"></div></span></li>
<?php } ?>


<?php $creteria_5_7 = get_post_meta($post->ID, 'creteria_5', true);
$creteria_text_5_7 = get_post_meta($post->ID, 'creteria_5_text', true);
if($creteria_5_7!="0" && $creteria_5_7=="3.5" && $creteria_text_5_7!="" ){
?>
<li><?php echo  esc_attr($creteria_text_5_7); ?> <span class="score"><div class="rating r-35"></div></span></li>
<?php } ?>

<?php $creteria_5_8 = get_post_meta($post->ID, 'creteria_5', true);
$creteria_text_5_8 = get_post_meta($post->ID, 'creteria_5_text', true);
if($creteria_5_8!="0" && $creteria_5_8=="4" && $creteria_text_5_8!="" ){
?>
<li><?php echo  esc_attr($creteria_text_5_8); ?> <span class="score"><div class="rating r-4"></div></span></li>
<?php } ?>

<?php $creteria_5_9 = get_post_meta($post->ID, 'creteria_5', true);
$creteria_text_5_9 = get_post_meta($post->ID, 'creteria_5_text', true);
if($creteria_5_9!="0" && $creteria_5_9=="4.5" && $creteria_text_5_9!="" ){
?>
<li><?php echo  esc_attr($creteria_text_5_9); ?> <span class="score"><div class="rating r-45"></div></span></li>
<?php } ?>

<?php $creteria_5_10 = get_post_meta($post->ID, 'creteria_5', true);
$creteria_text_5_10 = get_post_meta($post->ID, 'creteria_5_text', true);
if($creteria_5_10!="0" && $creteria_5_10=="5" && $creteria_text_5_10!="" ){
?>
<li><?php echo  esc_attr($creteria_text_5_10); ?> <span class="score"><div class="rating r-5"></div></span></li>
<?php }
// creteria Five start
?>

</ul>

</div>

<?php } ?>
