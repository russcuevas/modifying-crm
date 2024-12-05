<?php
require_once('../config.php');
Class Master extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	function capture_err(){
		if(!$this->conn->error)
			return false;
		else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
			return json_encode($resp);
			exit;
		}
	}
	function save_source(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!is_numeric($v))
					$v = $this->conn->real_escape_string($v);
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$this->conn->real_escape_string($v)}' ";
			}
		}
		if(empty($id)){
			$sql = "INSERT INTO `source_list` set {$data} ";
		}else{
			$sql = "UPDATE `source_list` set {$data} where id = '{$id}' ";
		}
		$check = $this->conn->query("SELECT * FROM `source_list` where `name` = '{$name}' ".(is_numeric($id) && $id > 0 ? " and id != '{$id}'" : "")." ")->num_rows;
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = ' Source Name already exists.';
			
		}else{
			$save = $this->conn->query($sql);
			if($save){
				$rid = !empty($id) ? $id : $this->conn->insert_id;
				$resp['id'] = $rid;
				$resp['status'] = 'success';
				if(empty($id))
					$resp['msg'] = " Source has successfully added.";
				else
					$resp['msg'] = " Source details has been updated successfully.";
			}else{
				$resp['status'] = 'failed';
				$resp['msg'] = "An error occured.";
				$resp['err'] = $this->conn->error."[{$sql}]";
			}
		}
		if($resp['status'] =='success')
			$this->settings->set_flashdata('success',$resp['msg']);
		return json_encode($resp);
	}
	function delete_source(){
		extract($_POST);
		$del = $this->conn->query("UPDATE `source_list` set delete_flag = 1 where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Source has been deleted successfully.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function save_lead(){
		if(empty($_POST['id'])){
			$prefix = date("Ym-");
			$code = sprintf("%'.05d",1);
			while(true){
				$check = $this->conn->query("SELECT * FROM `lead_list` where code = '{$prefix}{$code}'")->num_rows;
				if($check > 0){
					$code = sprintf("%'.05d",ceil($code) + 1);
				}else{
					break;
				}
			}
			$_POST['code'] = $prefix.$code;
			$_POST['user_id'] = $this->settings->userdata('id');
		}
		$lead_allowed_field = ['code', 'source_id', 'interested_in', 'remarks', 'assigned_to', 'user_id', 'status', 'in_opportunity', 'delete_flag', 'date_updated'];
		$client_allowed_field = ['lead_id', 'firstname', 'middlename', 'lastname', 'gender', 'dob', 'contact', 'email', 'address', 'other_info'];
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(in_array($k,$lead_allowed_field) && !is_array($_POST[$k])){
				if(!is_numeric($v))
					$v = $this->conn->real_escape_string($v);
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$this->conn->real_escape_string($v)}' ";
			}
		}
		if(empty($id)){
			$sql = "INSERT INTO `lead_list` set {$data} ";
		}else{
			$sql = "UPDATE `lead_list` set {$data} where id = '{$id}' ";
		}
		
		$save = $this->conn->query($sql);
		if($save){
			$lid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['id'] = $lid;
			
			$data = "";
			foreach($_POST as $k =>$v){
				if(in_array($k,$client_allowed_field) && !is_array($_POST[$k])){
					if(!is_numeric($v))
						$v = $this->conn->real_escape_string($v);
					if(!empty($data)) $data .=",";
					$data .= " `{$k}`='{$this->conn->real_escape_string($v)}' ";
				}
			}
			if(!empty($data)){
				if(empty($id)){
					$data .= ", `lead_id`='{$lid}' ";
					$sql2 = "INSERT INTO `client_list` set {$data}";
				}else{
					$sql2 = "UPDATE `client_list` set {$data} where `lead_id` = '{$lid}'";
				}
				$save2 = $this->conn->query($sql2);
				if($save2){
					$resp['status'] = 'success';
					if(empty($id))
						$resp['msg'] = " Lead has successfully added.";
					else
						$resp['msg'] = " Lead details has been updated successfully.";
				}else{
					$resp['error'] = $this->conn->error;
					$resp['sql'] = $sql2;
					$resp['status'] = 'failed';
					if(empty($id)){
						$resp['msg'] = " Lead Information has failed save.";
						$this->conn->query("DELETE FROM `lead_list` where id = '{$lid}'");
					}else{
						$resp['msg'] = " Lead Information has failed update.";
					}
				}
			}else{
				$resp['error'] = "Client Information is Empty.";
				$resp['status'] = 'failed';
				if(empty($id)){
					$resp['msg'] = " Lead Information has failed save.";
					$this->conn->query("DELETE FROM `lead_list` where id = '{$lid}'");
				}else{
					$resp['msg'] = " Lead Information has failed update.";
				}
			}
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = "An error occured.";
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		if($resp['status'] =='success')
			$this->settings->set_flashdata('success',$resp['msg']);
		return json_encode($resp);
	}
	function delete_lead(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `lead_list` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Lead has been deleted successfully.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function save_log(){
		if(empty($_POST['id'])){
			$_POST['user_id'] = $this->settings->userdata('id');
		}
		extract($_POST);
		$get_lead = $this->conn->query("SELECT * FROM `lead_list` where id = '{$lead_id}'");
		$lead_res = $get_lead->fetch_array();
		if(isset($lead_res['status'])){
			$status = $lead_res['status'] < 2 ? 2 : $lead_res['status'];
		}
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!is_numeric($v))
					$v = $this->conn->real_escape_string($v);
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$this->conn->real_escape_string($v)}' ";
			}
		}
		if(empty($id)){
			$sql = "INSERT INTO `log_list` set {$data} ";
		}else{
			$sql = "UPDATE `log_list` set {$data} where id = '{$id}' ";
		}
		$save = $this->conn->query($sql);
		if($save){
			$resp['status'] = 'success';
			if(empty($id))
				$resp['msg'] = " Log has successfully added.";
			else
				$resp['msg'] = " Log details has been updated successfully.";
			$this->conn->query("UPDATE `lead_list` set `status` = '{$status}' where id = '{$lead_id}' ");
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = "An error occured.";
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		if($resp['status'] =='success')
			$this->settings->set_flashdata('success',$resp['msg']);
		return json_encode($resp);
	}
	function delete_log(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `log_list` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Log has been deleted successfully.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function save_note(){
		if(empty($_POST['id'])){
			$_POST['user_id'] = $this->settings->userdata('id');
		}
		extract($_POST);
		$get_lead = $this->conn->query("SELECT * FROM `lead_list` where id = '{$lead_id}'");
		$lead_res = $get_lead->fetch_array();
		if(isset($lead_res['status'])){
			$status = $lead_res['status'] < 2 ? 2 : $lead_res['status'];
		}
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!is_numeric($v))
					$v = $this->conn->real_escape_string($v);
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$this->conn->real_escape_string($v)}' ";
			}
		}
		if(empty($id)){
			$sql = "INSERT INTO `note_list` set {$data} ";
		}else{
			$sql = "UPDATE `note_list` set {$data} where id = '{$id}' ";
		}
		$save = $this->conn->query($sql);
		if($save){
			$resp['status'] = 'success';
			if(empty($id))
				$resp['msg'] = " Note has successfully added.";
			else
				$resp['msg'] = " Note details has been updated successfully.";
			$this->conn->query("UPDATE `lead_list` set `status` = '{$status}' where id = '{$lead_id}' ");
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = "An error occured.";
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		if($resp['status'] =='success')
			$this->settings->set_flashdata('success',$resp['msg']);
		return json_encode($resp);
	}
	function delete_note(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `note_list` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Note has been deleted successfully.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function update_lead_status(){
		extract($_POST);
		$in_opportunity = $status == 6 || $in_opportunity == 1 ? 1 :0;
		$update = $this->conn->query("UPDATE `lead_list` set status = '{$status}', in_opportunity = '{$in_opportunity}' where id = '{$id}'");
		if($update){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Lead's Status has been updated successfully.");
			
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
}

$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'save_source':
		echo $Master->save_source();
	break;
	case 'delete_source':
		echo $Master->delete_source();
	break;
	case 'save_lead':
		echo $Master->save_lead();
	break;
	case 'delete_lead':
		echo $Master->delete_lead();
	break;
	case 'save_log':
		echo $Master->save_log();
	break;
	case 'delete_log':
		echo $Master->delete_log();
	break;
	case 'save_note':
		echo $Master->save_note();
	break;
	case 'delete_note':
		echo $Master->delete_note();
	break;
	case 'update_lead_status':
		echo $Master->update_lead_status();
	break;
	default:
		// echo $sysset->index();
		break;
}