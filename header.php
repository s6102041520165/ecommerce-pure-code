<?php
if (file_exists('installation')) {
  header("Location: installation");
}
?>
<?php require_once 'condb.php'; ?>
<?php
$sql = $pdo->query(" select * from tbl_user where username = '" . $_SESSION['web']['username'] . "' ");
$rs_member = $sql->fetch(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>ร้านฟาร์มสวย</title>
  <script src="./vendor/jquery/jquery.js"></script>
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="vendor/bootstrap/css/blog.css" rel="stylesheet">
  <link rel="stylesheet" href="fontawesome/web/css/fontawesome-all.css">
  <link href="https://fonts.googleapis.com/css?family=Kanit" rel="stylesheet">


  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/foundation.css">
  <script src="js/vendor/modernizr.js"></script>
  <script type="text/javascript" src="dist/xzoom.min.js"></script>
  <link rel="stylesheet" type="text/css" href="css/xzoom.css" media="all" />
  <script type="text/javascript" src="hammer.js/1.0.5/jquery.hammer.min.js"></script>
  <link type="text/css" rel="stylesheet" media="all" href="fancybox/source/jquery.fancybox.css" />
  <link type="text/css" rel="stylesheet" media="all" href="magnific-popup/css/magnific-popup.css" />
  <script type="text/javascript" src="fancybox/source/jquery.fancybox.js"></script>
  <script type="text/javascript" src="magnific-popup/js/magnific-popup.js"></script>
  <script type="text/javascript" src="./jquery.Thailand.js/jquery.Thailand.js/dependencies/JQL.min.js"></script>
  <script type="text/javascript" src="./jquery.Thailand.js/jquery.Thailand.js/dependencies/typeahead.bundle.js">
  </script>
  <link rel="stylesheet" href="./jquery.Thailand.js/jquery.Thailand.js/dist/jquery.Thailand.min.css">
  <script type="text/javascript" src="./jquery.Thailand.js/jquery.Thailand.js/dist/jquery.Thailand.min.js"></script>
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <script>
    function chkfirm(textalert) {
      if (textalert == null) {
        textalert = 'คุณต้องการดำเนินการต่อใช่หรือไม่';
      }
      if (confirm(textalert) == true) {
        return true;
      } else {
        return false;
      }
    }
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

    .details-product {
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

    body {
      margin: 0;
    }

    .container {
      max-width: 95%;
    }

    .bg-pink {
      background-color: lightcoral;
    }


    .bg-pink-light {
      background-color: pink;
    }


    .border-pink {
      border: lightcoral;
    }

    .btn-pink {
      background-color: lightsalmon;
      color: #ECFFF1;
      border: 0px;
    }


    .page-item.ative .page-link {
      background-color: lightcoral !important;
      border-color: lightcoral !important;
    }

    .card .btn-primary {
      background-color: lightsalmon;
      border: 0px;
    }

    .card .btn-primary:hover {
      background-color: red;
      opacity: 0.7;
    }

    .border-pink{
      border:1px lightcoral;
    }

    @media screen and (min-width:1000px) {
      .navbar-brand {
        background: sandybrown;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        padding: 18px;
        position: absolute;
        vertical-align: middle;
        bottom: 0;
        box-shadow: 0px 10px 10px rgb(162, 157, 179);
      }
    }
  </style>

  <script>
    function getDataFromDb() {
      $.ajax({
        url: "ajaxData.php",
        type: "POST",
        dataType: 'html',
        success: function(result) {}
      });
    }

    setInterval(getDataFromDb, 5000); // 1000 = 1 วินาที

    $(document).ready(function() {
      $(window).scroll(function() {
        var SY = window.scrollY;
        var navY = ($('nav').position().top) + ($('nav').height());
        if (SY >= navY) {
          $('nav.navbar').addClass('fixed-top');
        } else {
          $('nav.navbar').removeClass('fixed-top');
        }
      });
    });
  </script>

</head>

<body>

  <!-- Navigation -->
  <div style="background: #eeeeee">
    <div class="container-fluid" style="padding-top: 20px;padding-bottom: 20px;">
      <div class="row">
        <div class="col-md-7 ">


          <?php if ($rs_member->username == null) { ?>
            <button class="btn btn-outline-danger" onclick="window.location='formlogin.php'">เข้าสู่ระบบ</button>
            <button class="btn btn-outline-success " onclick="window.location='formregister.php'">สมัครสมาชิกใหม่</button>
          <?php } else { ?>
            <a href="user.php"><span class="fa fa-user"></span> <?php echo $rs_member->name . " " . $rs_member->surname; ?></a> |
            <a href="logout.php">ออกจากระบบ</a>
          <?php } ?>


        </div>
        <form action="index.php" method="get" class="col-md-5">
          <div class="input-group input-group-lg col-lg-12 col-md-12 col-sm-12 ">
            <input type="text" name="keyword" class="form-control" placeholder="ค้นหาสินค้าที่นี่...">

            <div class="input-group-append">
              <button type="submit" class="btn btn-pink">ค้นหา</button>
            </div>

          </div>
        </form>
      </div>
    </div>
  </div>

  <nav class="navbar navbar-expand-lg navbar-dark bg-pink ">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">Ecommerce</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">

          <li class="nav-item active">
            <a class="nav-link text-light" href="index.php"><span class="fa fa-home"></span> หน้าแรก </a>
          </li>

          <li class="nav-item">
            <a class="nav-link text-light" href="his_shop.php"><span class="fa fa-bookmark"></span> ประวัติการสั่งซื้อ </a>
          </li>

          <li class="nav-item">
            <a class="nav-link text-light" href="contact.php"><span class="fa fa-envelope"></span> ติดต่อเรา </a>
          </li>

          <li class="nav-item">
            <a href="cart.php" class="nav-link text-light">
              <span class="fa fa-shopping-cart"></span> ตะกร้าสินค้า <?php echo (isset($_SESSION['countCart'])) ? $_SESSION['countCart'] : ""; ?>
            </a>
          </li>
          <?php if ($rs_member->level == 'admin') : ?>
            <li class="nav-item">
              <a class="nav-link text-light" href="admin__dash/"><span class="fa fa-lock"></span> หลังร้าน </a>
            </li>
          <?php endif; ?>

        </ul>
      </div>
    </div>
  </nav>
  <div class="container-fluid">
    <div class="row">