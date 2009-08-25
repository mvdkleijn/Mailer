<?php
	$settings = Plugin::getAllSettings('mailer');
	$api = new MCAPI($settings['apikey']);

?>
	<p class="button"><a href="<?php echo get_url('plugin/mailer'); ?>"><img src="../wolf/plugins/mailer/images/mailer.png" align="middle" alt="page icon" /> Mailer</a></p>

<div class="box">
	<h2><?php echo __('Campaigns');?></h2>
	<p class="button"><a href="<?php echo get_url('plugin/mailer/campaigns'); ?>"><img src="../wolf/plugins/mailer/images/campaigns.png" align="middle" alt="page icon" /> <?php echo __('View Campaigns'); ?></a></p>
<?php
	if($settings['showCampaigns'] == 1) {
		$campaigns = $api->campaigns();
		foreach ($campaigns as $campaign) {
			echo '<p class="button"><a href="'.get_url('plugin/mailer/viewcampaign/'.$campaign['id'].'').'">';
			echo '<img src="../wolf/plugins/mailer/images/campaignList.png" align="middle" alt="page icon" /> ';
			echo $campaign['title'];
			echo '</a>';
			echo '</p>';
		}
	}

?>		<p class="button"><a href="<?php echo get_url('plugin/mailer/campaigns/add'); ?>"><img src="../wolf/plugins/mailer/images/campaignsAdd.png" align="middle" alt="page icon" /> <?php echo __('Add Campaign'); ?></a></p>
</div>

<div class="box">
	<h2><?php echo __('Mailing Lists and Groups');?></h2>
	<p class="button"><a href="<?php echo get_url('plugin/mailer/lists'); ?>"><img src="../wolf/plugins/mailer/images/lists.png" align="middle" alt="page icon" /> <?php echo __('View Lists'); ?></a></p>
<?php
	if($settings['showLists'] == 1) {
		$lists = $api->lists();
		foreach ($lists as $list) {
			echo '<p class="button"><a href="'.get_url('plugin/mailer/viewlist/'.$list['id'].'').'">';
			echo '<img src="../wolf/plugins/mailer/images/listsList.png" align="middle" alt="page icon" /> ';
			echo $list['name'];
			echo '</a>';
			echo '</p>';
		}
	}

?>	
	<p class="button"><a href="<?php echo get_url('plugin/mailer/groups'); ?>"><img src="../wolf/plugins/mailer/images/groups.png" align="middle" alt="page icon" /> <?php echo __('View Groups'); ?></a></p>
<?php
	if($settings['showGroups'] == 1) {
		$lists = $api->lists();
		foreach ($lists as $list) {
			$groups = $api->listInterestGroups($list['id']);
			foreach($groups['groups'] as $group) {
				echo '<p class="button"><a href="'.get_url('plugin/mailer/groups/view?name='.$group.'&list='.$list['id'].'').'">';
				echo '<img src="../wolf/plugins/mailer/images/groupList.png" align="middle" alt="page icon" /> ';
				echo $group;
				echo ' ('.$list['name'].')';
				echo '</a>';
				echo '</p>';
			}
		}
	}
?>	
	<p class="button"><a href="<?php echo get_url('plugin/mailer/groups/add'); ?>"><img src="../wolf/plugins/mailer/images/groupsAdd.png" align="middle" alt="page icon" /> <?php echo __('Add Group'); ?></a></p>
</div>

<div class="box">
	<h2><?php echo __('Members');?></h2>
	<p class="button"><a href="<?php echo get_url('plugin/mailer/members'); ?>"><img src="../wolf/plugins/mailer/images/members.png" align="middle" alt="page icon" /> <?php echo __('View Members'); ?></a></p>
	<p class="button"><a href="<?php echo get_url('plugin/mailer/members/add'); ?>"><img src="../wolf/plugins/mailer/images/membersAdd.png" align="middle" alt="page icon" /> <?php echo __('Add Member'); ?></a></p>
</div>

<div class="box">
	<h2><?php echo __('Settings');?></h2>
	<p class="button"><a href="<?php echo get_url('plugin/mailer/account'); ?>"><img src="../wolf/plugins/mailer/images/account.png" align="middle" alt="page icon" /> <?php echo __('MailChimp Account'); ?></a></p>
	<p class="button"><a href="<?php echo get_url('plugin/mailer/settings'); ?>"><img src="../wolf/plugins/mailer/images/settings.png" align="middle" alt="page icon" /> <?php echo __('Mailer Settings'); ?></a></p>
	<p class="button"><a href="<?php echo get_url('plugin/mailer/documentation'); ?>"><img src="../wolf/plugins/mailer/images/documentation.png" align="middle" alt="page icon" /> <?php echo __('Documentation'); ?></a></p>
</div>