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
if(empty($_POST['id']) && empty($_GET['action'])){
    exit('非法访问');
}
switch($_GET['action']){
    case 'login':
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
//    echo $row['username'];

        }else{
            echo "<script>alert('用户名或密码错，请重试');window.location='login.html';</script>";
        }
        break;
    case 'addRepair':
        $user_id = $_SESSION['uid'];
        $repair_time = time();
        $build_id = $_POST['build'];
        $repair_describe = $_POST['describe'];
        $room = $_POST['room'];
        $repair_cause = $_POST['cause'];
        $solution = $_POST['solution'];
        var_dump($_POST); //查看post中的所有数据
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
//      echo "<script>alert(".$week_arr[date("w")].");window.location='list.php'</script>";
        $update_time_sql = "UPDATE weekcount SET ".$week_arr[$date]." = ".$require_time_count[$date]." WHERE weekcount.id = 0";

        ////////////
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
            $pdo->commit();
            echo "<script>alert('提交成功');window.location='list.php'</script>";
        } catch (PDOException $e) {
            $pdo->rollback(); // 执行失败，事务回滚
//            exit($e->getMessage());
            echo "<script>alert('提交失败".$e->getMessage()."');window.location='list.php'</script>";
        }finally{
            $pdo->setAttribute(PDO::ATTR_AUTOCOMMIT, true);
        }

        ///////////


        break;
    case 'layout':
        unset($_SESSION['uid']);
        unset($_SESSION['username']);
        session_destroy();
        echo "<script>window.location='login.html'</script>";
        break;
    case 'reset':
        if(!isset($_SESSION['uid'])){
            header('Location:login.html');
            exit();
        }
        $oldpw = sha1($_POST['oldpw']);
        $newpw = sha1($_POST['newpw']);
        $user_id = $_SESSION['uid'];
        $query_pw_sql = "select password from users where uid={$user_id} ";
        $rsult = $pdo->query($query_pw_sql);
        $rsult->setFetchMode(PDO::FETCH_NUM);
//        $rs->setFetchMode(PDO::FETCH_ASSOC);
        $row = $rsult->fetch();
//        echo json_encode($row[0]);
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

    default:break;
}




