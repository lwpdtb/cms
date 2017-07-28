<?php
require_once '../config.php';
require_once 'conn.php';

//修改默认时区
date_default_timezone_set('PRC');

function CheckWeiboPurview($check){
	$purview = explode(' ', $_SESSION['dede_admin_purview']);
	if(in_array($check, $purview)||in_array('admin_AllowAll', $purview)||in_array('weibo_all', $purview)){
		return true;
	}else{
		return false;
	}
}

?>