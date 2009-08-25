<?php

class MailerController extends PluginController {

	public function __construct() {
		$this->setLayout('backend');
		$this->assignToLayout('sidebar', new View('../../plugins/mailer/views/sidebar'));
	}

	public function index() {
		$this->display('mailer/views/index');
	}

	public function account() {
		$this->display('mailer/views/account/index');
	}

	function settings() {
		$this->display('mailer/views/settings/index');
	}

	public function campaigns() {
		$this->display('mailer/views/campaigns/index');
	}

	function campaignDelete($cid) {
		$settings = Plugin::getAllSettings('mailer');
		$api = new MCAPI($settings['apikey']);
		$delete = $api->campaignDelete($cid);
		Flash::set('success', __('This campaign has been deleted'));
		redirect(get_url('plugin/mailer/campaigns'));
	}

	public function folders($page) {
		if($page == 'add') {
			$this->display('mailer/views/folders/add');
		}
		else {
			$this->display('mailer/views/campaigns');
		}
	}

	function folderAdd() {
		$folderName = filter_var($_POST['folderName'], FILTER_SANITIZE_STRING);
		if($folderName != '') {
			$settings = Plugin::getAllSettings('mailer');
			$api = new MCAPI($settings['apikey']);
			$add = $api->createFolder($folderName);
			Flash::set('success', __(''.$folderName.' has been added to your folders'));
			redirect(get_url('plugin/mailer/folders'));
		}
		else {
			Flash::set('error', __('You need to add a folder name'));
			redirect(get_url('plugin/mailer/campaigns'));
		}
	}


	function saveSettings() {
		global $__CMS_CONN__;
		$resets = array('showCampaigns','showLists','showGroups', 'showFolders', 'showSearch');
		foreach($resets as $reset) {
			$sql = "	UPDATE ".TABLE_PREFIX."plugin_settings
						SET	`value`='0'
						WHERE plugin_id='mailer' AND name='$reset'";
			$pdo = $__CMS_CONN__->prepare($sql);
			$pdo->execute();

		}
		foreach ($_POST as $key => $value) {
			if(($key == 'password') && ($value == '')) {
			} else {
				$sql = "	UPDATE ".TABLE_PREFIX."plugin_settings
							SET	`value`='$value'
							WHERE plugin_id='mailer' AND name='$key'";
				$pdo = $__CMS_CONN__->prepare($sql);
				$pdo->execute();
			}
		}
		Flash::set('success', __('Mailer settings have been saved'));
		redirect(get_url('plugin/mailer/settings'));
	}

	public function updateConfiguredSetting($flag) {
		global $__CMS_CONN__;
		$sql = "	UPDATE ".TABLE_PREFIX."plugin_settings
					SET	`value`='$flag'
					WHERE plugin_id='mailer' AND name='configured'";
		$pdo = $__CMS_CONN__->prepare($sql);
		$pdo->execute();
	}

	public function lists() {
		$this->display('mailer/views/lists/index');
	}

	public function viewlist($id) {
		$this->display('mailer/views/lists/view', array('id'=>$id));
	}

	public function members($page) {
		if($page == 'unsubscribe') {
			$settings = Plugin::getAllSettings('mailer');
			$api = new MCAPI($settings['apikey']);
			$add = $api->listUnsubscribe($_GET['listid'], $_GET['email']);
			Flash::set('success', __(''.$_GET['email'].' has been unsubscribed'));
			if($_GET['ref'] == 'members') {
				redirect(get_url('plugin/mailer/members'));
			}
			elseif($_GET['name'] != '') {
				redirect(get_url('plugin/mailer/groups/view?name='.$_GET['name'].'&list='.$_GET['listid'].''));
			}
			elseif($_GET['list'] != '') {
				redirect(get_url('plugin/mailer/viewlist/'.$_GET['list']));
			}
		}
		elseif($page == 'add') {
			$this->display('mailer/views/members/add');
		}
		elseif($page == 'edit') {
			$this->display('mailer/views/members/edit');
		}
		else {
			$this->display('mailer/views/members/index');
		}
	}

	function memberAdd() {
		$firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_STRING);
		$lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_STRING);
		$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
		$listid = $_POST['listid'];
		$groups = $_POST['group'];
		if($_POST['optin'] == '')	{ $optin = 'false'; } else { $optin = 'true'; }
		if($_POST['welcome'] == '')	{ $welcome = 'false'; } else { $welcome = 'true'; }
		$count = count($groups);
		$i = 1;
		$groupdetails = '';
		foreach($groups as $group) {
			$groupdetails .= $group;
			if($i != $count) {
				$groupdetails .= ', ';
			}
			$i = $i + 1;
		}
		if($email == '') {
			Flash::set('error', __('You must add an email address'));
			redirect(get_url('plugin/mailer/members/add'));		
		}
		else {
			$merge_vars = array('FNAME'=>$firstname, 'LNAME'=>$lastname, 'INTERESTS'=>$groupdetails);
			$settings = Plugin::getAllSettings('mailer');
			$api = new MCAPI($settings['apikey']);
			$add = $api->listSubscribe($listid, $email, $merge_vars, $_POST['prefs'], $optin, $_POST['update'], $_POST['replace'], $welcome);
			if ($firstname != '') {
				Flash::set('success', __(''.$firstname.' '.$lastname.' has been added to the lists'));
				redirect(get_url('plugin/mailer'));
			}
			else {
				Flash::set('success', __(''.$email.' has been added to the list'));
				redirect(get_url('plugin/mailer/members'));
			}
		}
	}

	function memberUpdate() {
		$firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_STRING);
		$lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_STRING);
		$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
		$listid = $_POST['listid'];
		$groups = $_POST['group'];
		$count = count($groups);
		$i = 1;
		$groupdetails = '';
		foreach($groups as $group) {
			$groupdetails .= $group;
			if($i != $count) {
				$groupdetails .= ', ';
			}
			$i = $i + 1;
		}
		if($email == '') {
			Flash::set('error', __('You must add an email address'));
			redirect(get_url('plugin/mailer/members/add'));
		}
		else {
			$merge_vars = array('FNAME'=>$firstname, 'LNAME'=>$lastname, 'INTERESTS'=>$groupdetails);
			$settings = Plugin::getAllSettings('mailer');
			$api = new MCAPI($settings['apikey']);
			$add = $api->listUpdateMember($listid, $email, $merge_vars, $_POST['prefs'], true);
			if ($firstname != '') {
				Flash::set('success', __(''.$firstname.' '.$lastname.' has been updated'));
				redirect(get_url('plugin/mailer/members'));
			}
			else {
				Flash::set('success', __(''.$email.' has been updated'));
				redirect(get_url('plugin/mailer/members'));
			}
		}
	}

	public function groups($page) {
		if($page == 'add') {
			$this->display('mailer/views/groups/add');
		}
		elseif($page == 'update') {
			$this->display('mailer/views/groups/update');
		}
		elseif($page == 'view') {
			$this->display('mailer/views/groups/view');
		}
		else {
			$this->display('mailer/views/groups/index');		
		}
	}

	function groupAdd() {
		$listid = filter_var($_POST['listid'], FILTER_SANITIZE_STRING);
		$groupname = filter_var($_POST['groupname'], FILTER_SANITIZE_STRING);
		if($groupname != '') {
			$settings = Plugin::getAllSettings('mailer');
			$api = new MCAPI($settings['apikey']);
			$add = $api->listInterestGroupAdd($listid, $groupname);
			Flash::set('success', __(''.$groupname.' has been added to your groups'));
			redirect(get_url('plugin/mailer/groups'));
		}
		else {
			Flash::set('error', __('You need to add a group name'));
			redirect(get_url('plugin/mailer/groups/add'));
		}
	}

	function groupDelete($string) {
		$split = explode('---', $string);
		$groupname = $split['0'];
		$listid = $split['1'];
		$settings = Plugin::getAllSettings('mailer');
		$api = new MCAPI($settings['apikey']);
		$del = $api->listInterestGroupDel($listid, $groupname);
		Flash::set('success', __(''.$groupname.' has been deleted from your groups'));
		redirect(get_url('plugin/mailer/groups'));
	}

	function groupUpdate($string) {
		$listid = filter_var($_POST['listid'], FILTER_SANITIZE_STRING);
		$oldname = filter_var($_POST['oldname'], FILTER_SANITIZE_STRING);
		$newname = filter_var($_POST['groupname'], FILTER_SANITIZE_STRING);
		$settings = Plugin::getAllSettings('mailer');
		$api = new MCAPI($settings['apikey']);
		$del = $api->listInterestGroupUpdate($listid, $oldname, $newname);
		Flash::set('success', __(''.$oldname.' has been updated to '.$newname.''));
		redirect(get_url('plugin/mailer/groups'));
	}

	public function viewgroups($id) {
		$this->display('mailer/views/groups/view', array('id'=>$id));
	}

	public function documentation() {
		$this->display('mailer/views/documentation');
	}

}