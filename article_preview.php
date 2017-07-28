<?php
/**
 * 文章预览
 */
require_once('conn.php');
require_once('message_send.class.php');

$act = isset($_GET['act'])?$_GET['act']:'getAdmin';


if($act == 'getAdmin'){
	$user = getAdmin($pdo);
	$res = array();
	foreach ($user as $key) {
		$tmp['id'] = $key['id'];
		$tmp['uname'] = $key['uname'];
		$res[] = $tmp;
	}
	echo json_encode($res);
}

elseif($act == 'sendMessage'){
	$article_id = isset($_POST['article_id'])?$_POST['article_id']:0;
	$id = isset($_POST['id'])?$_POST['id']:'';
	$admin_id = explode(',', $id);
	$msg = array('status' => 'ok','code' => '0');
	if(count($admin_id)){
		foreach ($admin_id as $key => $value) {
			$time = time();
			$sql = "insert into admin_preview(admin_id,article_id,time)values($value,$article_id,$time)";
			$result = $pdo->exec($sql);
			if($result != 1){
				$msg['status'] = 'error';
				$msg['code'] = '1';
				break;
			}
			//调取短信类
			$user = getAdmin($pdo,$value);
			$message = new MessageSend('cf_zhuohao','lll123456');
			$res = $message->send('您的问题已通过审核。',$user[0]['mobile']);
			if($res['SubmitResult']['code'] != 2){
				$msg['status'] = 'error';
				$msg['code'] = '2';
				break;
			}
		}	
	}else{
		$msg['status'] = 'error';
		$msg['code'] = '3';
	}

	echo json_encode($msg);

}

/**
 * 获取后台管理员信息
 * @param  [type] $pdo    [数据库连接pdo对象]
 * @param  [type] $userid [后台管理员id，若不传参则查找所有]
 * @return [type]         [description]
 */
function getAdmin($pdo,$id=null){
	$response = false;
	$where = '';
	if($id != null){
		$where .= " where id=$id";
	}
	$sql = 'select * from dede_admin'.$where;
	$res = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
	if($res){
		$response = $res;
	}

	return $response;
}

?>

