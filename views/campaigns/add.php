<?php

	$settings = Plugin::getAllSettings('mailer');
	$api = new MCAPI($settings['apikey']);

	$templates = $api->campaignTemplates();
	$lists = $api->lists();

	if ($api->errorCode) {
		echo '<div class="abuseReports"><img src="../wolf/plugins/mailer/images/misc/abuseProblem.png" align="center" alt="Clear!" /> There is a problem with the MailChimp API - have you set up your API key yet?<br />The plugin is receiving the response that '.$api->errorMessage.'</div>';
	} else {
?>

<h1>Add a Campaign</h1>

<?php

	if(!$_GET['template']) {
		if(count($templates) == '0') {
			echo '<div class="abuseReports"><p>You don\'t have any templates on your account yet. How about setting one up now?</p><p>Once you\'ve saved your template, you can access it from here so you only need to do this once. You can select a layout here:</p></p>
				<a href="http://admin.mailchimp.com/templates/create?layout=1" target="_blank"><img src="../wolf/plugins/mailer/images/templates/basic.png" /></a>
				<a href="http://admin.mailchimp.com/templates/create?layout=2" target="_blank"><img src="../wolf/plugins/mailer/images/templates/left_column.png" /></a>
				<a href="http://admin.mailchimp.com/templates/create?layout=3" target="_blank"><img src="../wolf/plugins/mailer/images/templates/rich_text.png" /></a>
				<a href="http://admin.mailchimp.com/templates/create?layout=4" target="_blank"><img src="../wolf/plugins/mailer/images/templates/postcard.png" /></a>
				<a href="http://admin.mailchimp.com/templates/create?layout=5" target="_blank"><img src="../wolf/plugins/mailer/images/templates/right_column.png" /></a>
			</p>
			<p>Or you could <a href="http://admin.mailchimp.com/templates/design/" target="_blank">Code your own!</a></p>		
			</div>';
		}
		else {
			echo '<p>Please select a template to use for this campaign. Or you could <a href="http://admin.mailchimp.com/templates" target="_blank">set up another template</a> (using the MailChimp editor)</p>';
			echo '<table class="index" cellpadding="0" cellspacing="0" border="0">';
			foreach($templates as $template) {
				if($template['layout'] == '') {
					$templateImage = 'custom';
				}
				else {
					$templateImage = str_replace(' ', '_', strtolower($template['layout'])); 
				}
				?>
					<tr class="<?php echo odd_even(); ?>">
						<td><a href="<?php echo get_url('mailer/campaigns/add?template='.$template['id']); ?>"><img src="../wolf/plugins/mailer/images/templates/<?php echo $templateImage; ?>.png" /></a></td>
						<td>Editable Regions:<br /><small><?php foreach($template['sections'] as $sectionid => $sectionName) { echo ucwords($sectionName).'<br />'; } ?></small></td>
						<td><h2>"<?php echo $template['name']; ?>"</h2><p>&nbsp;</p><p><a class="templateButton" href="<?php echo get_url('mailer/campaigns/add?template='.$template['id']); ?>">Use this template</a> or <a href="http://admin.mailchimp.com/templates/edit?id=<?php echo $template['id']; ?>" target="_blank">edit it</a></p></td>
					</tr>
				<?php
			}
			echo '</table>';
			echo '<div class="clear"></div><p><a class="backButton" href="javascript: history.go(-1)">back</a></p>';
		}
	}

	if($_GET['template']) {
		if(!$_GET['listid']) {
			echo '<p>Which list you would like to send this email to? You can choose individual groups to send it to in the next step.</p>';
			foreach ($lists as $list) { ?>
			<div id="campaignList"><a href="<?php echo get_url('mailer/campaigns/add?template='.$_GET['template'].'&listid='.$list['id'].''); ?>"><img src="../wolf/plugins/mailer/images/templates/list.png" /><br /><?php echo $list['name']; ?></a></div>
<?php		}
			echo '<div class="clear"></div><p><a class="backButton" href="javascript: history.go(-1)">back</a></p>';
		}
		elseif(!$_GET['group']) {
			echo '<p>Which group would you like to send this campaign to?</p>';
			$groups = $api->listInterestGroups($_GET['listid']);
?>
				<div id="campaignList"><a href="<?php echo get_url('mailer/campaigns/add?template='.$_GET['template'].'&listid='.$_GET['listid'].'&group=all'); ?>"><img src="../wolf/plugins/mailer/images/templates/listAll.png" /><br />All Groups</a></div><div class="clear"></div>
<?php
			foreach($groups['groups'] as $group) {
?>
				<div id="campaignList"><a href="<?php echo get_url('mailer/campaigns/add?template='.$_GET['template'].'&listid='.$_GET['listid'].'&group='.$group.''); ?>"><img src="../wolf/plugins/mailer/images/templates/listSegment.png" /><br /><?php echo $group; ?></a></div>
<?php		}
			echo '<div class="clear"></div><p><a class="backButton" href="javascript: history.go(-1)">back</a></p>';
		}
		else { ?>

			<form method="post" action="<?php echo get_url('mailer/campaigns/createcampaign'); ?>">
				<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
					<input type="hidden" name="template" value="<?php echo $_GET['template']; ?>" />
					<input type="hidden" name="list_id" value="<?php echo $_GET['listid']; ?>" />
					<input type="hidden" name="group" value="<?php echo $_GET['group']; ?>" />
					<input type="hidden" name="auto_footer" value="FALSE" />
					<input type="hidden" name="generate_text" value="TRUE" />
					<tr>
						<td colspan="3" class="help"><strong>Headers and Email Info</strong></td>
					</tr>
					<tr>
						<td class="label"><small>Campaign Name</small></td>
						<td class="field"><input type="text" class="textbox" name="campaignName" /></td>
						<td class="help">What do you want this campaign to be known as</td>
					</tr>
					<tr>
						<td class="label"><small>Type</small></td>
						<td class="field">
							<input type="radio" name="campaignType" value="regular" checked="checked"> <small>HTML and Plain Text</small><br />
							<input type="radio" name="campaignType" value="plaintext"> <small>Just Plain Text</small><br />
						</td>
						<td class="help">What sort of email would you like to send</td>
					</tr>
					<tr>
						<td class="label"><small>From Name</small></td>
						<td class="field"><input type="text" class="textbox" name="campaignFromName" value="<?php echo $settings['fromname']; ?>" /></td>
						<td class="help">Who should this campaign be sent by</td>
					</tr>
					<tr>
						<td class="label"><small>From Email Address</small></td>
						<td class="field"><input type="text" class="textbox" name="campaignFromEmail" value="<?php echo $settings['senderemail']; ?>" /></td>
						<td class="help">What's the correct sender email address</td>
					</tr>
					<tr>
						<td class="label"><small>Email Subject Line</small></td>
						<td class="field"><input type="text" class="textbox" name="campaignSubject" value="<?php echo $settings['subject']; ?>" /></td>
						<td class="help">What do you want the subject line in the email to be?</td>
					</tr>
					<tr>
						<td colspan="3" class="help"><strong>Info and Options</strong></td>
					</tr>
					<tr>
						<td class="label"><small>Folder</small></td>
						<td class="field">
							<input type="radio" name="campaignFolder" value="none" checked="checked"> <small><strong>None</strong></small><br />
<?php

		$folders = $api->campaignFolders();
		foreach ($folders as $folder) {
			echo '<input type="radio" name="campaignFolder" value="'.$folder['folder_id'].'"> <small>'.$folder['name'].'</small><br />';
		}

?>
						</td>
						<td class="help">Which folder should we add this email to?<br />Do you want to <a href="#" onclick="toggle_popup('add-folder-popup', 'add_folder'); return false;">add a new folder</a>?</td>
					</tr>
					<tr>
						<td class="label"><small>Tracking</small></td>
						<td class="field">
							<input type="radio" name="campaignTracking" value="yes" checked="checked"> <small>Yes please</small><br />
							<input type="radio" name="campaignTracking" value="no"> <small>No thanks</small><br />
						</td>
						<td class="help">Do you want to enable tracking (opens, clicks etc)?</td>
					</tr>
					<tr>
						<td colspan="3" class="help"><strong>The Email</strong></td>
					</tr>
					<tr>
						<td class="label">HTML Version</td>
						<td class="help" colspan="2">
							<p><small><strong>Leave blank if you've selected "Just Plain Text" above</strong></small></p>
							<p><small><strong>In the next step you will see how this content will look when applied to your template. Below is a list of all the editable content areas. Please fill in eveything you want to add to this campaign.</strong></small></p>
							
<?php

						$templates = $api->campaignTemplates('');
						foreach($templates as $template) {
							if($_GET['template'] == $template['id']) {
								foreach($template['sections'] as $sectionid => $sectionName) {
									echo '
								<p>&nbsp;</p>
								<hr />
								<h3>'.$sectionName.'</h3>
								<textarea class="textarea" id="content_area_'.$sectionName.'" name="html_'.$sectionName.'" style="width: 100%" rows="20" cols="40"
									onkeydown="return allowTab(event, this);"
									onkeyup="return allowTab(event,this);"
									onkeypress="return allowTab(event,this);">
								</textarea>
								<script type="text/javascript">
									setTextAreaToolbar(\'content_area_'.$sectionName.'\', \'tinymce\');
								</script>	
								';
								}
							}
						}
?>					
						</td>
					</tr>
					<tr>
						<td class="label">Plain Text Version</td>
						<td class="help" colspan="2">
							<p><small><strong>Leave blank if you'd like to have this generated automatically based on the HTML content above</strong></small></p>
						<textarea class="textbox" name="plaintext"></textarea></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td><p><input type="submit" value="Continue" class="campaignContinue" /> or <a href="javascript: history.go(-1)">go back</a></p></td>
						<td>&nbsp;</td>
					</tr>
				</table>
			</form>

			<div class="popup" id="add-folder-popup" style="display:none;">
				<h3>Name</h3>
				<form action="<?php echo get_url('mailer/folderAdd'); ?>" method="post">
					<input type="hidden" name="template" value="<?php echo $_GET['template']; ?>" />
					<input type="hidden" name="listid" value="<?php echo $_GET['listid']; ?>" />
					<input type="hidden" name="group" value="<?php echo $_GET['group']; ?>" />
					<div>
						<p><input id="add_folder" maxlength="50" name="folderName" type="text" value="" /> 
						<input id="add_folder_button" name="commit" type="submit" value="Add this Folder" /></p><p><strong>Warning:</strong> you will lose any changes that you have made on this page!</p>
					</div>
					<p><a class="close-link" href="#" onclick="Element.hide('add-folder-popup'); return false;">Close</a></p>
				</form>
			</div>


<?php
			echo '<div class="clear"></div>';
		}
	}
}