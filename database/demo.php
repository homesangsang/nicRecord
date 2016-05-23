<?php
/**
 * Created by PhpStorm.
 * User: catkint-pc
 * Date: 2016/5/19
 * Time: 16:32
 */
// $str = "%客户端%";
$pdo = new PDO("mysql:host=localhost;dbname=nicrecord","root","root",array(PDO::ATTR_PERSISTENT=>true));
$area_query_sql = "SELECT * FROM search WHERE content LIKE '%端%' ";
//echo $area_query_sql;
$rs = $pdo->query($area_query_sql);
//
$rs->setFetchMode(PDO::FETCH_NUM);
$row = $rs->fetch();
echo json_encode($row);
////$rs->setFetchMode(PDO::FETCH_NUM);
//
//
////echo "<script>alert('".$row[0][1]."')</script>";
////echo $row[0][2];
echo date('Y-m-d');

?>

