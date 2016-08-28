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
                                            <td>-1F：图书馆西面，地下室入口附近<br/>
                                                1F ：B区系电梯相邻<br/>
                                                2F ：B区西北，西北侧电梯北邻<br/>
                                                3F ：同上<br/>
                                                4F ：同上<br/>
                                                5F ：同上<br/>
                                                6F ：B区西北面楼梯内<br/>
                                                7F ：同上<br/>
                                                特征：弱电间门上除了一楼和负一楼，全部都有“弱电间”牌子<br/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>办公楼</td>
                                            <td>1F:东南角<br/>
                                                2F:东南，228对面<br/>
                                                3F:东南，326对面；西北<br/>
                                                4F:东南，424斜对面；西北，427对面<br/>
                                                5F:526斜对面，台球桌旁边；西北540西邻<br/>
                                                特征，全部贴有：机房重地，闲人免进  字样，弱电间和强电间相邻。3-5楼在西北方向的弱电间是一个门，进去有二个房间，其中分别有弱电间和强电间

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>机电楼</td>
                                            <td>机电楼AB：（从西侧进入）沿每层东西方向走廊向东走，第一个路口处右转，弱电间在东面的墙上<br/>
                                                机电楼C：（从西侧进入）沿每层东西方向走廊向东走，直至东侧机电楼东侧楼梯，弱电间在南面的墙上</td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>文科楼</td>
                                            <td>弱电间靠近南北两侧楼梯，各一个，位于东面的走廊</td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td>食工楼</td>
                                            <td>每层都有弱电间，有的两层在一块（钥匙上的标签贴的很清楚），钥匙在B座大厅大爷那，每层弱电间在楼梯口附近一个浅黄色的门<br/>A座门向北<br/>
                                                BC座门向南，一楼中间走廊弱电间是整座食工楼网络总入口</td>
                                        </tr>
                                        <tr>
                                            <td>6</td>
                                            <td>轻化楼</td>
                                            <td><p>A</p>	1F	101对面<br/>
                                                2F	201对面<br/>
                                                3F	301对面<br/>
                                                4F	401对面<br/>
                                                5F	501对面<br/>
                                               <p>B</p>	1F	南北向走廊，最北面，东边墙上<br/>
                                                2F	南北向走廊，最北面，东边墙上<br/>
                                                3F	南北向走廊，最北面，东边墙上<br/>
                                                4F	南北向走廊，最北面，东边墙上<br/>
                                                5F	南北向走廊，最北面，东边墙上<br/>
                                                <p>C</p>	1F	101对面<br/>
                                                2F	203对面<br/>
                                                3F	303对面<br/>
                                                4F	“泰山学者教授”牌子西侧<br/>
                                                5F	503对面<br/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>6</td>
                                            <td>一餐</td>
                                            <td>南面墙，小顽酷水果吧牌子西侧小门，钥匙在保卫处张科长那，或联系老师</td>
                                        </tr>
                                        <tr>
                                            <td>7</td>
                                            <td>三餐</td>
                                            <td>从北面墙进去，二楼215</td>
                                        </tr>
                                        <tr>
                                            <td>8</td>
                                            <td>工程训练中心</td>
                                            <td>1F 酒博物馆玻璃门里面<img src="../dist/image/machineRoom01.jpg" width="150px"/><br/>
                                                2F 楼梯拐角处
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>9</td>
                                            <td>后勤楼</td>
                                            <td>上下两层，只有一个弱电间，在一楼中间，楼梯下面，有个不到1米5高的小门，两个交换机都在里面</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                            </div>

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
