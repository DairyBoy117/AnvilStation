<?php
 /*
 * Template Name: Clan Challenge
 */
?>
<?php get_header();?>
<div class="page normal-page container">

        <div class="row">
            <div class="col-lg-12 col-md-12">

<?php
$wpClanWars = new WP_ClanWars();

if ( isset($_GET['mid']) ) {    /***** UPDATE ******/

    $match_id = $_GET['mid'];
    $post_id = 0;
    $match = $wpClanWars->get_match(array('id' => $match_id));
    $match = (array) $match[0];

    $team1 = $wpClanWars->get_team(array('id' => $match['team1']));
    $team1 = (array) $team1[0];

    $team2 = $wpClanWars->get_team(array('id' => $match['team2']));
    $team2 = (array) $team2[0];

    $team1_id = $team1['id'];
    $clanid = $team1['post_id'];
    $post_id = $team2['post_id'];
    $title = $match['title'];
    $description = $match['description'];
    $external_url = $match['external_url'];
    $match_status = $match['match_status'];
    $datum = strtotime($match['date']);

    $status = $match['status'];

} elseif ( isset($_GET['pid']) ) {  /***** INSERT ******/
    $post_id = $_GET['pid'];
    $match_id  = 0;
    $title = "";
    $description = "";
    $external_url = "";
    $match_status = 0;
    $datum = strtotime("now");
    $team1_id = "";

}

$clans = blackfyre_get_user_clans(get_current_user_id());
foreach($clans as $clan){
	if(get_post_status($clan) == 'publish'){
		$clanid = $clan;
		break;
	}
}

if ($post_id==0 && $match_id!=0) {
	$match = $wpClanWars->get_match(array('id' => $match_id));
	$match = (array) $match[0];

	$team1 = $wpClanWars->get_team(array('id' => $match['team1']));
	$team1 = (array) $team1[0];

	$team2 = $wpClanWars->get_team(array('id' => $match['team2']));
	$team2 = (array) $team2[0];

	$team1_id = $team1['id'];

	$clanid = $team1['post_id'];
	$post_id = $team2['post_id'];
	$title = $match['title'];
	$description = $match['description'];
	$external_url = $match['external_url'];
	$match_status = $match['match_status'];
	$datum = strtotime($match['date']);
}





?>
<?php
if(!empty($_GET['pid'])) $redurl = get_permalink($_GET['pid']);
if(!empty($_GET['mid'])) $redurl = get_permalink(blackfyre_return_post_id_by_match_id_from_matches($_GET['mid']));
?>
<form id="challengeForm" class="wcontainer  challenge-form" onSubmit="tinyMCE.triggerSave();" method="post" action="<?php echo esc_url($redurl); ?>" enctype="multipart/form-data">

	<input type="hidden" name="action" value="wp-clanwars-matches">
	<input type="hidden" name="post_id" value="<?php echo esc_attr($post_id); ?>">
    <input type="hidden" name="match_id" value="<?php echo esc_attr($match_id); ?>">
    <input type="hidden" name="id" value="0">
	<input type="hidden" id="_wpnonce" name="_wpnonce" value="a27c5ee126">

	<table class="form-table">

		<tbody>
			<?php if($status != 'done'){ ?>
			<tr class="form-field form-required">

			<th scope="row" valign="top"><label for="game_id"><?php esc_html_e('Game', 'blackfyre'); ?></label></th>
			<td>
				<select id="game_id" name="game_id">
				 <?php blackfyre_mutual_games_inter($clanid, $post_id); ?>
				</select>
			</td>
		</tr>
		<?php } ?>
		<tr class="form-field form-required">
			<th scope="row" valign="top"><label for="m_title"><?php esc_html_e('Title', 'blackfyre'); ?></label></th>
			<td>
				<input name="m_title" id="m_title" type="text" value="<?php echo esc_attr($title); ?>" maxlength="200" autocomplete="off" aria-required="true" >
			</td>
		</tr>

		<tr class="form-field">
			<th scope="row" valign="top"><label for="description"><?php esc_html_e('Description', 'blackfyre'); ?></label></th>
			<td>
			    <?php $settings = array( 'textarea_name'=>'description', 'textarea_rows'=>4 );
	            wp_editor( $description, 'description', $settings ); ?>
			</td>
		</tr>


		<tr class="form-field">
			<th scope="row" valign="top"><label for="external_url"><?php esc_html_e('External URL', 'blackfyre'); ?></label></th>
			<td>
				<input type="text" name="external_url" id="external_url" value="<?php echo esc_url($external_url); ?>">

				<i><?php esc_html_e('Enter league URL or external match URL.', 'blackfyre'); ?></i>
			</td>
		</tr>
	<?php if($status != 'done'){ ?>
		<tr class="form-required">
			<th scope="row" valign="top"><label for=""><?php esc_html_e('Match type', 'blackfyre'); ?></label></th>
	        <td>
	            <label for="match_status_0"><input type="radio" value="0" name="match_status" id="match_status_0"
				<?php if($match_status==0):?>checked<?php endif;?>><?php esc_html_e('Friendly', 'blackfyre'); ?></label><br>

	            <label for="match_status_1"><input type="radio" value="1" name="match_status" id="match_status_1"
				<?php if($match_status==1):?>checked<?php endif;?>><?php esc_html_e('Official', 'blackfyre'); ?></label><br>
	        </td>
		</tr>
		<?php } ?>
		<?php if(!isset($status))$status = ''; ?>
        <?php if($status == 'done'){}else{ ?>
		<tr class="form-required">
			<th scope="row" valign="top"><label for=""><?php esc_html_e('Date', 'blackfyre'); ?></label></th>
			<td>
				<?php  $wpClanWars->html_date_helper('date', $datum);?>
	        </td>
		</tr>
        <?php } ?>

  <?php if(!isset($_GET['mid'])){ ?>
		<tr class="form-required">
			<th scope="row" valign="top"></th>
			<td>
				<div class="match-results" id="matchsite">

					<div class="teams">
	                    <select name="team1" id="team1" class="team-select">
	                    <?php /*?> <option value=""><?php esc_html_e('select game', 'blackfyre'); ?></option><?php */?>
	                        <?php foreach($clans as $clan){ ?>
	                            <?php if(get_post_status($clan) == 'publish'){ ?>
	                            <option value="<?php echo esc_attr($clan); ?>" <?php if($team1_id==$clan):?>selected<?php endif;?>><?php echo esc_attr(get_the_title($clan)); ?></option>
	                            <?php } ?>
	                        <?php } ?>
	                    </select>

	                    <?php esc_html_e('vs', 'blackfyre'); ?>

	                    <?php echo esc_attr(get_the_title($post_id)); ?>
					</div>

					<div id="mapsite"></div>

					<div class="add-map" id="wp-cw-addmap"><?php /*?>on_ajax_get_maps<?php */?>
						<input type="button" class="button-small required requiredField" value="Add map">
					</div>

				</div>

			</td>
		</tr>
 <?php } ?>
		</tbody>
	</table>
	<?php $errmsg = esc_html__("This field is required!","blackfyre"); ?>
    <?php if( isset($_GET['mid']) ){ ?>
       <script>
    jQuery(document).ready(function($) {
            var chl = $('#wp-cw-submit');
            var title = $('#m_title');

            chl.bind('click', function(event) {

            var titlelabel = $('.form-required .tit');

            if(title.val()){}else{
              if(titlelabel.length === 0){
                 title.after('<label for="m_title" class="ermaps tit"><?php echo esc_js($errmsg); ?></label>');
              }
            }

            if(!title.val()){
             return false;
             event.preventDefault();
            }

            });
    });
       </script>
	   <p class="submit"><input type="submit" class="button-primary" id="wp-cw-submit" name="submit_add_match" value="Update"></p>
    <?php }else{ ?>
        <script>
    jQuery(document).ready(function($) {
            var chl = $('#wp-cw-submit');
            var mapsite = $('#mapsite');
            var addmap = $('#wp-cw-addmap');
            var title = $('#m_title');
            var addmapbutton = $('#wp-cw-addmap .button-small');

            chl.bind('click', function(event) {
            var addmaplabel = $('#wp-cw-addmap label');
            var titlelabel = $('.form-required .tit');

            if(mapsite.has('.map').length === 0){
               if(addmaplabel.length === 0){
                    addmap.append('<label for="maps" class="ermaps"><?php echo esc_js($errmsg); ?></label>');

              }

            }else if(addmaplabel.length !== 0){
                addmap.find('.ermaps').remove();
            }


            if(title.val()) {
            var inputs = $('[id=roundval]');
            inputs.val('0');
            inputs.removeAttr('disabled');
            }else{
              if(titlelabel.length === 0){
                 title.after('<label for="m_title" class="ermaps tit"><?php echo esc_js($errmsg); ?></label>');
              }
            }

            if(!title.val() || mapsite.has('.map').length === 0){
             return false;
             event.preventDefault();
            }

            });

            addmap.bind('click', function() {
                var challenge_inputs = $('#mapsite .round input');
                challenge_inputs.prop('disabled', true);
                addmap.find('.ermaps').remove();

                var addround = $('.add-round');
                addround.bind('click', function() {

                var inputs = $('[id=roundval]');
                inputs.val('0');
                inputs.prop('disabled', true);
            });
            });
    });
        </script>
       <p class="submit"><input type="submit" class="button-primary" id="wp-cw-submit" name="submit_add_match" value="Challenge"></p>
    <?php } ?>
</form>

	<script>
    jQuery(document).ready(function($) {
        $('#team1').change(function(){
            $('#game_id').load(ajaxurl, {"action":"blackfyre_mutual_games", "team1":$(this).val(), "team2":<?php echo esc_js($post_id); ?>} );
        });
    });
    </script>


            <div class="clear"></div>
            </div>
        </div>

</div>

<?php get_footer(); ?>