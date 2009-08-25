<?php

	$settings = Plugin::getAllSettings('mailer');

	$configured = '';
	foreach($settings as $setting) {
		if($setting == '') {
			$configured .= '0';
		}
		else {
			$configured .= '1';
		}
	}

	$pos = strpos($configured, '0');	
	if ($pos === false) {
		$mailer = new MailerController();
		$mailer->updateConfiguredSetting('1');
	}
	else {
		$mailer = new MailerController();
		$mailer->updateConfiguredSetting('0');
	}

	AuthUser::load();
	$username = AuthUser::getRecord()->username;
	$propername = AuthUser::getRecord()->name;

?><h1>Mailer</h1>

<?php
	$api = new MCAPI($settings['apikey']);
	$result = $api->ping($settings['apikey']);
	if ($result == "Everything's Chimpy!") {
		echo '<div class="abuseClear"><img src="../wolf/plugins/mailer/images/misc/abuseClear.png" align="center" alt="Clear!" /> The MailChimp API is currently up and running</div>';
	} else {
		echo '<div class="abuseReports"><img src="../wolf/plugins/mailer/images/misc/abuseProblem.png" align="center" alt="Clear!" /> There is a problem with the MailChimp API - have you set up your API key yet?</div>';
	}
	if(USE_MOD_REWRITE == FALSE) {
		echo '<div class="abuseReports"><img src="../wolf/plugins/mailer/images/misc/abuseProblem.png" align="center" alt="Clear!" /> You need to enable mod_rewrite for this plugin to work.<br />Behaviour in the backend is unpredicatable without it enabled.<br />Please amend your config.php and .htaccess files</div>';
	}

?>

<p align="center"><img src="../wolf/plugins/mailer/images/mailChimp.png" align="middle" alt="Mail Chimp" /></p>

<?php	if($settings['configured'] == 0) {	?>
<p>Hey there, <?php echo $propername; ?> - I see you haven't finished setting up this plugin yet. You'll need to set it up properly before you can use it.</p>

<p>I'd suggest you grab a banana and <a href="<?php echo get_url('plugin/mailer/documentation'); ?>">reading the documentation</a> to getting started.</p>

<?php	} else {	?>

<p>Hey there, <?php echo $propername; ?>. What would you like to do today?</p>

<ul>
	<li><a href="<?php echo get_url('plugin/mailer/members/add'); ?>">Add a new subscriber</a></li>
	<li><a href="<?php echo get_url('plugin/mailer/members'); ?>">Edit existing subscribers</a></li>
	<li><a href="<?php echo get_url('plugin/mailer/groups/add'); ?>">Set up a group for mailing later</a></li>
</ul>

<p>Abuse Reports:</p>


<?php } ?>