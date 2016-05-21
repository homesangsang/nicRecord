<?php
/**
 * Created by PhpStorm.
 * User: catkint-pc
 * Date: 2016/5/19
 * Time: 19:50
 */
session_start();
//登录
if(empty($_POST['id'])){
    exit('非法访问');
}
$id = htmlspecialchars(trim($_POST['id']));
$password = sha1($_POST['password']);
include('../database/connectDB.php');//包含数据库连接文件
$check_sql = "select uid,username from users where uid='$id' and password='$password'";
$rs = $pdo->query($check_sql);
$rs->setFetchMode(PDO::FETCH_ASSOC);
$row = $rs->fetch();
if($id==$row['uid']){
    //登录成功
    $_SESSION['uid'] = $row['uid'];
    $_SESSION['username'] = $row['username'];
    echo "<script>window.location='main.php'</script>";
//    echo $row['username'];

}else{
    echo "<script>alert('用户名或密码错，请重试');window.location='login.html';</script>";
}
