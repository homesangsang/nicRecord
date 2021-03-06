<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>齐鲁工业大学 网络信息中心 故障登记系统</title>

    <!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div class="container">
        <div class="row">
             <div class="col-md-4 col-md-offset-4">
                 <div class="login-panel panel panel-default">

                     <div class="panel-heading">
                         <img class="img-responsive img-rounded" src="xiaohui.png"/>
                    </div>
                    <div class="panel-body">
                        <form role="form" name="LoginForm" method="post" action="action.php?action=login" onsubmit="return InputCheck(this)" >
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="账号" name="id" type="id" value=""  autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="密码" name="password" type="password" value="">
                                </div>
                                <div class="form-group">
                                    <div class="row" >

                                        <div class="col-md-5 col-xs-5">
                                            <img id="checkpic" style="width: 150px;height: 50px;" class="img-responsive img-rounded" onclick="change()" src="verificationCode.php"/>
                                        </div>
                                        <div class="col-md-7 col-xs-7">
                                            <input class="form-control" style="height: 50px" placeholder="请输入验证码" name="verification" type="text" value="">
                                        </div>


                                    </div>
                                     </div>
                               <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">记住我
                                    </label>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button type="submit" class="btn btn-lg btn-primary btn-block" style="font-family:Microsoft YaHei">登录</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/admin_system.js"></script>
    <script>
        function InputCheck(LoginForm){
            if(LoginForm.id.value==""){
                alert("请输入用户名");
                LoginForm.id.focus();
                return (false);
            }
            if(LoginForm.password.value==""){
                alert("请输入密码");
                LoginForm.password.focus();
                return (false);
            }
        }
        function change(){
            document.getElementById('checkpic').src="verificationCode.php";
        }
    </script>
</body>

</html>
