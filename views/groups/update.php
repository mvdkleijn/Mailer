<?php

	$settings = Plugin::getAllSettings('mailer');

	$api = new MCAPI($settings['apikey']);
	$lists = $api->lists();

?>
<h1><?php echo __('Update Group'); ?></h1>

<form action="<?php echo get_url('mailer/groupUpdate'); ?>" method="post">
	<input type="hidden" name="listid" value="<?php echo $_GET['list'] ?>" />
	<input type="hidden" name="oldname" value="<?php echo $_GET['name'] ?>" />
	<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td class="label"><label for="groupname">Name</label></td>
			<td class="field"><input class="textbox" id="groupname" maxlength="64" name="groupname" size="64" type="text" value="<?php echo $_GET['name'] ?>" /></td>
			<td class="help">The group's new name.</td>
		</tr>
		<tr>
			<td class="label"><label for="submit">&nbsp;</label></td>
			<td class="field"><input type="submit" value="Update Group" /> or <a href="<?php echo get_url('mailer/groups'); ?>">cancel</a></td>
			<td></td>
		</tr>
	</table>
</form>