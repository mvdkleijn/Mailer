<h1>Add a Folder</h1>
<?php

	$settings = Plugin::getAllSettings('mailer');

	$api = new MCAPI($settings['apikey']);
	$lists = $api->lists();

	if ($api->errorCode) {
		echo '<div class="abuseReports"><img src="../wolf/plugins/mailer/images/misc/abuseProblem.png" align="center" alt="Clear!" /> There is a problem with the MailChimp API - have you set up your API key yet?<br />The plugin is receiving the response that '.$api->errorMessage.'</div>';
	} else {
?>


<form action="<?php echo get_url('mailer/folderAdd'); ?>" method="post">
	<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td class="label"><label for="folderName">Name</label></td>
			<td class="field"><input class="textbox" id="folderName" maxlength="64" name="folderName" size="64" type="text" value="" /></td>
			<td class="help">The folder's name.</td>
		</tr>
		<tr>
			<td class="label"><label for="submit">&nbsp;</label></td>
			<td class="field"><input type="submit" value="Add Folder" /> or <a href="<?php echo get_url('mailer/'); ?>">cancel</a></td>
			<td></td>
		</tr>
	</table>
</form>
<?php } ?>