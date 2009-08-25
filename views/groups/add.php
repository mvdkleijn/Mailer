<?php

	$settings = Plugin::getAllSettings('mailer');

	$api = new MCAPI($settings['apikey']);
	$lists = $api->lists();

?>
<h1><?php echo __('Add a new group'); ?></h1>

<form action="<?php echo get_url('plugin/mailer/groupAdd'); ?>" method="post">
	<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td class="label"><label for="groupname">Name</label></td>
			<td class="field"><input class="textbox" id="groupname" maxlength="64" name="groupname" size="64" type="text" value="" /></td>
			<td class="help">The new group's name.</td>
		</tr>
		<tr>
			<td class="label"><label for="listid">List</label></td>
			<td class="field">
				<select name="listid">
				<?php
					foreach ($lists as $list){
						echo '<option value="'.$list['id'].'">'.$list['name'].'</option>';
					}
				?>
				</select>
			</td>
			<td class="help">The list you'd like to add this group to.</td>
		</tr>
		<tr>
			<td class="label"><label for="submit">&nbsp;</label></td>
			<td class="field"><input type="submit" value="Add Group" /> or <a href="<?php echo get_url('plugin/mailer/groups'); ?>">cancel</a></td>
			<td></td>
		</tr>
	</table>
</form>