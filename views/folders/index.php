<h1>Add a Folder</h1>
<?php

	$settings = Plugin::getAllSettings('mailer');

	$api = new MCAPI($settings['apikey']);
	$folders = $api->campaignFolders();

	if ($api->errorCode) {
		echo '<div class="abuseReports"><img src="../wolf/plugins/mailer/images/misc/abuseProblem.png" align="center" alt="Clear!" /> There is a problem with the MailChimp API - have you set up your API key yet?<br />The plugin is receiving the response that '.$api->errorMessage.'</div>';
	} else {
		
	foreach ($folders as $folder) {
		echo '<p class="button"><a href="'.get_url('mailer/viewfolder/'.$folder['folder_id'].'').'">';
		echo '<img src="../wolf/plugins/mailer/images/campaignFolder.png" align="middle" alt="Folder: '.$folder['name'].'" /> ';
		echo $folder['name'];
		echo '</a>';
		echo '</p>';
	}