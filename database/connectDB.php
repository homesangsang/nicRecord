<?php
/**
 * Created by PhpStorm.
 * User: catkint-pc
 * Date: 2016/5/19
 * Time: 17:20
 */
try{
    $pdo = new PDO("mysql:host=localhost;dbname=nicrecord","root","root",array(PDO::ATTR_PERSISTENT=>true));
    $pdo->query("set names 'utf8'");
}catch(PDOException $e){
    die("数据库连接失败".$e->getMessage());
}


?>