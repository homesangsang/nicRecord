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
//        var_dump($_POST); //查看post中的所有数据

        $note = $_POST['note'];
        $repair_id = date("Ymdhis",$repair_time);
        $repair_time = $_POST['time'];
        $repair_time = str_replace("-","",$repair_time);
        $add_sql = "INSERT INTO repair (repair_id, user_id, repair_time, build_id,room, repair_describe, repair_cause, solution, note) VALUES ('$repair_id', '$user_id', '$repair_time','$build_id','$room','$repair_describe', '$repair_cause', '$solution','$note')";
//        echo $add_sql;
        $area_sql = "select repair_count from buildcount where build_id=".$build_id;
        $rw = $pdo->exec($add_sql);
        if($rw>0){
            $require_area_pdo = $pdo->query($area_sql);
            $require_area_count = $require_area_pdo->fetch();
            $require_area_count[0]+=1;
            $update_area_sql = "UPDATE buildcount SET repair_count = '".$require_area_count[0]."' WHERE buildcount.build_id = ".$build_id;
            $rw = $pdo->exec($update_area_sql);
            if($rw>0){
                $time_sql = "select * from weekcount where id=0";
                $require_time_pdo = $pdo->query($time_sql);
                $require_time_count = $require_time_pdo->fetch();
                $require_time_count[date("w")]+=1;
                $week_arr = array(" ","one","two","three","four","five","six","seven");
//                echo "<script>alert(".$week_arr[date("w")].");window.location='list.php'</script>";
                $update_time_sql = "UPDATE weekcount SET ".$week_arr[date("w")]." = ".$require_time_count[date("w")]." WHERE id = 0";
                $rw = $pdo->exec($update_time_sql);
                if($rw>0){
                    echo "<script>alert('提交成功');window.location='list.php'</script>";
                }else{
                    echo "<script>alert('提交失败,请重试(update time count fail)');window.location='list.php'</script>";
                }

            }else{
                echo "<script>alert('提交失败,请重试(update area count fail)');window.history.back();</script>";
            }

        }else{
            echo "<script>alert('提交失败,请重试(insert repair fail)');window.history.back();</script>";
        }
//        echo "<script>alert({$_POST['']});</script>";
        break;
    case 'layout':
        unset($_SESSION['uid']);
        unset($_SESSION['username']);
        session_destroy();
        echo "<script>alert('注销成功');window.location='login.html'</script>";
        break;
    default:break;
}




