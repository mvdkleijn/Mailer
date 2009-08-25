<?php

	$settings = Plugin::getAllSettings('mailer');

?>
<h1><?php echo __('Settings'); ?></h1>

<p>These are the settings for the MailChimp API.</p>

<form action="<?php echo get_url('plugin/mailer/saveSettings'); ?>" method="post">
	<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td colspan="3" class="help"><strong>MailChimp Settings</strong></td>
		</tr>
		<tr>
			<td class="label"><label for="apikey">API Key</label></td>
			<td class="field"><input class="textbox" id="apikey" maxlength="64" name="apikey" size="64" type="text" value="<?php echo $settings['apikey']; ?>" /></td>
			<td class="help">You need to get this from <a href="http://admin.mailchimp.com/account/api">MailChimp</a>.</td>
		</tr>
		<tr>
			<td class="label"><label for="username">Username</label></td>
			<td class="field"><input class="textbox" id="username" maxlength="64" name="username" size="64" type="text" value="<?php echo $settings['username']; ?>" /></td>
			<td class="help">This is your username for MailChimp.</td>
		</tr>
		<tr>
			<td class="label"><label for="password">Password</label></td>
			<td class="field"><input class="textbox" id="password" maxlength="64" name="password" size="64" type="password" value="" /></td>
			<td class="help">This is your password for MailChimp. Leave blank for no change.</td>
		</tr>
		<tr>
			<td class="label"><label for="apiUrl">API URL</label></td>
			<td class="field"><input class="textbox" id="apiUrl" maxlength="64" name="apiUrl" size="64" type="text" value="<?php echo $settings['apiUrl']; ?>" /></td>
			<td class="help"><strong>You should only change this if you know what you're doing!</strong></td>
		</tr>
		<tr>
			<td colspan="3" class="help"><strong>Default Email Settings when you set up a new Campaign</strong></td>
		</tr>
		<tr>
			<td class="label"><label for="subject">Subject</label></td>
			<td class="field"><input class="textbox" id="subject" maxlength="64" name="subject" size="64" type="text" value="<?php echo $settings['subject']; ?>" /></td>
			<td class="help">The default subject line in your emails</td>
		</tr>
		<tr>
			<td class="label"><label for="fromname">From Name</label></td>
			<td class="field"><input class="textbox" id="fromname" maxlength="64" name="fromname" size="64" type="text" value="<?php echo $settings['fromname']; ?>" /></td>
			<td class="help">Default from Name in the email</td>
		</tr>
		<tr>
			<td class="label"><label for="senderemail">Sender address</label></td>
			<td class="field"><input class="textbox" id="senderemail" maxlength="64" name="senderemail" size="64" type="text" value="<?php echo $settings['senderemail']; ?>" /></td>
			<td class="help">Default Senders email address</td>
		</tr>
		<tr>
			<td colspan="3" class="help"><strong>Test Email addresses</strong></td>
		</tr>
		<tr>
			<td class="label"><label for="testEmail">Test Email 1</label></td>
			<td class="field"><input class="textbox" id="testEmail" maxlength="64" name="testEmail" size="64" type="text" value="<?php echo $settings['testEmail']; ?>" /></td>
			<td class="help">Address to send tests to.</td>
		</tr>
		<tr>
			<td class="label"><label for="bossEmail">Test Email 2</label></td>
			<td class="field"><input class="textbox" id="bossEmail" maxlength="64" name="bossEmail" size="64" type="text" value="<?php echo $settings['bossEmail']; ?>" /></td>
			<td class="help">Another address to send tests to.</td>
		</tr>
		<tr>
			<td colspan="3" class="help"><strong>Sidebar Options</strong></td>
		</tr>
		<tr>
			<td class="label"><label for="showCampaigns">Show Campaigns</label></td>
			<td class="field"><input id="showCampaigns" name="showCampaigns" type="checkbox" value="1"<?php if($settings['showCampaigns'] == 1) { echo ' checked="checked"'; } ?> /></td>
			<td class="help">Show Campaign quicklinks in Sidebar.</td>
		</tr>
		<tr>
			<td class="label"><label for="showLists">Show Lists</label></td>
			<td class="field"><input id="showLists" name="showLists" type="checkbox" value="1"<?php if($settings['showLists'] == 1) { echo ' checked="checked"'; } ?> /></td>
			<td class="help">Show List quicklinks in Sidebar.</td>
		</tr>
		<tr>
			<td class="label"><label for="showGroups">Show Groups</label></td>
			<td class="field"><input id="showGroups" name="showGroups" type="checkbox" value="1"<?php if($settings['showGroups'] == 1) { echo ' checked="checked"'; } ?> /></td>
			<td class="help">Show Group quicklinks in Sidebar.</td>
		</tr>
		<tr>
			<td class="label"><label for="submit">&nbsp;</label></td>
			<td class="field"><input type="submit" value="Save Settings" /> or <a href="<?php echo get_url('plugin/mailer/index'); ?>">cancel</a></td>
			<td></td>
		</tr>
	</table>
</form>