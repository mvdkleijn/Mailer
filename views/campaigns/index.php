<?php

	$settings = Plugin::getAllSettings('mailer');
	$api = new MCAPI($settings['apikey']);


	if($_GET['folderid']) {
		$folders = $api->campaignFolders();
		foreach($folders as $folder) { if($folder['folder_id'] == $_GET['folderid']) { $foldername = $folder['name']; } }
		echo '<h1>Viewing '.$foldername.' folder</h1>';
	}
	else {
		echo '<h1>Campaigns</h1>';
	}

	$campaigns = $api->campaigns();

	if ($api->errorCode) {
		echo '<div class="abuseReports"><img src="../wolf/plugins/mailer/images/misc/abuseProblem.png" align="center" alt="Clear!" /> There is a problem with the MailChimp API - have you set up your API key yet?<br />The plugin is receiving the response that '.$api->errorMessage.'</div>';
	} else {
?>

<p>You have <?php echo sizeof($campaigns); ?> campaigns.</p>

<table id="campaigns" class="index" cellpadding="0" cellspacing="0" border="0">
	<thead>
		<tr>
			<th class="name">Name</th>
			<th class="type">Campaign Type</th>
			<th class="status">Status</th>
			<th class="folder">Folder</th>
			<th class="list">Target List</th>
			<th class="emails">Emails</th>
			<th class="options">Options</th>
		</tr>
	</thead>
	<tbody>
<?

	if($_GET['folderid']) {
		$revisedCampaigns = $campaigns;
		$campaigns = array();
		$i = 0;
		foreach($revisedCampaigns as $revisedCampaign) {
			if($_GET['folderid'] == $revisedCampaign['folder_id']) {
				$campaigns[$i] = $revisedCampaign;
				$i = $i + 1;
			}
		}
	}

	foreach($campaigns as $campaign) {
			?>

		<tr class="<?php echo odd_even(); ?>">
			<td><a href="<?php echo get_url('mailer/viewcampaign/'.$campaign['id'].''); ?>"><?php echo $campaign['title'] ?></a></td>
			<td><?php echo ucwords($campaign['type']); ?></td>
			<td><?php if($campaign['status'] == 'save') { ?>Draft<?php } elseif($campaign['status'] == 'sent') { ?>Sent on: <?php echo $campaign['send_time'] ?><?php } ?></td>
			<td><?php
					$folders = $api->campaignFolders();
					foreach ($folders as $folder) {
						if($folder['folder_id'] == $campaign['folder_id']) {
							echo $folder['name'];
						}
					}
				?></td>
			<td><?php 	
						$lists = $api->lists();
						foreach($lists as $list) { if($list['id'] == $campaign['list_id']) { echo $list['name']; } else { $listname = ''; } }
			?></td>
			<td><?php echo $campaign['emails_sent'] ?></td>
			<td><a href="<?php echo get_url('mailer/campaignDelete/'.$campaign['id'].'') ?>" onclick="return confirm('Are you sure you wish to delete the campaign <?php echo $campaign['title'] ?>?\n\nThis is NOT REVERSIBLE!')"><img src="images/icon-remove.gif" align="bottom" alt="Delete" /></a></td>
		</tr>

<?php
	}
?>
	</tbody>
</table>

<?php 	} ?>