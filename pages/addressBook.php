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
$query_sql = "select * from addressbook";
$rs = $pdo->query($query_sql);
$list = $rs->fetchAll();//所有通讯录信息
$user_weight_sql = "select weight from users where uid='{$userid}'";//查询当前用户的权重
$rs = $pdo->query($user_weight_sql);
$user_weight = $rs->fetch();
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
                        <h2 class="page-header yaheiFont" style="color: grey" >网络中心通讯录</h2>
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
                                            <th>姓名</th>
                                            <th>性别</th>
                                            <th>居住地</th>
                                            <th>手机号</th>
                                            <th>QQ</th>
                                            <th>微信</th>
                                            <th>工作单位</th>
                                            <th>职务</th>
                                            <th width="50px">选项</th>
                                            <th width="50px">  </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $isM = true;
                                            $isW = false;
                                            if($user_weight[0]=='1'){
                                                for($i=0;$i<count($list);$i++){
                                                    if($list[$i][2]=='女'){
                                                        $isM = false;
                                                        $isW = true;
                                                    }
                                                    echo "<tr><td>{$list[$i][0]}</td><td>{$list[$i][1]}</td><td>{$list[$i][2]}</td><td>{$list[$i][3]}</td><td>{$list[$i][4]}</td><td>{$list[$i][5]}</td><td>{$list[$i][6]}</td><td>{$list[$i][7]}</td><td>{$list[$i][8]}</td><td><a href='resetAddress.php?action=fixAddress&id={$list[$i][0]}&name={$list[$i][1]}&isM={$isM}&isW={$isW}&place={$list[$i][3]}&phone={$list[$i][4]}&qq={$list[$i][5]}&wechat={$list[$i][6]}&company={$list[$i][7]}&position={$list[$i][8]}'>修改</a></td><td><a href='action.php?action=deleteAddress&id={$list[$i][0]}'>删除</a></td></tr>";
                                                }
                                            }else{
                                                for($i=0;$i<count($list);$i++){
                                                    if($list[$i][2]=='女'){
                                                        $isM = false;
                                                        $isW = true;
                                                    }
                                                    echo "<tr><td>{$list[$i][0]}</td><td>{$list[$i][1]}</td><td>{$list[$i][2]}</td><td>{$list[$i][3]}</td><td>{$list[$i][4]}</td><td>{$list[$i][5]}</td><td>{$list[$i][6]}</td><td>{$list[$i][7]}</td><td>{$list[$i][8]}</td><td><a href='javascript:void(0);' onclick='alertError()'>修改</a></td><td><a href='javascript:void(0);' onclick='alertError()'>删除</a></td></tr>";
                                                }
                                            }

//                                        ?>
<!--                                        <tr>-->
<!--                                            <td>02</td>-->
<!--                                            <td>高阳</td>-->
<!--                                            <td>男</td>-->
<!--                                            <td>山东省济南市长清区齐鲁工业大学</td>-->
<!--                                            <td>11111111111</td>-->
<!--                                            <td>111111111</td>-->
<!--                                            <td>wechatss</td>-->
<!--                                            <td>齐鲁工业大学</td>-->
<!--                                            <td>学生</td>-->
<!--                                            <td>修改</td>-->
<!--                                            <td>删除</td>-->
<!---->
<!--                                        </tr>-->
<!--                                        <tr>-->
<!--                                            <td>03</td>-->
<!--                                            <td>高鹰</td>-->
<!--                                            <td>修改</td>-->
<!--                                            <td>删除</td>-->
<!--                                        </tr>-->
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.panel-body -->
                            <div class="panel panel-footer">
                                <a <?php if($user_weight[0]=='1'){echo "href='resetAddress.php?action=addAddress'";}else{echo "href='javascript:void(0);' onclick='alertError()'";} ?>" class="btn btn-primary ">增加人员</a>
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
        function alertError(){
            alert("sorry,您的权限不够");
        }
    </script>
</body>

</html>
