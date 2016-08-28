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
$area_query_sql = "select build_id,build_name from build";
$rs = $pdo->query($area_query_sql);
$rs->setFetchMode(PDO::FETCH_NUM);
$area_info = $rs->fetchAll();//获取建筑信息和建筑id
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
    <link href="../bower_components/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css" rel="stylesheet" type="text/css">
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
                            <a href="#"><i class="fa fa-files-o fa-fw"></i>工作菜单<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="list.php">故障列表</a>
                                </li>
                                <li>
                                    <a href="add.php">提交故障</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="usermanager.php"><i class="fa  fa-user fa-fw"></i>人员管理</a>
                        </li>
                        <li><!--工具-->
                            <a href="#"><i class="fa  fa-wrench fa-fw"></i>常用工具<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="scanPortInput.php" target="_blank">端口扫描</a>
                                </li>

                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="management.php"><i class="fa fa-shield fa-fw"></i>常用后台</a>
                        </li>
                        <li>
                            <a href="machineRoom.php"><i class="fa fa-map-marker fa-fw"></i>弱电间分布</a>
                        </li>
                        <li>
                            <a href="markNote.php" target="_blank"><i class="fa fa-pencil fa-fw"></i>在线云笔记</a>
                        </li>
                        <li>
                            <a href="addressBook.php"><i class="fa fa-th-list fa-fw"></i>网络中心通讯录</a>
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
                        <h2 class="page-header yaheiFont" style="color: grey" >提交故障</h2>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                请填写以下内容
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <form role="form" name="addForm" method="post" action="action.php?action=addRepair" onsubmit="return InputCheck(this)">
                                            <div class="form-group">
                                                <label>请选择时间</label>
                                                <input name="time" type="text" class="form-control" value="<?php echo date('Y-m-d') ?>" id="datetimepicker">

                                            </div>
                                            <div class="form-group">
                                                <label >请选择地点</label>
                                                <select id="build" name="build" class="form-control">
                                                    <?php
                                                        for($i=0;$i<11;$i++){
                                                            echo "<option value=\"{$area_info[$i][0]}\">{$area_info[$i][1]}</option>";
                                                        }

                                                    ?>
                                                </select>
                                            </div>
                                            <div  class="form-group">
                                                <label>房间号</label>
                                                <input id="room" name="room" class="form-control" >
                                            </div>
                                            <div class="form-group">
                                                <label>故障描述</label>
                                                <textarea id="describe" name="describe" class="form-control" rows="3"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>故障原因</label>
                                                <textarea id="cause"  name="cause" class="form-control" rows="3"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>解决方法</label>
                                                <textarea id="solution" name="solution" class="form-control" rows="3"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>心得</label>
                                                <textarea id="note" name="note" class="form-control" rows="3"></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary ">提交</button>
                                            <button type="reset" class="btn btn-warning">重置</button>
                                        </form>
                                    </div>
                                    <!-- /.col-lg-6 (nested) -->
                                </div>
                            </div>
                            <!--/.panel-body-->
                        </div>
                    </div>
                    <!--/.col-lg-12-->
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
    <!-- bootstrap-datetimepicker JavaScript -->
    <script src="../bower_components/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
    <script src="../bower_components/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js"></script>
    <!-- my table JavaScript -->
    <script src="../dist/js/Myfunction.js"></script>
    <script>
        $('#datetimepicker').datetimepicker();
    </script>
    <script type="text/javascript">

        $("#datetimepicker").datetimepicker({
            format:'yyyy-mm-dd',
            language:'zh-CN',
            autoclose:true,
            todayHighlight:true,
            minView:2
        });
        function InputCheck(addForm){
            if(addForm.room.value==""){
                alert("请输入房间号");
                return (false);
            }
            if(addForm.describe.value==""){
                alert("请输入故障描述");
                return (false);
            }
        }
        //alert($("#datetimepicker").val()); //获取已经选择的时间的值
    </script>
</body>

</html>
