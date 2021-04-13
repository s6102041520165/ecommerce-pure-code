<?php require_once 'condb.php'; ?>
<?php 
if(isset($_SESSION['web'])){
  echo "<script>window.history.back();</script>";
}
if(isset($_GET['action']) && $_GET['action']=="add"){
    $ext = pathinfo($_FILES['profiles']['name'],PATHINFO_EXTENSION);
    $rand = rand(000000000,999999999);
    $name = "profiles".$rand.".".$ext;
    $tmp = $_FILES['profiles']['tmp_name'];
    if(!$tmp){
        $name = NULL;
    } 
    move_uploaded_file($tmp,"image/".$name);
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    $password = password_hash($password,PASSWORD_DEFAULT);
    
    
    $update = $pdo->query("INSERT INTO tbl_user (`username`, `password`, `name`, `surname`, `profiles`, `email`, `tel`, `addr`, `locality`, `district`, `province`, `zipcode`, `level`)
            VALUES ('".$username."',
            '".$password."',
            '".htmlspecialchars($_POST['name'])."',
            '".htmlspecialchars($_POST['surname'])."',
            '".htmlspecialchars($name)."',
            '".htmlspecialchars($_POST['email'])."',
            '".htmlspecialchars($_POST['tel'])."',
            '".htmlspecialchars($_POST['addr'])."',
            '".htmlspecialchars($_POST['locality'])."',
            '".htmlspecialchars($_POST['district'])."',
            '".htmlspecialchars($_POST['province'])."',
            '".htmlspecialchars($_POST['zipcode'])."',
            'customer') ");
    if($update){
        echo("<script>alert('สมัครสมาชิกสำเร็จ');window.location='index.php';</script>");
    } else {
        echo "<script>alert('ไม่สามารถสมัครสมาชิกได้');</script>";
        echo "<script>window.history.back();</script>";
    }
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
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="./jquery.Thailand.js/jquery.Thailand.js/dependencies/JQL.min.js"></script>
    <script type="text/javascript" src="./jquery.Thailand.js/jquery.Thailand.js/dependencies/typeahead.bundle.js">
    </script>
    <link rel="stylesheet" href="./jquery.Thailand.js/jquery.Thailand.js/dist/jquery.Thailand.min.css">
    <script type="text/javascript" src="./jquery.Thailand.js/jquery.Thailand.js/dist/jquery.Thailand.min.js"></script>
    <script>
        $(document).ready(function () {
            $.Thailand.setup({
                database: './jquery.Thailand.js/jquery.Thailand.js/database/db.json'
            });
            $.Thailand({
                $amphoe: $('[name="district"]'),
                $district: $('[name="locality"]'),
                $province: $('[name="province"]'),
                $zipcode: $('[name="zipcode"]'),
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
        h1,
        h2,
        h3,
        h4,
        h5,
        a,
        button,
        li,
        nav,
        ul,
        body,
        span {
            font-family: 'Kanit', sans-serif;
        }
    </style>
    <script>
        function checkpass() {
            if (document.frmadd.password.value != document.frmadd.repassword.value) {
                alert('รหัสผ่านไม่ตรงกัน');
                document.frmadd.password.focus();
                return false;
            } else {
                document.frmadd.submit();
                return true;
            }
        }
    </script>
</head>

<body>
    <div class="container">
        <form enctype="multipart/form-data" name="frmadd"
            action="formregister.php?action=add" onsubmit="return checkpass();" method="post">
            <h1 class="">สมัครสมาชิก</h1>

            <div class="form-group">
                <label for="inputGroupSelect01">Username</label>
                <input type="text" autocomplete="off" class="form-control" required name="username">
            </div>

            <div class="form-group">
                <label for="inputGroupSelect01">Password</label>
                <input type="password" class="form-control" required name="password">
            </div>

            <div class="form-group">
                <label for="inputGroupSelect01">Re-Password</label>
                <input type="password" class="form-control" required name="repassword">
            </div>
            <hr>

            <div class="form-group">
                <label for="inputGroupSelect01">ชื่อ</label>
                <input type="text" class="form-control" required name="name">
            </div>

            <div class="form-group">
                <label for="inputGroupSelect01">นามสกุล</label>
                <input type="text" class="form-control" required name="surname">
            </div>

            <div class="form-group">
                <label for="inputGroupSelect01">โปรไฟล์</label>
                <input type="file" class="form-control" name="profiles">
            </div>

            <div class="form-group">
                <label for="inputGroupSelect01">อีเมล์</label>
                <input type="email" class="form-control" required name="email">
            </div>

            <div class="form-group">
                <label for="inputGroupSelect01">เบอร์โทร</label>
                <input type="text" maxlength="10" class="form-control" required name="tel">
            </div>

            <div class="form-group">

                <label for="inputGroupSelect01">ที่อยู่</label>
                <textarea rows="5" class="form-control" required name="addr"></textarea>
            </div>

            <div class="form-group">

                <label for="inputGroupSelect01">ตำบล/แขวง</label>
                <input type="text" class="form-control" required name="locality">
            </div>

            <div class="form-group">
                <label for="inputGroupSelect01">อำเภอ/เขต</label>
                <input type="text" class="form-control" required name="district">
            </div>

            <div class="form-group">

                <label for="inputGroupSelect01">จังหวัด</label>
                <input type="text" class="form-control" required name="province">
            </div>

            <div class="form-group">
                <label for="inputGroupSelect01">รหัสไปรษณีย์</label>
                <input type="text" class="form-control" required name="zipcode">
            </div>

            <input type="hidden" name="level" value="member">

            <button type="submit" class="btn btn-primary">สมัครสมาชิก</button>
            <p class="mt-5 mb-3 text-muted">Copyright &copy; 2018 | <a href="index.php"><span class="fa fa-home"></span>
                    Home</a></p>

        </form>
    </div>
</body>

</html>