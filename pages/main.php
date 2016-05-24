<?php
    session_start();
    //检测是否登录，若没登录则转向登录页面
    if(!isset($_SESSION['uid'])){
        header('Location:login.php');
        exit();
    }
    include('../database/connectDB.php');//包含数据库连接文件
    $userid = $_SESSION['userid'];
    $username = $_SESSION['username'];
    $repair_count_query_sql = "select count(1) from repair";
    $users_query_sql = "select count(1) from users";
    $area_query_sql = "select build_name,repair_count from build,buildcount where build.build_id=buildcount.build_id";
    $time_query_sql = "select * from weekcount";
//查询故障数
    $rs = $pdo->query($repair_count_query_sql);
    $rs->setFetchMode(PDO::FETCH_NUM);
    $row = $rs->fetch();
    $repair_count = $row[0];
//查询地点数
    $rs = $pdo->query($users_query_sql);
    $row = $rs->fetch();
    $users_count = $row[0];
//获取地区分布数据
    $rs = $pdo->query($area_query_sql);

    $area_count = $rs->fetchAll();
//获取时间分布数据
$rs = $pdo->query($time_query_sql);
$rs->setFetchMode(PDO::FETCH_NUM);
$time_count = $rs->fetch();
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
                <a class="navbar-brand" href="main.php"><p class="yeheiFont"><img src="nicLogo.png" width="35px" style="margin-right: 5px"/>齐鲁工业大学网络信息中心</p></a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right col-xs-offset-8">

                <!-- /.dropdown -->
                <li class="dropdown ">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <em class="fa yaheiFont"><?php echo($username)?></em> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="reset.html"><i class="fa fa-wrench fa-fw"></i>修改密码</a>
                        </li>

                        <li class="divider"></li>
                        <li><a href="action.php?action=layout"><i class="fa fa-sign-out fa-fw"></i>注销</a>
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
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header" style="font-family: Microsoft YaHei ; color: grey">仪表盘</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo ($repair_count)?></div>
                                    <div>故障数</div>
                                </div>
                            </div>
                        </div>
                        <a href="list.php">
                            <div class="panel-footer">
                                <span class="pull-left">查看详情</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-plus fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge yaheiFont">提交</div>
                                    <div>故障登记</div>
                                </div>
                            </div>
                        </div>
                        <a href="add.php">
                            <div class="panel-footer">
                                <span class="pull-left">点击提交</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-user fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo ($users_count)?></div>
                                    <div>人员</div>
                                </div>
                            </div>
                        </div>
                        <a href="usermanager.php">
                            <div class="panel-footer">
                                <span class="pull-left">管理</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>

            </div>
            <!-- /.row -->
            <div class="row"><!-- Charts Begin-->

                <div class="col-lg-6 hidden-xs">
                    <div class="panel panel-default">
                        <div class="panel-heading yaheiFont">
                            地区分布
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <canvas id="areaChart" width="490px" height="300px"></canvas>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
                <div class="col-lg-6 hidden-xs">
                    <div class="panel panel-default">
                        <div class="panel-heading yeheiFont">
                            时间分布
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <canvas id="timeChart" width="490px" height="300px" ></canvas>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
            </div>
            <!-- /.row -->
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
    <script src="../dist/js/admin_system.js"></script>
    <!-- my table JavaScript -->
    <script src="../dist/js/Myfunction.js"></script>
    <!-- Charts JavaScript -->
    <script src="../bower_components/chart/Chart.js"></script>
    <script>

        function initAreaChart(){
            var data = {
                labels : [<?php  //循环遍历输出地区名称
                for($i = 0;$i<count($area_count);$i++){
                       echo "\"".$area_count[$i][0]."\",";
//                       echo "<script>alert('".$area_count[$i][1]."')</script>";
                }
               ?>
                    ],
                datasets : [
                    {
                        fillColor : "#66CCCC",
                        strokeColor : "#66FF66",
                        pointColor : "#669966",
                        pointStrokeColor : "#fff",
                        data : [<?php  //循环遍历输出地区故障数
                        for($i = 0;$i<count($area_count);$i++){
                               echo "{$area_count[$i][1]},";
                        }
                       ?>]
                    }
                ]
            };
            var options = {
                responsive:true,
            };
            var area = document.getElementById("areaChart").getContext("2d");

            var areaChart = new Chart(area).Line(data,{
                responsive:true,
            });
        }
        function initTimeChart(){
            var data = {
                labels : ["周一","周二","周三","周四","周五","周六","周天"],
                datasets : [
                    {
                        fillColor : "#9999FF",
                        strokeColor : "#fff",
                        data : [<?php  //循环遍历输出时间分布数据
                        for($i = 1;$i<8;$i++){
                               echo "{$time_count[$i]},";
//                               echo "<script>alert('".$time_count[$i]."')</script>";
                        }
//                                echo "{$time_count[1]},{$time_count[2]},{$time_count[3]},{$time_count[4]},{$time_count[5]},{$time_count[6]},{$time_count[7]}";
                       ?>]
                    }
                ]
            };
            var options = {
                responsive:true,
            }
            var time = document.getElementById("timeChart").getContext("2d");
            var timeChart = new Chart(time).Bar(data,{
                responsive:true,
            });
        }

        initAreaChart();
        initTimeChart();

    </script>
</body>

</html>
