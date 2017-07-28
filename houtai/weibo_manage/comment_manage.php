<?php

require_once 'init.php';
require_once 'page.class.php';

$action = isset($_REQUEST['act'])?$_REQUEST['act']:'list';

if($action == 'list'){
	$page_per_num = 15;//每页数据条数
	$sql_total = "select * from comment";
	$total = $db->query($sql_total)->rowCount();//所需显示条数
	$page = new Page($total,$page_per_num);
	$limit = $page->limit;
	$comment = get_weibo_list($limit);
	if($total != 0){
		$html = $page->out_page(array(3,4,5,6,7,8));
	}
	require_once 'templets/comment_list.html';
}

elseif($action == 'comment_del'){
	if(CheckWeiboPurview('weibo_comment')){
		$id = $_REQUEST['id'];
		comment_del($id);
		header('Location:comment_manage.php');
	}else{
		echo "没有权限";
	}
}

function comment_del($id){
	global $db;
	$sql = "delete from comment where id = $id";
	$db->query($sql);
}

function get_weibo_list($limit){
	global $db;
	$comment = array();
	$sql = "select * from comment $limit";
	$res = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
	foreach ($res as $key) {
		$key['time'] = date('Y-m-d H:i:s',$key['time']);
		$comment[] =$key;
	}
	return $comment;
}
?>