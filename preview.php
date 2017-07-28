<?php
/**
 * 获取推送的文章
 */

require_once 'conn.php';

$admin_id = isset($_SESSION['admin_id'])?$_SESSION['admin_id']:null;
$act = isset($_GET['act'])?$_GET['act']:'show';

if(empty($admin_id)){
	/**
	 * 未登录显示未审核
	 * @var [type]
	 */
	if($act == 'nolog'){
		$start = isset($_POST['start'])?$_POST['start']:0;
		$num = 10;
		$sql = "select t.id,t.title,t.arcrank,t.writer,t.litpic,t.pubdate,t.senddate,t.keywords,t.description from dede_archives as t,admin_preview as p where t.arcrank=-1 and t.id=p.article_id group by p.article_id order by p.time DESC limit $start,$num";
		$res = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		$article =array();
		foreach ($res as $key) {
			$key['pubdate'] = date('Y-m-d H:i:s',$key['pubdate']);
			$key['senddate'] = date('Y-m-d H:i:s',$key['senddate']);
			$article[] = $key;
		}
		echo json_encode($article);
	}else{
		$response['status'] = 'error';
		$response['code'] = 'nolog';
		echo json_encode($response);
		die;
	}
	
}


if($act == 'show'){
	$start = isset($_POST['start'])?$_POST['start']:0;
	$num = 10;
	$sql = "select t.id,t.title,t.arcrank,t.writer,t.litpic,t.pubdate,t.senddate,t.keywords,t.description from dede_archives as t,admin_preview as p where p.admin_id=$admin_id and t.id=p.article_id and t.arcrank<>-2 group by p.article_id order by p.time DESC limit $start,$num";
	$res = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
	$article =array();
	foreach ($res as $key) {
		$key['pubdate'] = date('Y-m-d H:i:s',$key['pubdate']);
		$key['senddate'] = date('Y-m-d H:i:s',$key['senddate']);
		$article[] = $key;
	}
	echo json_encode($article);
}

elseif($act == 'check'){
	$id = $_POST['id'];
	$status = isset($_POST['status'])?$_POST['status']:'-1';
	$sql = "update dede_archives set arcrank=$status where id=$id";
	$res = $pdo->exec($sql);
	if($res){
		echo "ok";
	}else{
		echo "error";
	}
}


?>