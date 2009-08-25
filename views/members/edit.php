<?php

	$settings = Plugin::getAllSettings('mailer');
	$api = new MCAPI($settings['apikey']);
	
	$lists = $api->lists();
	foreach ($lists as $list) {
		$member = $api->listMemberInfo($list['id'], $_GET['email']);
		$actualListid = $list['id'];
		if($member['id'] == $_GET['userid']) {

		$subscribedTo = $member['merges']['INTERESTS'];
?>

<h1>Editing Subscriber: <?php echo $member['merges']['FNAME'] ?> <?php echo $member['merges']['LNAME'] ?></h1>

<?php if($member['ip_opt'] != '') { ?>
<p>Opted in on <?php echo $member['timestamp'] ?> from IP address <?php echo $member['ip_opt'] ?></p>
<?php } elseif($member['ip_signup'] != '') { ?>
<p>Signed up on <?php echo $member['timestamp'] ?> from IP address <?php echo $member['ip_signup'] ?></p>
<?php } ?>


<form action="<?php echo get_url('plugin/mailer/memberUpdate'); ?>" method="post">
	<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td class="label"><label for="firstname">First Name</label></td>
			<td class="field"><input class="textbox" id="firstname" maxlength="64" name="firstname" size="64" type="text" value="<?php echo $member['merges']['FNAME'] ?>" /></td>
			<td class="help">Users first name</td>
		</tr>
		<tr>
			<td class="label"><label for="lastname">Last Name</label></td>
			<td class="field"><input class="textbox" id="lastname" maxlength="64" name="lastname" size="64" type="text" value="<?php echo $member['merges']['LNAME'] ?>" /></td>
			<td class="help">Users last name</td>
		</tr>
		<tr>
			<td class="label"><label for="newemail">Email address</label></td>
			<td class="field">	<input class="textbox" id="email" maxlength="64" name="email" size="64" type="hidden" value="<?php echo $member['email'] ?>" />
								<input class="textbox" id="newemail" maxlength="64" name="newemail" size="64" type="text" value="<?php echo $member['email'] ?>" />
			</td>
			<td class="help">Update this users email address.</td>
		</tr>
		<tr>
			<td class="label"><label for="listid">List</label></td>
			<td class="field">
						<?php echo $list['name'] ?>
						<input class="textbox" id="listid" maxlength="64" name="listid" size="64" type="hidden" value="<?php echo $list['id'] ?>" />
			</td>
			<td class="help">You cannot move this member to another list. You need to add a new subscriber to do that.</td>
		</tr>
		<tr>
			<td class="label"><label for="group">Groups</label></td>
			<td class="field"><?php
					$groups = $api->listInterestGroups($list['id']);
					foreach($groups['groups'] as $group) { ?>

				<input id="group" name="group[]" value="<?php echo $group; ?>" type="checkbox"<?php
				
					$pos = strpos($subscribedTo,$group);
					if($pos === false) { }
					else {
						echo ' checked="checked"';
					}

				?> /> <?php echo $group; ?> <small>(<?php echo $list['name']; ?>)</small><br />
<?php				} ?>
			</td>
			<td class="help">Groups to subscribe this user to. You must select groups that belong to the list you have selected.</td>
		</tr>
		<tr>
			<td class="label"><label for="prefs">Preferences</label></td>
			<td class="field">
				<input id="prefs" name="prefs" value="html" type="radio" <?php if($member['email_type'] == 'html') { echo ' checked="checked"'; } ?> /> HTML<br />
				<input id="prefs" name="prefs" value="text" type="radio" <?php if($member['email_type'] == 'text') { echo ' checked="checked"'; } ?>/> Plain Text<br />
			</td>
			<td class="help">Does the user want HTML or Plain Text emails?</td>
		</tr>

		<tr>
			<td class="label"><label for="submit">&nbsp;</label></td>
			<td class="field"><input type="submit" value="Update Subscriber" /> or <a href="<?php echo get_url('plugin/mailer/members'); ?>">cancel</a></td>
			<td></td>
		</tr>
	</table>
</form>
<?php
		}
	}
?>