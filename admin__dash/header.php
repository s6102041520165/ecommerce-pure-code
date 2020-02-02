<?php require_once '../condb.php'; ?>
<?php 
$sql = $pdo->query(" select * from tbl_user where username = '".$_SESSION['web']['username']."' AND level = 'admin' ");
$rs_member = $sql->fetch(PDO::FETCH_ASSOC);
if(empty($rs_member)){
    header("location: ../");
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>ระบบจัดการร้านค้า</title>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="../vendor/bootstrap/css/bootstrap.min.css" >
    <link rel="stylesheet" href="../fontawesome/web/css/fontawesome-all.css">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="style2.css">
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">

    <!-- Font Awesome JS -->
    <link href="https://fonts.googleapis.com/css?family=Kanit" rel="stylesheet">
    <style>
        h1,h2,h3,h4,h5,a,button,li,nav,ul,body,span,p{
            font-family: 'Kanit', sans-serif;
        }
    </style>
    <script>
        function checksearch(){
            var searchlink = document.frmsearch.keylink.value;
            if(searchlink){
                document.frmsearch.action=searchlink;
            } 
            document.frmsearch.keylink.value = null;
            document.frmsearch.submit();
        }
    </script>
    <script>
    function chkfirm(textalert){
      if(textalert == null){
        textalert = 'คุณต้องการดำเนินการต่อใช่หรือไม่';
      }
      if(confirm(textalert)==true){
        return true;
      } else {
        return false;
      }
    }
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
    <script>
    function getDataFromDb()
    {
      $.ajax({ 
            url: "ajaxData.php" ,
            type: "POST",
            dataType: 'html',
            success: function(result){
            }
      });
    }

    setInterval(getDataFromDb, 3000);   // 1000 = 1 วินาที

    function getDataFromDb2()
    {
      $.ajax({ 
            url: "ajaxData2.php" ,
            type: "POST",
            dataType: 'html',
            success: function(result){
            }
      });
    }

    setInterval(getDataFromDb, 3000);   // 1000 = 1 วินาที
    setInterval(getDataFromDb2,3000);
    </script>
</head>

<body>

    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>Administrator</h3>
            </div>

            <ul class="list-unstyled components">
                <center>
                    <?php if($rs_member['profiles']==NULL) { ?>
                        <img src="../image/img_avatar3.png" style="width:30%;height:40%;border-radius:50%" alt="">
                    <?php } else { ?>
                        <img src="../image/<?php echo $rs_member['profiles']; ?>" style="width:40%;height:auto%;border-radius:50%" alt="">
                    <?php } ?>
                    <p><?php echo $rs_member['name']." ".$rs_member['surname']; ?></p>
                </center>
                <li class="active">
                    <a href="index.php">หน้าแรก</a>
                </li>
               
                <li>
                    <a href="member.php">สมาชิก</a>
                </li>
                <li>
                    <a href="categories.php">ประเภทสินค้า</a>
                </li>
                <li>
                    <a href="product.php">สินค้า</a>
                </li>
                <li>
                    <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">คำสั่งซื้อ</a>
                    <ul class="collapse list-unstyled" id="pageSubmenu">
                        <li>
                            <a href="order.php?status=1">รอดำเนินการ</a>
                        </li>
                        <li>
                            <a href="order.php?status=2">ดำเนินการแล้ว</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#pageSubmenu2" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">รายงานการขาย</a>
                    <ul class="collapse list-unstyled" id="pageSubmenu2">
                        <li>
                            <a target="_blank" href="report.php?details=month">รายงานประจำเดือน</a>
                        </li>
                        <li>
                            <a target="_blank" href="report.php?details=year">รายงานประจำปี</a>
                        </li>
                    </ul>
                </li>
                    <ol class="nav-active">
                    <a href="../logout.php" onclick="return chkfirm('ต้องการออกจากระบบใช่หรือไม่');" class="btn-danger btn">
                        <span class="fa fa-sign-out-alt"></span> ออกจากระบบ
                    </a>
                </ol>
            </ul>
        </nav>

        <!-- Page Content  -->
        <div id="content">

            <nav class="navbar navbar-expand-lg navbar-light bg-ligth">
                <div class="container-fluid">

                    <button type="button" id="sidebarCollapse" class="btn btn-primary">
                        <i class="fas fa-align-left"></i>
                        <span>เมนู</span>
                    </button>
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-justify"></i>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto">

                            <li class="nav-item">
                                <form name="frmsearch" action="" method="get" onsubmit="return checksearch()">
                                    <div class="form-group">ค้นหา : 
                                        <select name="keylink" id="" class="form-control" required>
                                            <option value="member.php">สมาชิก</option>
                                            <option value="product.php">สินค้า</option>
                                            <option value="categories.php">ประเภทสินค้า</option>
                                        </select>
                                    </div>
                                        <div class="input-group">
                                            <input name="keyword" type="text" placeholder="ค้นหาที่นี่" class="form-control" required>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit">ค้นหา</button>
                                        </div>
                                    </div>
                                </form>
                                
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

