<?php
/**
 * Created by PhpStorm.
 * User: catkint-pc
 * Date: 2016/5/19
 * Time: 19:50
 */
session_start();
include('../database/connectDB.php');//包含数据库连接文件
//登录
if(empty($_POST['uid']) && empty($_GET['action'])){
    exit('非法访问');
}
switch($_GET['action']){
    case 'login':
        $trueVerification = strtoupper($_SESSION['verification']);
        $userVerification = strtoupper($_POST['verification']);
        if($userVerification==$trueVerification){
            $id = htmlspecialchars(trim($_POST['id']));
            $password = sha1($_POST['password']);

            $check_sql = "select uid,username from users where uid='$id' and password='$password'";
            $rs = $pdo->query($check_sql);
            $rs->setFetchMode(PDO::FETCH_ASSOC);
            $row = $rs->fetch();
            if($id==$row['uid']){
                //登录成功
                $_SESSION['uid'] = $row['uid'];
                $_SESSION['username'] = $row['username'];
                echo "<script>window.location='main.php'</script>";

            }else{
                echo "<script>alert('用户名或密码错,请重试');window.location='login.php?id={$id}';</script>";
            }
        }else{
            echo "<script>alert('验证码错误,请重试');window.location='login.php?id={$id}';</script>";
        }

        break;
    case 'addRepair':
        $user_id = $_SESSION['uid'];
        $username = $_SESSION['username'];
        $repair_time = time();
        $build_id = $_POST['build'];
        $repair_describe = $_POST['describe'];
        $room = $_POST['room'];
        $repair_cause = $_POST['cause'];
        $solution = $_POST['solution'];
        $note = $_POST['note'];
        $repair_id = date("Ymdhis",$repair_time);
        $repair_time = $_POST['time'];
        $repair_time = str_replace("-","",$repair_time);
        $add_sql = "INSERT INTO repair (repair_id, user_id, repair_time, build_id,room, repair_describe, repair_cause, solution, note) VALUES ('$repair_id', '$user_id', '$repair_time','$build_id','$room','$repair_describe', '$repair_cause', '$solution','$note')";
        $area_sql = "select repair_count from buildcount where build_id=".$build_id;

        $require_area_pdo = $pdo->query($area_sql);
        $require_area_count = $require_area_pdo->fetch();
        $require_area_count[0]+=1;
        $update_area_sql = "UPDATE buildcount SET repair_count = '".$require_area_count[0]."' WHERE buildcount.build_id = ".$build_id;

        $time_sql = "select * from weekcount where id=0";
        $require_time_pdo = $pdo->query($time_sql);
        $require_time_count = $require_time_pdo->fetch();
        $date =0;
        if(date("w")==0){
            $date = 7;
        }else {
            $date = date("w");
        }
        $require_time_count[$date]+=1;
        $week_arr = array(" ","one","two","three","four","five","six","seven");
        $update_time_sql = "UPDATE weekcount SET ".$week_arr[$date]." = ".$require_time_count[$date]." WHERE weekcount.id = 0";
        $search_content_str = $username.$room.$repair_cause.$repair_describe.$note.$solution;
        $add_search_content_sql = "insert into search (repair_id,content) VALUES ('{$repair_id}','{$search_content_str}')";
        $pdo->setAttribute(PDO::ATTR_AUTOCOMMIT, false);
        try {
            $pdo->beginTransaction(); // 开启一个事务
            $row = null;
            $row = $pdo->exec($add_sql); // 执行第一个 SQL
            if (!$row)
                throw new PDOException('add repair fail'); // 如出现异常提示信息或执行动作
            $row = $pdo->exec($update_area_sql); // 执行第二个 SQL
            if (!$row)
                throw new PDOException('update area fail');
            $row = $pdo->exec($update_time_sql); // 执行第三个 SQL
            if (!$row)
                throw new PDOException('update time fail');
            $row = $pdo->exec($add_search_content_sql); // 执行第四个 SQL
            if (!$row)
                throw new PDOException('insert search content fail');
            $pdo->commit();
            echo "<script>alert('提交成功');window.location='list.php'</script>";
        } catch (PDOException $e) {
            $pdo->rollback(); // 执行失败，事务回滚
//            exit($e->getMessage());
            echo "<script>alert('提交失败".$e->getMessage()."');window.location='list.php'</script>";
        }
        break;
    case 'layout':
        unset($_SESSION['uid']);
        unset($_SESSION['username']);
        session_destroy();
        echo "<script>window.location='login.php'</script>";
        break;
    case 'reset':
        if(!isset($_SESSION['uid'])){
            header('Location:login.php');
            exit();
        }
        $oldpw = sha1($_POST['oldpw']);
        $newpw = sha1($_POST['newpw']);
        $user_id = $_SESSION['uid'];
        $query_pw_sql = "select password from users where uid={$user_id} ";
        $rsult = $pdo->query($query_pw_sql);
        $rsult->setFetchMode(PDO::FETCH_NUM);
        $row = $rsult->fetch();
        if($row[0]==$oldpw){
            $update_pw_sql = "update users set password='{$newpw}' where users.uid={$user_id}";
            $rs=$pdo->exec($update_pw_sql);
            if($rs){
                echo "<script>alert('修改成功');window.location='main.php'</script>";
            }else{
                echo "<script>alert('修改失败 (update new pw fail)');window.location='reset.html'</script>";
            }
        }else{
            echo "<script>alert('旧密码输入错误');window.location='reset.html'</script>";
        }
        break;
    case 'fix':
        $user_id = $_POST['user_id'];
        $username = $_POST['username'];
        $update_userinfo_sql = "update users set username='{$username}' where uid={$user_id}";
        $rs = $pdo->exec($update_userinfo_sql);
        if($rs){
            echo "<script>alert('用户信息修改成功');window.location='usermanager.php'</script>";
        }else{
            echo "<script>alert('出错啦 (update username fail)');window.location='resetuserinfo.php?action=fix&userid={$user_id}&username={$username}'</script>";
        }
        break;
    case 'deleteuser':
        $user_id = $_GET['userid'];
        $deleteuser_sql = "delete from users where uid={$user_id}";
        $rs = $pdo->exec($deleteuser_sql);
        if($rs){
            echo "<script>window.location='usermanager.php'</script>";
        }else{
            echo "<script>alert('出错啦 (delete user fail)');window.location='usermanager.php'</script>";

        }
        break;
    case 'adduser':
        $user_id = $_POST['user_id'];
        $username = $_POST['username'];
        $password = sha1($_POST['password']);
        $adduser_sql  = "insert into users (uid,username,password,weight) VALUES ('{$user_id}','{$username}','{$password}','0')";
        $rs = $pdo->exec($adduser_sql);
        if($rs){
            echo "<script>alert('添加成功');window.location='usermanager.php'</script>";
        }else{
            echo "<script>alert('出错啦 (add user fail)');window.location='resetuserinfo.php?action=adduser'</script>";

        }
        break;
    case 'addAddress':
        $input_name = $_POST['input_name'];
        $sex = $_POST['sex'];
        $s_province = $_POST['s_province'];
        $s_city = $_POST['s_city'];
        $s_county = $_POST['s_county'];
        $input_place = $_POST['input_place'];
        $input_phone = $_POST['input_phone'];
        $input_qq = $_POST['input_qq'];
        $input_wechat = $_POST['input_wechat'];
        $input_company = $_POST['input_company'];
        $input_position = $_POST['input_position'];
        $input_place = $s_province.$s_city.$s_county.$input_place;
        $addAddress_sql = "insert into addressbook (name,sex,place,phone,qq,wechat,company,position) values('{$input_name}','{$sex}','{$input_place}','{$input_phone}','{$input_qq}','{$input_wechat}','{$input_company}','{$input_position}')";
        $rs = $pdo->exec($addAddress_sql);
        if($rs){

            echo "<script>alert('添加成功');window.location='addressBook.php'</script>";
        }else{
//            var_dump($rs);
            echo "<script>alert('出错啦 (add address fail)');window.location='resetAddress.php?action=addAddress'</script>";
        }

        break;
    case 'fixAddress':

        $input_uid = $_GET['id'];
        $input_name = $_POST['input_name'];
        $sex = $_POST['sex'];
        $input_place = $_POST['input_place'];
        $input_phone = $_POST['input_phone'];
        $input_qq = $_POST['input_qq'];
        $input_wechat = $_POST['input_wechat'];
        $input_company = $_POST['input_company'];
        $input_position = $_POST['input_position'];

        $fixAddress_sql = "update addressbook set name='{$input_name}',sex='{$sex}',place='{$input_place}',phone={$input_phone},qq={$input_qq},wechat='{$input_wechat}',company='{$input_company}',position='{$input_position}' WHERE uid={$input_uid}";
        $rs = $pdo->exec($fixAddress_sql);
        if($rs){

            echo "<script>alert('修改成功');window.location='addressBook.php'</script>";
        }else{
            echo "<script>alert('出错啦 (fix address fail)');window.location='resetAddress.php?action=addAddress'</script>";
        }
        break;
    case 'deleteAddress':
        $input_uid = $_GET['id'];
        $deleteAddress_sql = "delete from addressbook where uid={$input_uid}";
        $rs = $pdo->exec($deleteAddress_sql);
        if($rs){
            echo "<script>window.location='addressBook.php'</script>";
        }else{
            echo "<script>alert('出错啦 (delete user fail)');window.location='addressBook.php'</script>";

        }
        break;
    default:break;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
</html>



