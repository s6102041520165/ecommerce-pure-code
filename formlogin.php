<?php require_once 'condb.php'; ?>
<?php 
if(isset($_SESSION['web'])){
  echo "<script>window.history.back();</script>";
}
if(isset($_GET['quest']) && $_GET['quest'] == 'login'){
  $string = 'Nice';
  
    $username = htmlspecialchars($_POST['username']);
    $pass = htmlspecialchars($_POST['password']);
    $username = $pdo->quote($username);
    
    //echo $username;echo $pass;die();
    $sql = $pdo->query(" SELECT * FROM tbl_user WHERE username = $username ");

    $row = $sql->fetch(PDO::FETCH_OBJ);

    if(!empty($row->username)){
      if(password_verify($pass,$row->password)){
        $_SESSION['web'] = array();
        $_SESSION['web']['username'] = $row->username;
        $_SESSION['web']['host'] = $_SERVER['SERVER_NAME'];
        echo "<script>window.history.go(-2);</script>";
      } else { echo "<script>alert('ชื่อผู้ใช้หรือรหัสผ่านผิด');</script>";}
    } else { echo "<script>alert('ชื่อผู้ใช้หรือรหัสผ่านผิด');</script>";}
    /*print_r($numrow);
    if($numrow>0){
      
    }*/
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Signin</title>

    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Kanit" rel="stylesheet">
    <link rel="stylesheet" href="fontawesome/web/css/fontawesome-all.css">

    <link href="signin.css" rel="stylesheet">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="./jquery.Thailand.js/jquery.Thailand.js/dependencies/JQL.min.js"></script>
    <script type="text/javascript" src="./jquery.Thailand.js/jquery.Thailand.js/dependencies/typeahead.bundle.js"></script>
    <link rel="stylesheet" href="./jquery.Thailand.js/jquery.Thailand.js/dist/jquery.Thailand.min.css">
    <script type="text/javascript" src="./jquery.Thailand.js/jquery.Thailand.js/dist/jquery.Thailand.min.js"></script>
    <script>
    $(document).ready(function(){
        $.Thailand.setup({
            database: './jquery.Thailand.js/jquery.Thailand.js/database/db.json'
        });
        $.Thailand({ 
            $amphoe : $('[name="district"]'),
            $district : $('[name="locality"]'),
            $province : $('[name="province"]'),
            $zipcode : $('[name="zipcode"]'),
            /*$search: $('#search'), // input ของช่องค้นหา
            onDataFill: function(data){ // callback เมื่อเกิดการ auto complete ขึ้น
                //console.log(data[0]);
                $('#district').val(data['amphoe']);
                $('#locality').val(data['district']);
                $('#province').val(data['province']);
                $('#zipcode').val(data['zipcode']);
            }*/
        });
    })
    </script>
    <style>
      h1,h2,h3,h4,h5,a,button,li,nav,ul,body,span{
        font-family: 'Kanit', sans-serif;
      }
    </style>
  </head>

  <body class="text-center">
    <form class="form-signin" action="formlogin.php?quest=login" method="post">
      <img class="mb-4" src="https://getbootstrap.com/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
      <h1 class="h3 mb-3 font-weight-normal">กรุณาเข้าสู่ระบบ</h1>
      <input type="text" id="username" name="username" value="" class="form-control" placeholder="ชื่อเข้าใช้งาน" required autofocus>
      <input type="password" id="password" name="password" value="" class="form-control" placeholder="รหัสผ่าน" required>
      <button class="btn btn-lg btn-primary btn-block" type="submit">เข้าสู่ระบบ</button>
      <p class="mt-5 mb-3 text-muted">Copyright &copy; 2019 | <a href="index.php"><span class="fa fa-home"></span> Home</a></p>
    </form>
  </body>
</html>
