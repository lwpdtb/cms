<?php
/**
 * 数据库连接文件
 */

//设置默认时区
date_default_timezone_set('PRC');
session_start();

$dsn = "mysql:host=localhost;dbname=9010cms";
try{
	$pdo = new PDO($dsn,'root','');
	$pdo->query('set names utf8'); 
}catch(PDOException $e){
	var_dump($e->message());
	die;
}


?>