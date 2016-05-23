
///**
// * Created by PhpStorm.
// * User: catkint-pc
// * Date: 2016/5/19
// * Time: 16:32
// */
////// $str = "%客户端%";
////$pdo = new PDO("mysql:host=localhost;dbname=nicrecord","root","root",array(PDO::ATTR_PERSISTENT=>true));
////$area_query_sql = "SELECT * FROM search WHERE content LIKE '%端%' ";
//////echo $area_query_sql;
////$rs = $pdo->query($area_query_sql);
//////
////$rs->setFetchMode(PDO::FETCH_NUM);
////$row = $rs->fetch();
////echo json_encode($row);
////////$rs->setFetchMode(PDO::FETCH_NUM);
//////
//////
////////echo "<script>alert('".$row[0][1]."')</script>";
////////echo $row[0][2];
////echo date('Y-m-d');
//session_start ();
//header ( 'Content-type: image/png' );
////创建图片
//$im = imagecreate($x=130,$y=45 );
//$bg = imagecolorallocate($im,rand(50,200),rand(0,155),rand(0,155)); //第一次对 imagecolorallocate() 的调用会给基于调色板的图像填充背景色
//$fontColor = imageColorAllocate ( $im, 255, 255, 255 );   //字体颜色
//$fontstyle = 'rock.ttf';                   //字体样式，这个可以从c:\windows\Fonts\文件夹下找到，我把它放到和authcode.php文件同一个目录，这里可以替换其他的字体样式
////产生随机字符
//for($i = 0; $i < 4; $i ++) {
//    $randAsciiNumArray         = array (rand(48,57),rand(65,90));
//    $randAsciiNum                 = $randAsciiNumArray [rand ( 0, 1 )];
//    $randStr                         = chr ( $randAsciiNum );
//    imagettftext($im,30,rand(0,20)-rand(0,25),5+$i*30,rand(30,35),$fontColor,$fontstyle,$randStr);
//    $authcode                        .= $randStr;
//}
//$_SESSION['authcode']        = $randFourStr;//用户和用户输入的验证码做比较
////干扰线
//for ($i=0;$i<8;$i++){
//    $lineColor        = imagecolorallocate($im,rand(0,255),rand(0,255),rand(0,255));
//    imageline ($im,rand(0,$x),0,rand(0,$x),$y,$lineColor);
//}
////干扰点
//for ($i=0;$i<250;$i++){
//    imagesetpixel($im,rand(0,$x),rand(0,$y),$fontColor);
//}
//imagepng($im);
//imagedestroy($im);
//
//?>

<?php
/**
 * vCode(m,n,x,y) m个数字  显示大小为n   边宽x   边高y
 * http://blog.qita.in
 * 自己改写记录session $code
 */
session_start();
vCode(4, 15); //4个数字，显示大小为15

function vCode($num = 4, $size = 20, $width = 0, $height = 0) {
    !$width && $width = $num * $size * 4 / 5 + 5;
    !$height && $height = $size + 10;
    // 去掉了 0 1 O l 等
    $str = "23456789abcdefghijkmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVW";
    $code = '';
    for ($i = 0; $i < $num; $i++) {
        $code .= $str[mt_rand(0, strlen($str)-1)];
    }
    // 画图像
    $im = imagecreatetruecolor($width, $height);
    // 定义要用到的颜色
    $back_color = imagecolorallocate($im, 235, 236, 237);
    $boer_color = imagecolorallocate($im, 118, 151, 199);
    $text_color = imagecolorallocate($im, mt_rand(0, 200), mt_rand(0, 120), mt_rand(0, 120));
    // 画背景
    imagefilledrectangle($im, 0, 0, $width, $height, $back_color);
    // 画边框
    imagerectangle($im, 0, 0, $width-1, $height-1, $boer_color);
    // 画干扰线
    for($i = 0;$i < 5;$i++) {
        $font_color = imagecolorallocate($im, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
        imagearc($im, mt_rand(- $width, $width), mt_rand(- $height, $height), mt_rand(30, $width * 2), mt_rand(20, $height * 2), mt_rand(0, 360), mt_rand(0, 360), $font_color);
    }
    // 画干扰点
    for($i = 0;$i < 50;$i++) {
        $font_color = imagecolorallocate($im, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
        imagesetpixel($im, mt_rand(0, $width), mt_rand(0, $height), $font_color);
    }
    // 画验证码
    @imagefttext($im, $size , 0, 5, $size + 3, $text_color, 'c:\\WINDOWS\\Fonts\\simsun.ttc', $code);
    $_SESSION["VerifyCode"]=$code;
    header("Cache-Control: max-age=1, s-maxage=1, no-cache, must-revalidate");
    header("Content-type: image/png;charset=gb2312");
    imagepng($im);
    imagedestroy($im);
}

?>