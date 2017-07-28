<?php

$dbms      = 'mysql';
$db_host   = 'localhost';
$db_name   = '9010cms';
$db_user   = 'root';
$db_pass   = '';
$dsn       = "$dbms:host=$db_host; dbname=$db_name";
 
try{
	//初始化一个PDO对象，就是创建了数据库连接对象 $db
    $db = new PDO($dsn, $db_user, $db_pass);
    $db->query('set names utf8;');
}catch(PDOException $e){
    die("Error!: ".$e->getMessage()."<br/>"); 
}

?>