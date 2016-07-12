<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="">

    <title>齐鲁工业大学 网络信息中心 故障登记系统</title>

     <!-- Custom CSS -->
    <link href="../dist/css/login.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href='http://fonts.useso.com/css?family=PT+Sans:400,700,400italic,700italic|Oswald:400,300,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.useso.com/css?family=Exo+2' rel='stylesheet' type='text/css'>


</head>

<body>

<h1 class="title">网 络 信 息 中 心<br>Network Information Center</h1>

<div class="login-form">
    <div class="clear"> </div>
    <div class="avtar">
        <img width=79 src="../dist/login/avtar2.png" />
    </div>
    <form role="form" name="LoginForm" method="post" action="action.php?action=login" onsubmit="return InputCheck(this)" >
        <input type="text" name="id" class="username" value="Username" onfocus="this.value = '';"  >
        <div class="key">
            <input type="password" name="password" class="password" value="password" onfocus="this.value = '';" >
        </div>
        <div>
            <img id="checkpic" style="margin-top:1em;width: 120px;height: 50px;" class="img-responsive img-rounded" onclick="change()" src="verificationCode.php"/>
            <input style="width:150px" type="text" name="verification"  class="verification" value="请输入验证码" onfocus="this.value = '';" >

        </div>
        <div class="signin">
            <button type="submit" class="mybtn">Login</button>
        </div>
    </form>

</div>


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
