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
$rs = $pdo->query("select * from weekcount");
$rs->setFetchMode(PDO::FETCH_NUM);
//$arr=array();
//$result=array();
//while($row = $rs->fetch()){
//    //echo ($row[0].$row[1]);
////    echo json_encode($row);
////    array_push($arr,$row);
//    echo $row[1];
//}


//$result['bao']=$arr;
$row = $rs->fetch();
//echo json_encode($row);
echo $row[0][2];
?>

