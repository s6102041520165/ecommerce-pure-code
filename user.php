<?php require_once 'condb.php'; ?>
<?php 
$sql = " select * from tbl_user where username = '".$_SESSION['web']['username']."' ";
$query = $pdo->query($sql);
$rs_user = $query->fetch(PDO::FETCH_ASSOC);
if(!isset($_SESSION['web'])){
  echo "<script>window.history.back();</script>";
}
if(isset($_GET['action']) && $_GET['action']=="edit"){
    $ext = pathinfo($_FILES['profiles']['name'],PATHINFO_EXTENSION);
    $rand = rand(000000000,999999999);
    $name = "profiles".$rand.".".$ext;
    $tmp = $_FILES['profiles']['tmp_name'];
    if(!$tmp){
        $name = $_POST['noselect'];
    } 
    move_uploaded_file($tmp,"../image/".$name);
    
    $update = $pdo->query(" UPDATE tbl_user SET
            name = '".htmlspecialchars($_POST['name'])."',
            surname = '".htmlspecialchars($_POST['surname'])."',
            profiles = '".htmlspecialchars($name)."',
            email = '".htmlspecialchars($_POST['email'])."',
            tel = '".htmlspecialchars($_POST['tel'])."',
            addr = '".htmlspecialchars($_POST['addr'])."',
            locality = '".htmlspecialchars($_POST['locality'])."',
            district = '".htmlspecialchars($_POST['district'])."',
            province = '".htmlspecialchars($_POST['province'])."',
            zipcode = '".htmlspecialchars($_POST['zipcode'])."'
            WHERE username = '".$_SESSION['web']['username']."' ");
    if($update){
        echo "<script>window.history.go(-2);</script>";
    } else {
        echo "<script>alert('ไม่สามารถแก้ไขข้อมูลได้');</script>";
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
    <link href="signin.css" rel="stylesheet">
    <style>
      h1,h2,h3,h4,h5,a,button,li,nav,ul,body,span{
        font-family: 'Kanit', sans-serif;
      }
    </style>
    <script>
    function checkpass(){
        if(document.frmadd.password.value!=document.frmadd.repassword.value){
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

  <body class="text-center">
    <form enctype="multipart/form-data" style="width:100%;max-width:600px;margin:auto" name="frmedit" action="user.php?action=edit" onsubmit="return checkpass();" method="post">
        <h1 class="h3 mb-3 font-weight-normal">แก้ไขมูลส่วนตัว</h1>
        <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">Username</label>
            </div>
            <input type="text" value="<?php echo $rs_user['username'] ?>" disabled autocomplete="off" class="form-control" required >
            <input type="hidden" name="username" value="<?php echo $rs_user['username'] ?>">
        </div>

        <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">ชื่อ</label>
            </div>
            <input type="text" value="<?php echo $rs_user['name'] ?>" class="form-control" required name="name">
        </div>

        <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">นามสกุล</label>
            </div>
            <input type="text" value="<?php echo $rs_user['surname'] ?>" class="form-control" required name="surname">
        </div>

        <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">โปรไฟล์</label>
            </div>
            <input type="file" class="form-control" name="profiles">
            <input type="hidden" name="noselect" value="<?php echo $rs_user['profiles'] ?>">
        </div>

        <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">อีเมล์</label>
            </div>
            <input type="email" value="<?php echo $rs_user['email'] ?>" class="form-control" required name="email">
        </div>

        <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">เบอร์โทร</label>
            </div>
            <input type="text" value="<?php echo $rs_user['tel'] ?>" maxlength="10" class="form-control" required name="tel">
        </div>

        <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">ที่อยู่</label>
            </div>
            <textarea rows="5" class="form-control" required name="addr"><?php echo $rs_user['addr'] ?></textarea>
        </div>

        <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">ตำบล/แขวง</label>
            </div>
            <input type="text" value="<?php echo $rs_user['locality'] ?>" class="form-control" required name="locality">
        </div>

        <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">อำเภอ/เขต</label>
            </div>
            <input type="text" value="<?php echo $rs_user['district'] ?>" class="form-control" required name="district">
        </div>

        <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">จังหวัด</label>
            </div>
            <input type="text" value="<?php echo $rs_user['province'] ?>" class="form-control" required name="province">
        </div>

        <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">รหัสไปรษณีย์</label>
            </div>
            <input type="text" value="<?php echo $rs_user['zipcode'] ?>" class="form-control" required name="zipcode">
        </div>

        <button type="submit" class="btn btn-primary">แก้ไขข้อมูลส่วนตัว</button>
        <p class="mt-5 mb-3 text-muted">Copyright &copy; 2018 | <a href="index.php"><span class="fa fa-home"></span> Home</a></p>

    </form>
  </body>
</html>
