<?php
/**
 * Created by PhpStorm.
 * User: catkint-pc
 * Date: 2016/5/19
 * Time: 16:32
 */
 $str = "123456";
//echo md5(str)."<br/>";
$pdo = new PDO("mysql:host=localhost;dbname=nicrecord","root","root",array(PDO::ATTR_PERSISTENT=>true));
//$rs = $pdo->exec("UPDATE nicrecord.weekcount SET six = 2 WHERE weekcount.id = 0");
$area_query_sql = "select uid,username,weight from users";
//$temp = "select * from weekcount";
$rs=$pdo->query($area_query_sql);
//$rs->setFetchMode(PDO::FETCH_NUM);
$row = $rs->fetchAll();
//$rs->setFetchMode(PDO::FETCH_NUM);
//$arr=array();
//$result=array();
//while($row = $rs->fetch()){
//    //echo ($row[0].$row[1]);
////    echo json_encode($row);
////    array_push($arr,$row);
//    echo $row[1];
//}


//$result['bao']=$arr;
//$row = $rs->fetchAll();
echo json_encode($row);
//echo sha1("123456");
//echo count($row);
//echo date("w");
//echo "<script>alert('".$row[0][1]."')</script>";
//echo $row[0][2];
?>

