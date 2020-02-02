<?php
require '../condb.php';
use \Mpdf\Mpdf;
use \Mpdf\Config\ConfigVariables;
use \Mpdf\Config\FontVariables;
ob_start();
?>
<?php 
    $sql = $pdo->query(" SELECT tbl_order.*,tbl_user.* 
    FROM tbl_order INNER JOIN tbl_user
    ON (tbl_order.username = tbl_user.username)
    WHERE showOrder = 'yes' AND tbl_order.orderID='".$_GET['orderID']."' ");
    $rs_order = $sql->fetch(PDO::FETCH_ASSOC);

    $sql2 = $pdo->query(" SELECT * FROM tbl_store WHERE storeID = 1 ") ;
    $rs_store=$sql2->fetch(PDO::FETCH_ASSOC);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<style>
<!--
@page rotated { size: landscape; }
.style1 {
	font-family: "TH SarabunPSK";
	font-size: 18pt;
	font-weight: bold;
}
.style2 {
	font-family: "TH SarabunPSK";
	font-size: 16pt;
	font-weight: bold;
}
.style3 {
	font-family: "TH SarabunPSK";
	font-size: 16pt;
	
}
th{
  border:1px solid lightblue
}
.style5 {cursor: hand; font-weight: normal; color: #000000;}
.style9 {font-family: Tahoma; font-size: 12px; }
.style11 {font-size: 12px}
.style13 {font-size: 9}
.style16 {font-size: 9; font-weight: bold; }
.style17 {font-size: 12px; font-weight: bold; }
-->
</style>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html>
<head>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
</head>
  <body>
    <h3 style="text-align:center">
    <img width="100px" src="../image/logo.jpg" /><br>
    ใบเสร็จรับเงิน ร้านฟาร์มสวย 
    </h3>
    <table width="100%" style="line-height:26px" cellspacing="0" cellpadding="5" >
      <tbody>
        <tr>
          <td width="50%" valign="top">
            <p><strong>ข้อมูลลูกค้า</strong> </p>
            <?php echo "<strong>คุณ : </strong>".$rs_order['name']." ".$rs_order['surname']; ?><br>
            <?php echo "<strong>อีเมล์ : </strong>".$rs_order['email']; ?><br>
            <?php echo "<strong>เบอร์โทร : </strong>".$rs_order['email']; ?><br>
            <?php echo "<strong>ที่อยู่ : </strong>".$rs_order['addr']." ตำบล".$rs_order['locality']." อำเภอ".$rs_order['district']." จังหวัด".$rs_order['province']." รหัสไปรษณีย์ ".$rs_order['zipcode']; ?>
          </td>
          <td width="50%"  valign="top" >
            <p><strong>ข้อมูลร้านค้า</strong> </p>
            <?php echo "<strong>คุณ : </strong>".$rs_store['name']." ".$rs_store['surname']; ?><br>
            <?php echo "<strong>อีเมล์ : </strong>".$rs_store['email']; ?><br>
            <?php echo "<strong>เบอร์โทร : </strong>".$rs_store['email']; ?><br>
            <?php echo "<strong>ที่อยู่ : </strong>".$rs_store['addr']." ตำบล".$rs_store['locality']." อำเภอ".$rs_store['district']." จังหวัด".$rs_store['province']." รหัสไปรษณีย์ ".$rs_store['zipcode']; ?>
          </td>
        </tr>
      </tbody>
    </table>
    <br>
    <table cellspacing="0" width="100%" style="border:1px solid darkblue;line-height:25px;" cellpadding="5">
      <thead>
      <tr bgcolor="darkblue" >
          <td colspan="5" style="color:white"><center><h4>รหัสใบสั่งซื้อ : <?php echo $rs_order['orderID']."<br> วันที่ : ".$rs_order['dateOrder']; ?></h4></center></td>
      </tr>
      <tr>
          <th style="border:1px solid darkblue">รหัสสินค้า</th>
          <th style="border:1px solid darkblue">สินค้า</th>
          <th style="border:1px solid darkblue">ราคา /1 หน่วย</th>
          <th style="border:1px solid darkblue">จำนวน /<br> คงเหลือ</th>
          <th style="border:1px solid darkblue">ราคารวม</th>
      </tr>
      </thead>
      <tbody style="height:800px" >
      <?php
          $total = 0;
          $sumtotal = 0; 
          $prototal = 0;
          $tax = 0;
          $sql2 = $pdo->query(" SELECT tbl_order_detail.*,tbl_product.* 
          FROM tbl_order_detail 
          INNER JOIN tbl_product
          ON (tbl_order_detail.proID=tbl_product.proID) 
          WHERE orderID='".$rs_order['orderID']."' ") or die(mysqli_error($conn));
          while($rs_order_detail = $sql2->fetch(PDO::FETCH_ASSOC)){
              $total = $rs_order_detail['qty']*$rs_order_detail['proPrice'];
              $prototal += $total;
              $tax = ($prototal*7)/100;
              $sumtotal = $prototal + $tax;
      ?>
      <tr>
          <td style="border:1px solid darkblue" width="15%">
              <?php echo "P".$rs_order_detail['proID']; ?>
          </td>
          <td style="border:1px solid darkblue" width="30%">
              <?php echo $rs_order_detail['proName']; ?>
          </td>
          <td style="border:1px solid darkblue" align="center" width="20%">
            <?php echo number_format($rs_order_detail['proPrice'],2); ?> บาท </td>
          <td style="border:1px solid darkblue" align="center" width="17%">
             <?php echo $rs_order_detail['qty']; ?> /
              <?php echo $rs_order_detail['proQty']; ?><br>
          </td>
          <td style="border:1px solid darkblue" align="right" width="18%">
              <?php echo number_format($total,2); ?>
          </td>
      </tr>
      <?php } ?>
      <tr>
          <td style="border:1px solid darkblue" valign="middle" align="center" rowspan="3" colspan="3">
             <?php if($rs_order['status']=="no"){ echo "ยังไม่ชำระเงิน"; }else{ echo "ชำระเงินแล้ว"; } ?>
          </td>
          <td style="border:1px solid darkblue" align="right">ราคาสินค้ารวม</td>
          <td style="border:1px solid darkblue" align="right"><?php echo number_format($prototal,2); ?></td>
      </tr>
      <tr>
          <td style="border:1px solid darkblue" align="right">ภาษี 7 %</td>
          <td style="border:1px solid darkblue" align="right"><?php echo number_format($tax,2); ?></td>
      </tr>
      <tr>
          <td style="border:1px solid darkblue" align="right">ราคารวมสุทธิ</td>
          <td style="border:1px solid darkblue" align="right"><?php echo number_format($sumtotal,2); ?></td>
      </tr>
      </tbody>
    </table>
    <p style="color:red">* สำหรับเจ้าของร้าน</p>
  </body>
</html>

<?php 
$html = ob_get_contents();
ob_end_clean();
$mpdf = new Mpdf();

$defaultConfig = (new ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];

$defaultFontConfig = (new FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];

$mpdf = new Mpdf([
    'fontDir' => array_merge($fontDirs, [
        '../fonts',
    ]),
    'fontdata' => $fontData + [
        'kanit' => [
            'R' => 'Kanit-Regular.ttf',
            //'I' => 'THSarabunNew Italic.ttf',
            //'B' => 'THSarabunNew Bold.ttf',
        ]
    ],
    'default_font' => 'kanit'
]);


$mpdf->WriteHTML($html, 2);
$mpdf->Output(rand(00000,99999),'I');
?>