<?php
session_start();
//检测是否登录，若没登录则转向登录页面
if(!isset($_SESSION['uid'])){
    header('Location:login.php');
    exit();
}
include('../database/connectDB.php');//包含数据库连接文件
$userid = $_SESSION['uid'];
$username = $_SESSION['username'];
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
                        <i class="fa fa-user fa-fw"></i> <em class="fa yaheiFont"><?php echo $username?></em> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="reset.html"><i class="fa fa-wrench fa-fw"></i>修改密码</a>
                        </li>

                        <li class="divider"></li>
                        <li><a href="login.php"><i class="fa fa-sign-out fa-fw"></i>注销</a>
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
                                <li>
                                    <a href="addressBook.php">通讯录管理</a>
                                </li>

                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li><!--工具-->
                            <a href="#"><i class="fa  fa-wrench fa-fw"></i>工具<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="scanPortInput.php" target="_blank">端口扫描</a>
                                </li>
                                <li>
                                    <a href="machineRoom.php">弱电间分布</a>
                                </li>
                                <li>
                                    <a href="management.php">常用后台</a>
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
                        <h2 class="page-header yaheiFont" style="color: grey" >弱电间分布</h2>
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
                                            <th>ID</th>
                                            <th>楼宇</th>
                                            <th>地点</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <tr>
                                            <td>1</td>
                                            <td>图书馆</td>
                                            <td><a href="http://172.17.21.111:8080/sam/" target="_blank">http://172.17.21.111:8080/sam/</a></td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>办公楼</td>
                                            <td><a href="http://oa.qlu.edu.cn/" target="_blank">http://oa.qlu.edu.cn/</a></td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>机电楼</td>
                                            <td><a href="http://webplus.qlu.edu.cn/" target="_blank">http://webplus.qlu.edu.cn/</a></td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>文科楼</td>
                                            <td><a href="http://210.44.144.55/webadmin/" target="_blank">http://210.44.144.55/webadmin/</a></td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td>食工楼</td>
                                            <td><a href="http://210.44.144.205:8071/sso/login?service=http%3A%2F%2F210.44.144.205%3A8071%2Fj_spring_cas_security_check" target="_blank">http://210.44.144.205:8071/sso/login?service=http%3A%2F%2F210.44.144.205%3A8071%2Fj_spring_cas_security_check</a></td>
                                        </tr>
                                        <tr>
                                            <td>6</td>
                                            <td>一餐</td>
                                            <td><a href="http://210.44.144.205:8071/sso/login?service=http%3A%2F%2F210.44.144.205%3A8071%2Fj_spring_cas_security_check" target="_blank">http://210.44.144.205:8071/sso/login?service=http%3A%2F%2F210.44.144.205%3A8071%2Fj_spring_cas_security_check</a></td>
                                        </tr>
                                        <tr>
                                            <td>7</td>
                                            <td>三餐</td>
                                            <td><a href="http://210.44.144.205:8071/sso/login?service=http%3A%2F%2F210.44.144.205%3A8071%2Fj_spring_cas_security_check" target="_blank">http://210.44.144.205:8071/sso/login?service=http%3A%2F%2F210.44.144.205%3A8071%2Fj_spring_cas_security_check</a></td>
                                        </tr>
                                        <tr>
                                            <td>8</td>
                                            <td>工程训练中心</td>
                                            <td><a href="http://210.44.144.205:8071/sso/login?service=http%3A%2F%2F210.44.144.205%3A8071%2Fj_spring_cas_security_check" target="_blank">http://210.44.144.205:8071/sso/login?service=http%3A%2F%2F210.44.144.205%3A8071%2Fj_spring_cas_security_check</a></td>
                                        </tr>
                                        <tr>
                                            <td>9</td>
                                            <td>实验楼</td>
                                            <td><a href="http://210.44.144.205:8071/sso/login?service=http%3A%2F%2F210.44.144.205%3A8071%2Fj_spring_cas_security_check" target="_blank">http://210.44.144.205:8071/sso/login?service=http%3A%2F%2F210.44.144.205%3A8071%2Fj_spring_cas_security_check</a></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.panel-body -->
<!--                            <div class="panel panel-footer">-->
<!--                                <a href='javascript:void(0);' onclick='openAllpages()'" class="btn btn-primary ">一键打开所有页面</a>-->
<!--                            </div>-->
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
    <script src="../dist/js/admin_system.js"></script>
    <!-- my table JavaScript -->
    <script src="../dist/js/Myfunction.js"></script>
    <script>
        function openAllpages(){
            var arr = new Array("http://172.17.21.111:8080/sam/","http://oa.qlu.edu.cn/","http://webplus.qlu.edu.cn/","http://210.44.144.55/webadmin/","http://210.44.144.205:8071/sso/login?service=http%3A%2F%2F210.44.144.205%3A8071%2Fj_spring_cas_security_check")
            for(var i=0;i<arr.length;i++){
                window.open(arr[i]);
            }
        }
    </script>
</body>

</html>
