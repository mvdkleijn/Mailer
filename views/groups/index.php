<?php

	$settings = Plugin::getAllSettings('mailer');
	$api = new MCAPI($settings['apikey']);

?>
<h1>Available Groups</h1>
<?php

	$lists = $api->lists();

	if ($api->errorCode) {
		echo '<div class="abuseReports"><img src="../wolf/plugins/mailer/images/misc/abuseProblem.png" align="center" alt="Clear!" /> There is a problem with the MailChimp API - have you set up your API key yet?<br />The plugin is receiving the response that '.$api->errorMessage.'</div>';
	} else {  ?>

<p>Below is a list of your groups:</p>

<table id="groups" class="index" cellpadding="0" cellspacing="0" border="0">
	<thead>
		<tr>
			<th class="name">Name</th>
			<th class="name">List group belongs to</th>
			<th class="edit">Edit</th>
		</tr>
	</thead>
	<tbody>
	
<?php

		foreach ($lists as $list){
			$groups = $api->listInterestGroups($list['id']);
			foreach($groups['groups'] as $group) {
				echo '<tr class="'.odd_even().'">';
				echo '<td>';
				echo '<a href="'.get_url('mailer/groups/view?name='.$group.'&list='.$list['id'].'').'">';
				echo $group;
				echo '</a>';
				echo '</td>';
				echo '<td>';
				echo $list['name'];
				echo '</td>';
				echo '<td>';
				echo '<a href="'.get_url('mailer/groups/update?name='.$group.'&list='.$list['id'].'').'"><img src="../wolf/plugins/mailer/images/groupsEdit.png" align="middle" alt="page icon" /></a> <a href="'.get_url('mailer/groupDelete/'.$group.'---'.$list['id'].'').'" onclick="return confirm(\'Are you sure you wish to delete '.$group.'?\n\nAny members who are subscribed to this group will be removed from this group but will still have an active account\n\nIf the subscriber is other lists, they will remain on those lists\')"><img src="images/icon-remove.gif" align="middle" alt="Delete" /></a>';
				echo '</td>';
				echo '</tr>';
			}
		}
?>
	</tbody>
</table>

<?php } ?>