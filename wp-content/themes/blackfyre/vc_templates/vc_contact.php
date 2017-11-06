<?php
$el_contact_title =  $el_class = '';
global $post;
extract( shortcode_atts( array(
    'el_contact_title' => '',
    'el_class' => '',
), $atts ) );
if(empty($css)) $css = '';
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_text_column wpb_content_element ' . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
?>

<div id="buddypress" class="<?php echo esc_attr($css_class); if(!empty($el_class)) echo esc_attr($el_class); ?>">
    <div class="wpb_wrapper">
        <div class="title-wrapper">
            <h3 class="widget-title"><i class="fa fa-envelope"></i> <?php if(!empty($el_contact_title)) echo esc_attr($el_contact_title); ?></h3>
            <div class="clear"></div>
        </div>
        <div class="wcontainer">
<?php

        if(isset($_POST['submitted'])) {

    if(trim($_POST['contactName']) === '') {

        $nameError = __('Please enter your name.', 'blackfyre');

        $hasError = true;

    } else {

        $name = trim($_POST['contactName']);

    }

    if(trim($_POST['email']) === '')  {

        $emailError = __('Please enter your email address.', 'blackfyre');

        $hasError = true;

    } else if (!preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim($_POST['email']))) {

        $emailError = __('You entered an invalid email address.', 'blackfyre');

        $hasError = true;

    } else {

        $email = trim($_POST['email']);

    }

    if(trim($_POST['comments']) === '') {

        $commentError = __('Please enter a message.', 'blackfyre');

        $hasError = true;

    } else {

        if(function_exists('stripslashes')) {

            $comments = stripslashes(trim($_POST['comments']));

        } else {

            $comments = trim($_POST['comments']);

        }

    }

    if(!isset($hasError)) {

        $emailTo = of_get_option('contact_email');

        if (!isset($emailTo) || ($emailTo == '') ){

            $emailTo = of_get_option('email');

        }

        $sub = esc_attr($_POST['subject']);

        $subject = '[PHP Snippets] From '.esc_attr($name);

        $body = "Name: $name \n\nEmail: $email \n\nSubject: $sub \n\nComments: $comments";

        $headers = 'From: '.$name.' <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;

        wp_mail($emailTo, $subject, $body, $headers);

        $emailSent = true;

    }

}
        ?>



           <?php  if(isset($emailSent) && $emailSent == true) { ?>

                            <div class="thanks">

                                <p><?php _e("Thanks, your email was sent successfully.", 'blackfyre'); ?></p>

                            </div>

                        <?php } else { ?>



                            <?php if(isset($hasError) || isset($captchaError)) { ?>

                                <p class="error"><?php _e("Sorry, an error occured.", 'blackfyre'); ?><p>

                            <?php } ?>

                        <form action="<?php the_permalink(); ?>" id="contactForm" class="contact" method="post">

                            <ul class="contactform controls">

                            <li class="input-prepend">



                                <input type="text" name="contactName" placeholder="Name*" id="contactName" value="<?php if(isset($_POST['contactName'])) echo $_POST['contactName'];?>" class="required requiredField" />
                                <?php if(!isset($nameError))$nameError = ''; ?>
                                <?php if($nameError != '') { ?>

                                    <span class="error"><?php esc_attr($nameError);?></span>

                                <?php } ?>

                            </li>

                            <li class="input-prepend">


                                <input type="text" placeholder="Email*" name="email" id="email" value="<?php if(isset($_POST['email']))  echo $_POST['email'];?>" class="required requiredField email" />
                                <?php if(!isset($emailError))$emailError = ''; ?>
                                <?php if($emailError != '') { ?>

                                    <span class="error"><?php esc_attr($emailError);?></span>

                                <?php } ?>

                            </li>

                            <li class="input-prepend">


                                <input type="text" placeholder="Subject" name="subject" id="subject" value="<?php if(isset($_POST['subject']))  echo $_POST['subject'];?>" class="subject" />

                            </li>

                            <li class="input-prepend">

                                <textarea name="comments" placeholder="Your message*" id="commentsText" rows="10" cols="30" class="required requiredField"><?php if(isset($_POST['comments'])) { if(function_exists('stripslashes')) { echo stripslashes($_POST['comments']); } else { echo $_POST['comments']; } } ?></textarea>
                                <?php if(!isset($commentError))$commentError = ''; ?>
                                <?php if($commentError != '') { ?>

                                    <span class="error"><?php esc_attr($commentError); ?></span>

                                <?php } ?>

                            </li>

                            <li>

                                   <input type="submit" class="button-green button-small"  value="<?php echo __("Send email", 'blackfyre'); ?>" />

                            </li>

                        </ul>

                        <input type="hidden" name="submitted" id="submitted" value="true" />

                    </form>

                <?php } ?>

    </div>
    </div>
</div>