<?php
session_start();
//检测是否登录，若没登录则转向登录页面
if(!isset($_SESSION['uid'])){
    header('Location:login.html');
    exit();
}
include('../database/connectDB.php');//包含数据库连接文件
$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
$query_sql = "select repair_id,build_name,room,repair_describe,username,repair_time,id from repair,build,users where repair.build_id=build.build_id and repair.user_id=users.uid ORDER BY id DESC";
$rs = $pdo->query($query_sql);
//$rs->setAttribute(PDO::FETCH_NUM);
$list = $rs->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>齐鲁工业大学网络信息中心 故障录入系统</title>

    <!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!--my css -->
    <link href="../dist/css/MyTable.css" rel="stylesheet"  type="text/css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html"><p class="yeheiFont"><img src="nicLogo.png" width="35px" style="margin-right: 5px"/>齐鲁工业大学网络信息中心</p></a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right col-xs-offset-8">

                <!-- /.dropdown -->
                <li class="dropdown ">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <em class="fa yaheiFont"><?php echo $username?></em> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="reset.html"><i class="fa fa-wrench fa-fw"></i>修改密码</a>
                        </li>

                        <li class="divider"></li>
                        <li><a href="login.html"><i class="fa fa-sign-out fa-fw"></i>注销</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input id="search_str" type="text" class="form-control" placeholder="搜索...">
                                <span class="input-group-btn">
                                <button onclick="search()"  class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="main.php"><i class="fa fa-dashboard fa-fw"></i>仪表盘</a>
                        </li>
                        <li><!--自定义菜单-->
                            <a href="#"><i class="fa fa-files-o fa-fw"></i>我的菜单<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="list.php">故障列表</a>
                                </li>
                                <li>
                                    <a href="add.php">提交故障</a>
                                </li>
                                <li>
                                    <a href="usermanager.php">人员管理</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h2 class="page-header yaheiFont" style="color: grey" >故障列表</h2>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                           <!-- <div class="panel-heading">
                                Kitchen Sink
                            </div> -->
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th width="50px">ID</th>
                                            <th>地点</th>
                                            <th>故障</th>
                                            <th width="70px">维修人</th>
                                            <th width="100px">时间</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            for($i=0;$i<count($list);$i++){
                                                echo "<tr onclick=\"openDetils({$list[$i][6]})\"><td>{$list[$i][0]}</td><td>{$list[$i][1]} {$list[$i][2]}</td><td>{$list[$i][3]}</td><td>{$list[$i][4]}</td><td>{$list[$i][5]}</td></tr>";
                                            }
                                        ?>
<!--                                        <tr onclick="openDetils()">-->
<!--                                            <td>2016XX051701</td>-->
<!--                                            <td>办公楼</td>-->
<!--                                            <td>连不上网</td>-->
<!--                                            <td>杨柳</td>-->
<!--                                            <td>2016-05-17</td>-->
<!--                                        </tr>-->
<!--                                        <tr>-->
<!--                                            <td>2016XX051702</td>-->
<!--                                            <td>文科楼</td>-->
<!--                                            <td>连不上网</td>-->
<!--                                            <td>杨柳</td>-->
<!--                                            <td>2016-05-17</td>-->
<!--                                        </tr>-->
<!--                                        <tr>-->
<!--                                            <td>2016XX051702</td>-->
<!--                                            <td>图书馆</td>-->
<!--                                            <td>连不上网</td>-->
<!--                                            <td>杨柳</td>-->
<!--                                            <td>2016-05-17</td>-->
<!--                                        </tr>-->
<!--                                        <tr>-->
<!--                                            <td>2016XX051701</td>-->
<!--                                            <td>办公楼</td>-->
<!--                                            <td>连不上网</td>-->
<!--                                            <td>杨柳</td>-->
<!--                                            <td>2016-05-17</td>-->
<!--                                        </tr>-->
<!--                                        <tr>-->
<!--                                            <td>2016XX051701</td>-->
<!--                                            <td>办公楼</td>-->
<!--                                            <td>连不上网</td>-->
<!--                                            <td>杨柳</td>-->
<!--                                            <td>2016-05-17</td>-->
<!--                                        </tr>-->
<!--                                        <tr>-->
<!--                                            <td>2016XX051701</td>-->
<!--                                            <td>办公楼</td>-->
<!--                                            <td>连不上网</td>-->
<!--                                            <td>杨柳</td>-->
<!--                                            <td>2016-05-17</td>-->
<!--                                        </tr>-->
<!--                                        <tr>-->
<!--                                            <td>2016XX051701</td>-->
<!--                                            <td>办公楼</td>-->
<!--                                            <td>连不上网</td>-->
<!--                                            <td>杨柳</td>-->
<!--                                            <td>2016-05-17</td>-->
<!--                                        </tr>-->
<!--                                        <tr>-->
<!--                                            <td>2016XX051701</td>-->
<!--                                            <td>办公楼</td>-->
<!--                                            <td>连不上网</td>-->
<!--                                            <td>杨柳</td>-->
<!--                                            <td>2016-05-17</td>-->
<!--                                        </tr>-->


                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>
                    <!-- /.col-lg-12 -->

                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    <!-- my table JavaScript -->
    <script src="../dist/js/Myfunction.js"></script>
</body>

</html>
