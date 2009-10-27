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


	$lists = $api->lists();
	$count = 0;
	foreach($lists as $list) {
		$reports = $api->listAbuseReports($list['id']);
		$count = $count + count($reports);
	}
	
	if($count == 0) {
		echo '<div class="abuseClear"><img src="../wolf/plugins/mailer/images/misc/abuseClear2.png" align="center" alt="Clear!" /> You don\'t have any abuse reports against your lists</div>';
	}
	else {
		echo '<div class="abuseReports"><img src="../wolf/plugins/mailer/images/misc/abuseProblem.png" align="center" alt="Clear!" /> You have had abuse reports made against you!<br />';
		foreach($reports as $rpt) {
			$campaignUrl = get_url('mailer/viewcampaign/');
			echo 'Reported by '.$rpt['email'].' on '.$rpt['date'].' about <a href="'.$campaignUrl.''.$rpt['campaign_id'].'">one of your campaigns</a>';
		}	
		echo '</div>';
	}

	} else {
		echo '<div class="abuseReports"><img src="../wolf/plugins/mailer/images/misc/abuseProblem.png" align="center" alt="Clear!" /> There is a problem with the MailChimp API - have you set up your API key yet?</div>';
	}
	if(USE_MOD_REWRITE == FALSE) {
		echo '<div class="abuseReports"><img src="../wolf/plugins/mailer/images/misc/abuseProblem.png" align="center" alt="Clear!" /> You need to enable mod_rewrite for this plugin to work.<br />Behaviour in the backend is unpredicatable without it enabled.<br />Please amend your config.php and .htaccess files</div>';
	}

	if($settings['googleDisplay'] == '1') {
		echo '<div class="abuseReports"><a href="'.get_url('mailer/setupAnalytics').'" target="_blank">Add your Google Analytics account</a><br />(you must sign in to Mailchimp and Google)<br />Alternatively, <a href="'.get_url('mailer/saveAnalyticsState').'">turn off this message</a><br /><strong>Please note, once you have authorised Google, you will be directed to your MailChimp account, not back to here.</strong></div>';
	}


?>

<div id="chimpHome"><img src="../wolf/plugins/mailer/images/mailChimp.png" align="middle" alt="Mail Chimp" /></div>

<div id="rightHome">

<?php	if($settings['configured'] == 0) {	?>
<p>Hey there, <?php echo $propername; ?> - I see you haven't finished setting up this plugin yet. You'll need to set it up properly before you can use it.</p>

<p>I'd suggest you grab a banana and <a href="<?php echo get_url('mailer/documentation'); ?>">read the documentation</a> to get started.</p>

<?php	} else {	?>

<p>Hey there, <?php echo $propername; ?>.<p>
<p>What would you like to do today?</p>

<p>&nbsp;</p>
<p><a class="createButton" id="campaign" href="<?php echo get_url('mailer/campaigns/add'); ?>"><img src="../wolf/plugins/mailer/images/misc/add.png" align="top" alt="Add a Campaign" /> Create a New Campaign</a></p>
<p>&nbsp;</p>
<p><a class="createButton" id="subscriber" href="<?php echo get_url('mailer/members/add'); ?>">Add a new Subscriber</a>
<a class="createButton" id="groups" href="<?php echo get_url('mailer/groups/add'); ?>">Add a new Group</a></p>
<p>&nbsp;</p>
<p><a class="createButton" id="settings" href="<?php echo get_url('mailer/settings'); ?>"><img src="../wolf/plugins/mailer/images/misc/settingsHomePage.png" align="top" alt="Tweak your Settings" /> Adjust Settings</a>
<a class="createButton" id="search" href="<?php echo get_url('mailer/search'); ?>"><img src="../wolf/plugins/mailer/images/misc/searchHomePage.png" align="middle" alt="Search" /> Search</a></p>


<?php } ?>

</div>