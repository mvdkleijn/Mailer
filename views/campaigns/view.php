<?php

	$settings = Plugin::getAllSettings('mailer');
	$api = new MCAPI($settings['apikey']);
	// to do - add abuse headers!
	$abuse = $api->campaignAbuseReports($cid);

	$advice = $api->campaignAdvice($cid);
	$campaignStats = $api->campaignStats($cid);
	$campaignClickStats = $api->campaignClickStats($cid);
	$campaigns = $api->campaigns();
	foreach($campaigns as $campaign) {
		if($campaign['id'] == $cid) {
			$campaignDetails = $campaign;
		} 
	}
	$campaignContent = $api->campaignContent($cid);
	$lists = $api->lists();
	foreach ($lists as $list) {
		if($campaignDetails['list_id'] == $list['id']) {
			$listName = $list['name'];
		}
	}
	if($campaignDetails['segment_opts']) {
		$recipients = 'Segment of '.$listName.'';
	}
	else {
		$recipients = 'All members of '.$listName.'';	
	}


?>
<h1>Viewing Campaign: <?php echo $campaignDetails['title']; ?></h1>

<?php

	if($advice['0']['type'] == 'positive') {
		echo '<div class="abuseClear"><img src="../wolf/plugins/mailer/images/misc/abuseClear2.png" align="center" alt="Clear!" /> '.$advice['0']['msg'].'</div>';
	}
	elseif($advice['0']['type'] == 'negative') {
		echo '<div class="abuseReports"><img src="../wolf/plugins/mailer/images/misc/abuseProblem.png" align="center" alt="Clear!" /> '.$advice['0']['msg'].'</div>';
	}
	elseif($advice['0']['type'] == 'neutral') {
		echo '<div class="abuseNeutral"><img src="../wolf/plugins/mailer/images/misc/abuseNeutral.png" align="center" alt="Clear!" /> '.$advice['0']['msg'].'</div>';
	}
	else {
		echo '<div class="abuseReports"><p>This Campaign hasn\'t been sent yet - <a href="#" onclick="toggle_popup(\'send-now-popup\', \'send_now\'); return false;">Send Now!</a></p>
		<p><a href="#" onclick="toggle_popup(\'send-test-popup\', \'send_test\'); return false;">Send a test email</a></p></div>';
	}
?>


			<div class="popup" id="send-test-popup" style="display:none;">
				<h2>Send a test email</h2>
				<p>You are about to send this test email to:</p>
				<p><small><?php echo str_replace(',', '<br />', $settings['testEmail']) ?></small></p>
				<p>&nbsp;</p>
				<p><a class="backButton" href="<?php echo get_url('plugin/mailer/sendtest/'.$cid.'?emails='.$settings['testEmail'].'')?>"> Send this test</a> or <a class="close-link" href="#" onclick="Element.hide('send-test-popup'); return false;">cancel</a></p>
				<input id="send_test" type="hidden" /> 
				<p>&nbsp;</p>
			</div>

			<div class="popup" id="send-now-popup" style="display:none;">
				<h2>SEND NOW!</h2>
				<p>You are about to send this email</p>
				<p>&nbsp;</p>
				<p><a class="backButton" href="<?php echo get_url('plugin/mailer/sendcampaign/'.$cid.'')?>"> Send NOW!</a> or <a class="close-link" href="#" onclick="Element.hide('send-now-popup'); return false;">cancel</a></p>
				<input id="send_now" type="hidden" /> 
				<p>&nbsp;</p>
			</div>

<p>&nbsp;</p>
<p><a class="backButton" href="<?php echo get_url('plugin/mailer/campaigns'); ?>"><img src="../wolf/plugins/mailer/images/backButton.png" align="middle" alt="Back Button" /> Back to Campaigns</a></p>

<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td colspan="2" class="help"><strong>Details</strong></td>
	</tr>
	<tr>
		<td class="label"><small>Delivered</small></td>
		<td class="field"><?php echo $campaignDetails['send_time']; ?></td>
	</tr>
	<tr>
		<td class="label"><small>Created</small></td>
		<td class="field"><?php echo $campaignDetails['create_time']; ?></td>
	</tr>
	<tr>
		<td class="label"><small>From Name</small></td>
		<td class="field"><?php echo $campaignDetails['from_name']; ?></td>
	</tr>
	<tr>
		<td class="label"><small>Reply to Address</small></td>
		<td class="field"><?php echo $campaignDetails['from_email']; ?></td>
	</tr>
	<tr>
		<td class="label"><small>Subject</small></td>
		<td class="field"><?php echo $campaignDetails['subject']; ?></td>
	</tr>
	<tr>
		<td class="label"><small>Recipients</small></td>
		<td class="field"><?php echo $recipients; ?></td>
	</tr>

<?php
		if($campaignDetails['status'] == 'sent') {
?>
	<tr>
		<td colspan="2" class="help"><strong>Statistics</strong></td>
	</tr>
	<tr>
		<td class="label"><small>Emails Sent</small></td>
		<td class="field"><?php echo $campaignStats['emails_sent']; ?></td>
	</tr>
	<tr>
		<td class="label"><small>Unsubscribes</small></td>
		<td class="field"><?php echo $campaignStats['unsubscribes']; ?></td>
	</tr>
	<tr>
		<td class="label"><small>Bounces</small></td>
		<td class="field"><?php echo $campaignStats['hard_bounces']; ?> hard bounces<br /><?php echo $campaignStats['soft_bounces']; ?> soft bounces</td>
	</tr>
	<tr>
		<td class="label"><small>Abuse Reports</small></td>
		<td class="field"><?php echo $campaignStats['abuse_reports']; ?></td>
	</tr>
	<tr>
		<td class="label"><small>Forwarding</small></td>
		<td class="field"><?php echo $campaignStats['forwards']; ?><br />(<?php echo $campaignStats['forwards_opens']; ?> opens as a result)</td>
	</tr>
	<tr>
		<td class="label"><small>Opens</small></td>
		<td class="field"><?php echo $campaignStats['opens']; ?> times by <?php echo $campaignStats['unique_opens']; ?> members <?php if($campaignStats['last_open'] != '') { ?><br />(last opened on <?php echo $campaignStats['last_open']; ?>)<?php } ?></td>
	</tr>
	<tr>
		<td class="label"><small>Clicks</small></td>
		<td class="field"><?php echo $campaignStats['clicks']; ?> times by <?php echo $campaignStats['unique_clicks']; ?> members <?php if($campaignStats['last_click'] != '') { ?><br />(last clicked on <?php echo $campaignStats['last_click']; ?>)<?php } ?></td>
	</tr>
	<?php 	if($campaignStats['clicks'] > 0) {
				foreach($campaignClickStats as $key => $value) {
	?>

	<tr>
		<td class="label"><small>Individual Link Stats</small></td>
		<td class="field"><?php
			echo '<a href="'.$key.'" target="_blank">'.$key.'</a>';
			echo '<br />';
			foreach($value as $keytwo => $valuetwo) {
				echo ucwords($keytwo).' - '.$valuetwo.'<br />';
			
			}
		
		
		?></td>
	</tr>

	
<?php			}
			}
	
		}
		
		if($campaignDetails['type'] == 'regular') {
?>
	<tr>
		<td colspan="2" class="help"><strong>HTML Email</strong>:<br />
			<?php
				$rootDir = dirname(__FILE__);
				$rootDir = str_replace('views/campaigns', 'tmp', $rootDir);
				$tmpHTMLFile = $rootDir.'/htmlPreview.html';
				chmod($tmpHTMLFile, 0755);
				$opened = fopen($tmpHTMLFile, 'w') or die('Can\'t edit the temp file. I just tried to correct the priveleges on on the file, but it failed miserably and broke this page. Any chance you can CHMOD the file /mailer/tmp/htmlPreview.html to 755. kthnxbai');
				if($opened) {
					fwrite($opened, $campaignContent['html']);
					fclose($opened);
					echo '<iframe class="htmlPreview" src="'.URL_PUBLIC.'';
					if(!USE_MOD_REWRITE) { echo '?/'; }
					echo 'wolf/plugins/mailer/tmp/htmlPreview.html';
					echo '"></iframe>';
				}
			?>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="help"><strong>Plain Text Email</strong>:<br />
			<pre class="plainText">
				<?php echo $campaignContent['text']; ?>
			</pre>
		</td>
	</tr>
<?php	}
		elseif($campaignDetails['type'] == 'plaintext') { ?>
	<tr>
		<td colspan="2" class="help"><strong>Plain Text Email</strong>:<br />
			<pre class="plainText">
				<?php echo $campaignContent['text']; ?>
			</pre>
		</td>
	</tr>
<?php		
		}
?>


</table>

<p>&nbsp;</p>
<p><a class="backButton" href="<?php echo get_url('plugin/mailer/campaigns'); ?>"><img src="../wolf/plugins/mailer/images/backButton.png" align="middle" alt="Back Button" /> Back to Campaigns</a></p>
