<?php

require_once 'init.php';
require_once 'page.class.php';

$action = isset($_REQUEST['act'])?$_REQUEST['act']:'list';

if($action == 'list'){
	$where = 'where 1';
	if(!empty($_POST)){
		$_SESSION['user_rank'] = $_POST['user_rank'];
		$_SESSION['name'] = $_POST['name'];
	}
	if($_SESSION['user_rank']!=0){
		$where = $where." and is_expert=".($_SESSION['user_rank']-1);
	}
	$where .= " and user_name like '%$_SESSION[name]%'";
	$page_per_num = 15;//每页数据条数
	$sql_total = "select * from users $where";
	$total = $db->query($sql_total)->rowCount();//所需显示条数
	$page = new Page($total,$page_per_num);
	$limit = $page->limit;
	$sql = "select user_id,user_name,mobile,user_img,is_expert from users $where $limit";
	$user = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
	if($total != 0){
		$html = $page->out_page(array(3,4,5,6,7,8));
	}
	require_once 'templets/weibo_user.html';
}

elseif($action == 'user_change'){
	if(CheckWeiboPurview('weibo_user')){
		$id = $_REQUEST['id'];
		$status = $_REQUEST['status'];
		change_purview($id,$status);
		header('Location:user.php');
	}else{
		echo "没有权限";
	}
}

function change_purview($id,$status){
	global $db;
	$new_status = ($status+1)%2;
	$sql = "update users set is_expert=$new_status where user_id = $id";
	$db->query($sql);
}
?>