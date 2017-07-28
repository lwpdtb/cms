<?php

require_once 'conn.php';

$username = $_POST['username'];
$password = $_POST['password'];
$password = substr(md5($password), 5,20);

$response = array('status' => 'ok','code' =>'0');

if($username != ''){
	$sql = "select pwd,id from dede_admin where uname='$username'";
	$info = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
	if($info){
		$pwd = $info[0]['pwd'];
		$id = $info[0]['id'];
		if($password != $pwd){
			$response['status'] = 'error';
			$response['status'] = '3';
		}else{
			$_SESSION['admin_id'] = $id;
		}
	}else{
		$response['status'] = 'error';
		$response['status'] = '2';
	}
}else{
	$_SESSION['admin_id'] = 1;
	$response['status'] = 'error';
	$response['status'] = '1';
}

echo json_encode($response);
?>