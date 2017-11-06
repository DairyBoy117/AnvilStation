<?php
 /*
 * Template Name: Activation Template
 */
?>
<?php get_header(); ?>

<?php

$hash = $_GET['key'];
$uid = $_GET['id'];
$error = $_GET['act_error'];
?>
<div class="registration-login">
  <div class="container page normal-page">

		<div class="col-lg-7 col-md-12 register-form-wrapper wcontainer">

			<?php
			$user_hash = get_user_meta($uid, 'hash', true);

			if($error == 1){ ?>

				<i class="fa fa-minus-circle"></i>
				<?php
				esc_html_e('Your account is not active yet, please check your email for activation link!', 'blackfyre');

			}else{
				if($user_hash == $hash){ update_user_meta($uid, 'active', 'true');

					?>
					<i class="fa fa-info-circle"></i>
					<?php
					esc_html_e('Congratulations, you can now log-in into your account!', 'blackfyre');

				}else{

					?>
					<i class="fa fa-minus-circle"></i>
					<?php
					esc_html_e('Ooops your hash code is invalid, cheating huh?!', 'blackfyre');

				}
			}
			?>

		</div>

  </div>
</div>
<?php get_footer(); ?>