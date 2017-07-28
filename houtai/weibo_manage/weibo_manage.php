<?php

require_once 'init.php';
require_once 'page.class.php';

$action = isset($_REQUEST['act'])?$_REQUEST['act']:'list';

//微博已审核列表
if($action == 'list'){
	$page_per_num = 15;//每页数据条数
	$sql_total = "select * from weibo where status=1";
	$total = $db->query($sql_total)->rowCount();//所需显示条数
	$page = new Page($total,$page_per_num);
	$limit = $page->limit;
	$weibo = get_weibo_list($limit,1);
	if($total != 0){
		$html = $page->out_page(array(3,4,5,6,7,8));
	}
	require_once 'templets/weibo_list.html';
}

//微博审核列表
if($action == 'check_list'){
	$page_per_num = 15;//每页数据条数
	$sql_total = "select * from weibo where status=0";
	$total = $db->query($sql_total)->rowCount();//所需显示条数
	$page = new Page($total,$page_per_num);
	$limit = $page->limit;
	$weibo = get_weibo_list($limit,0);
	if($total != 0){
		$html = $page->out_page(array(3,4,5,6,7,8));
	}

	require_once 'templets/weibo_check_list.html';
}

//微博删除列表
if($action == 'del_list'){
	$page_per_num = 15;//每页数据条数
	$sql_total = "select * from weibo";
	$total = $db->query($sql_total)->rowCount();//所需显示条数
	$page = new Page($total,$page_per_num);
	$limit = $page->limit;
	$weibo = get_weibo_list($limit);
	if($total != 0){
		$html = $page->out_page(array(3,4,5,6,7,8));
	}
	require_once 'templets/weibo_del_list.html';
}



//设置精华问答
elseif($action == 'set_special'){
	if(CheckWeiboPurview('weibo_manage')){
		$id = $_REQUEST['id'];
		$special = $_REQUEST['special'];
		set_special($id,$special);
		header('Location:weibo_manage.php');
	}else{
		echo "没有权限";
	}
}

//微博审核
elseif ($action == 'weibo_check') {
	if(CheckWeiboPurview('weibo_check')){
		$id = $_REQUEST['id'];
		$status = $_REQUEST['status'];
		weibo_check($id,$status);
		header('Location:weibo_manage.php?act=check_list');
	}else{
		echo "没有权限";
	}
}

//获取评论
elseif($action == 'get_comment'){
	$id = $_REQUEST['id'];
	$comment = get_weibo_comment($id);
	if(empty($comment)){
		echo "暂无评论";
	}else{
		require_once 'templets/comment.html';
	}
}

//获取上传图片
elseif ($action == 'get_img') {
	$id = $_REQUEST['id'];
	$img = get_weibo_img($id);
	if(empty($img)){
		echo "暂无图片";
	}else{
		foreach ($img as $key) {
			echo "<img src='../../../weibo/images/".$key."'>";
		}
	}
	
}

//删除微博
elseif ($action == 'weibo_del') {
	if(CheckWeiboPurview('weibo_manage')){
		$id = $_REQUEST['id'];
		weibo_del($id);
		header('Location:weibo_manage.php?act=del_list');
	}else{
		echo "没有权限";
	}
}


function weibo_del($id){
	global $db;
	$sql = "delete from weibo where id = $id";
	$db->query($sql);
}

function weibo_check($id,$status){
	global $db;
	$sql = "update weibo set status=$status where id = $id";
	$db->query($sql);
}


function set_special($id,$special){
	global $db;
	$new_special = ($special+1)%2;
	$sql = "update weibo set special=$new_special where id = $id";
	$db->query($sql);
}


function get_weibo_list($limit,$status=null){
	global $db;
	$weibo = array();
	if($status === null){
		$sql = "select * from weibo order by time DESC $limit";
	}else{
		$sql = "select * from weibo where status=$status order by time DESC $limit";
	}
	$res = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
	foreach ($res as $key) {
		$key['time'] = date('Y-m-d H:i:s',$key['time']);
		$key['comment_num'] = count(get_weibo_comment($key['id']));
		$weibo[] =$key;
	}
	return $weibo;
}

function get_weibo_comment($weibo_id){
	global $db;
	$comment = array();
	$sql = "select c.user_name,c.detail,c.time,u.user_img from comment as c,users as u where c.detail_id=$weibo_id and u.user_id = c.user_id order by u.is_expert DESC,c.time DESC";
	$res = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
	foreach ($res as $key) {
		$key['time'] = date('Y-m-d H:i:s',$key['time']);
		$comment[] = $key;
	}
	return $comment;
}

function get_weibo_img($weibo_id){
	global $db;
	$img = array();
	$sql = "select url from images where detail_id=$weibo_id order by time DESC";
	$res = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
	foreach ($res as $key) {
		$img[] = $key['url'];
	}
	return $img;
}
?>