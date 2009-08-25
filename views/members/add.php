<?php

	$settings = Plugin::getAllSettings('mailer');
	$api = new MCAPI($settings['apikey']);
	$lists = $api->lists();

?><h1>Add a Subscriber</h1>

<form action="<?php echo get_url('plugin/mailer/memberAdd'); ?>" method="post">
	<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td class="label"><label for="firstname">First Name</label></td>
			<td class="field"><input class="textbox" id="firstname" maxlength="64" name="firstname" size="64" type="text" value="" /></td>
			<td class="help">Users first name</td>
		</tr>
		<tr>
			<td class="label"><label for="lastname">Last Name</label></td>
			<td class="field"><input class="textbox" id="lastname" maxlength="64" name="lastname" size="64" type="text" value="" /></td>
			<td class="help">Users last name</td>
		</tr>
		<tr>
			<td class="label"><label for="email">Email address</label></td>
			<td class="field"><input class="textbox" id="email" maxlength="64" name="email" size="64" type="text" value="" /></td>
			<td class="help">Users email address</td>
		</tr>
		<tr>
			<td class="label"><label for="update">Update Existing</label></td>
			<td class="field">
				<input id="update" name="update" value="true" type="radio" checked="checked" /> Yes<br />
				<input id="update" name="update" value="false" type="radio" /> No<br />
			</td>
			<td class="help">If we find a user with the same email address, should we overwrite their profile with the new one?</td>
		</tr>
		<tr>
			<td class="label"><label for="list">List</label></td>
			<td class="field">
				<select name="listid">
<?php				foreach ($lists as $list) { ?>
						<option value="<?php echo $list['id']; ?>"><?php echo $list['name']; ?></option>
<?php				} ?>
				</select>
			</td>
			<td class="help">What list should this user belong to?</td>
		</tr>
		<tr>
			<td class="label"><label for="group">Groups</label></td>
			<td class="field"><?php
				foreach ($lists as $list) {
					$groups = $api->listInterestGroups($list['id']);
					foreach($groups['groups'] as $group) { ?>
				<input id="group" name="group[]" value="<?php echo $group; ?>" type="checkbox" /> <?php echo $group; ?> <small>(<?php echo $list['name']; ?>)</small><br />
<?php				}
				} ?>
			</td>
			<td class="help">Groups to subscribe this user to. You must select groups that belong to the list you have selected.</td>
		</tr>
		<tr>
			<td class="label"><label for="replace">Replace Groups</label></td>
			<td class="field">
				<input id="replace" name="replace" value="true" type="radio" checked="checked" /> Yes<br />
				<input id="replace" name="replace" value="false" type="radio" /> No<br />
			</td>
			<td class="help">If we find a user with the same email address, should we replace the groups that they're subscribed to?</td>
		</tr>
		<tr>
			<td class="label"><label for="prefs">Preferences</label></td>
			<td class="field">
				<input id="prefs" name="prefs" value="html" type="radio" checked="checked" /> HTML<br />
				<input id="prefs" name="prefs" value="text" type="radio" /> Plain Text<br />
			</td>
			<td class="help">Does the user want HTML or Plain Text emails?</td>
		</tr>
		<tr>
			<td class="label"><label for="optin">Confirmation Email</label></td>
			<td class="field">
				<input id="optin" name="optin" value="true" type="checkbox" /> Send opt in email<br />
			</td>
			<td class="help">If you select this option, the email address will be sent an opt in email to confirm their subscription. <strong>This will not be sent if the email address is already registered.</strong></td>
		</tr>
		<tr>
			<td class="label"><label for="welcome">Welcome Email</label></td>
			<td class="field">
				<input id="welcome" name="welcome" value="true" type="checkbox" /> Send a welcome email<br />
			</td>
			<td class="help">Send welcome mail to subscriber. <strong>This will not be sent if the email address is already registered.</strong></td>
		</tr>
		<tr>
			<td class="label"><label for="submit">&nbsp;</label></td>
			<td class="field"><input type="submit" value="Add Subscriber" /> or <a href="<?php echo get_url('plugin/mailer/index'); ?>">cancel</a></td>
			<td></td>
		</tr>
	</table>
</form>