<?php
	$settings = Plugin::getAllSettings('mailer');
	$api = new MCAPI($settings['apikey']);

?>
<p class="button"><a href="<?php echo get_url('plugin/mailer'); ?>"><img src="../wolf/plugins/mailer/images/mailer.png" align="middle" alt="Chimp" /> Mailer</a></p>

<?php
	if($settings['showSearch'] == 1) {
?>

<div class="box">
	<h2>Search</h2>
	<form>
		<p><input type="text" class="textbox" id="mailerSearch" /> <input class="mailerSearchSubmit" type="submit" value="Search Now!" /></p>
		<small>
			<ul class="searchList">
				<li><input type="checkbox" name="searchitems[]" checked="checked" value="campaigns" /> Campaigns</li>
				<li><input type="checkbox" name="searchitems[]" checked="checked" value="folders" /> Folders</li>
				<li><input type="checkbox" name="searchitems[]" checked="checked" value="lists" /> Lists</li>
				<li><input type="checkbox" name="searchitems[]" checked="checked" value="groups" /> Groups</li>
				<li><input type="checkbox" name="searchitems[]" checked="checked" value="members" /> Members</li>
			</ul>
		</small>
	</form>
</div>

<?php } ?>


<div class="box">
	<h2><?php echo __('Campaigns');?></h2>
	<p class="button"><a href="<?php echo get_url('plugin/mailer/campaigns'); ?>"><img src="../wolf/plugins/mailer/images/campaigns.png" align="middle" alt="Campaigns" /> View All Campaigns</a></p>
<?php
	if($settings['showCampaigns'] == 1) {
		$campaigns = $api->campaigns();
		foreach ($campaigns as $campaign) {
			if($campaign['folder_id'] == '' || $settings['showFolders'] == 0) {
				echo '<p class="button"><a href="'.get_url('plugin/mailer/viewcampaign/'.$campaign['id'].'').'">';
				echo '<img src="../wolf/plugins/mailer/images/campaignList.png" align="middle" alt="Campaign: '.$campaign['title'].'" /> ';
				echo $campaign['title'];
				echo '</a>';
				echo '</p>';
			}
		}
	}

	if($settings['showFolders'] == 1) {
		$folders = $api->campaignFolders();
		foreach ($folders as $folder) {
			echo '<p class="button"><a href="'.get_url('plugin/mailer/campaigns?folderid='.$folder['folder_id'].'').'">';
			echo '<img src="../wolf/plugins/mailer/images/campaignFolder.png" align="middle" alt="Folder: '.$folder['name'].'" /> ';
			echo $folder['name'];
			echo '</a>';
			echo '</p>';
			foreach ($campaigns as $campaign) {
				if($campaign['folder_id'] == $folder['folder_id']) {
					echo '<p class="button"><a href="'.get_url('plugin/mailer/viewcampaign/'.$campaign['id'].'').'">';
					echo '<img src="../wolf/plugins/mailer/images/campaignListLevel2.png" align="middle" alt="Campaign: '.$campaign['title'].'" /> ';
					echo $campaign['title'];
					echo '</a>';
					echo '</p>';
				}
			}
		}

	}

?>
		<p class="button"><a href="<?php echo get_url('plugin/mailer/campaigns/add'); ?>"><img src="../wolf/plugins/mailer/images/campaignsAdd.png" align="middle" alt="Add q Campaign" /> <?php echo __('Add Campaign'); ?></a></p>
		<p class="button"><a href="<?php echo get_url('plugin/mailer/folders/add'); ?>"><img src="../wolf/plugins/mailer/images/campaignsFolderAdd.png" align="middle" alt="Add a Folder" /> <?php echo __('Add Folder'); ?></a></p>
</div>

<div class="box">
	<h2><?php echo __('Mailing Lists and Groups');?></h2>
	<p class="button"><a href="<?php echo get_url('plugin/mailer/lists'); ?>"><img src="../wolf/plugins/mailer/images/lists.png" align="middle" alt="Lists" /> <?php echo __('View Lists'); ?></a></p>
<?php
	if($settings['showLists'] == 1) {
		$lists = $api->lists();
		foreach ($lists as $list) {
			echo '<p class="button"><a href="'.get_url('plugin/mailer/viewlist/'.$list['id'].'').'">';
			echo '<img src="../wolf/plugins/mailer/images/listsList.png" align="middle" alt="List: '.$list['name'].'" /> ';
			echo $list['name'];
			echo '</a>';
			echo '</p>';
		}
	}

?>	
	<p class="button"><a href="<?php echo get_url('plugin/mailer/groups'); ?>"><img src="../wolf/plugins/mailer/images/groups.png" align="middle" alt="Groups" /> <?php echo __('View Groups'); ?></a></p>
<?php
	if($settings['showGroups'] == 1) {
		$lists = $api->lists();
		foreach ($lists as $list) {
			$groups = $api->listInterestGroups($list['id']);
			foreach($groups['groups'] as $group) {
				echo '<p class="button"><a href="'.get_url('plugin/mailer/groups/view?name='.$group.'&list='.$list['id'].'').'">';
				echo '<img src="../wolf/plugins/mailer/images/groupList.png" align="middle" alt="Group: '.$group.'" /> ';
				echo $group;
				echo ' ('.$list['name'].')';
				echo '</a>';
				echo '</p>';
			}
		}
	}
?>	
	<p class="button"><a href="<?php echo get_url('plugin/mailer/groups/add'); ?>"><img src="../wolf/plugins/mailer/images/groupsAdd.png" align="middle" alt="Add a Group" /> <?php echo __('Add Group'); ?></a></p>
</div>

<div class="box">
	<h2><?php echo __('Members');?></h2>
	<p class="button"><a href="<?php echo get_url('plugin/mailer/members'); ?>"><img src="../wolf/plugins/mailer/images/members.png" align="middle" alt="View Members" /> <?php echo __('View Members'); ?></a></p>
	<p class="button"><a href="<?php echo get_url('plugin/mailer/members/add'); ?>"><img src="../wolf/plugins/mailer/images/membersAdd.png" align="middle" alt="Add Member" /> <?php echo __('Add Member'); ?></a></p>
</div>

<div class="box">
	<h2><?php echo __('Settings');?></h2>
	<p class="button"><a href="<?php echo get_url('plugin/mailer/account'); ?>"><img src="../wolf/plugins/mailer/images/account.png" align="middle" alt="Account" /> <?php echo __('MailChimp Account'); ?></a></p>
	<p class="button"><a href="<?php echo get_url('plugin/mailer/settings'); ?>"><img src="../wolf/plugins/mailer/images/settings.png" align="middle" alt="Settings" /> <?php echo __('Mailer Settings'); ?></a></p>
	<p class="button"><a href="<?php echo get_url('plugin/mailer/documentation'); ?>"><img src="../wolf/plugins/mailer/images/documentation.png" align="middle" alt="Documentation" /> <?php echo __('Documentation'); ?></a></p>
</div>