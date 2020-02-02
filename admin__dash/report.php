<?php
require_once '../condb.php';
//require_once '../vendor/autoload.php';
use \Mpdf\Mpdf;
use \Mpdf\Config\ConfigVariables;
use \Mpdf\Config\FontVariables;

ob_start();
?>
<?php 
if($_GET['details']=='month'){
    $sql = $pdo->query(" SELECT SUM(sumtotal) AS sumavg,DATE_FORMAT(dateOrder,'%m') AS dategroup FROM tbl_order WHERE DATE_FORMAT(dateOrder,'%m') = DATE_FORMAT(NOW(),'%m') AND status='yes' GROUP BY DATE_FORMAT(dateOrder,'%d') ") ;
    $rowdate = $sql->fetch(PDO::FETCH_ASSOC);
} elseif($_GET['details']=='year'){
    $sql = $pdo->query(" SELECT SUM(sumtotal) AS sumavg,DATE_FORMAT(dateOrder,'%Y') AS dategroup FROM tbl_order WHERE DATE_FORMAT(dateOrder,'%y') = DATE_FORMAT(NOW(),'%y') AND status='yes' GROUP BY DATE_FORMAT(dateOrder,'%m') ") ;
    $rowdate = $sql->fetch(PDO::FETCH_ASSOC);
}

if($_GET['details']=='month'){
    if($rowdate['dategroup']==1){
        $rowdate['dategroup'] = "มกราคม";
    } elseif($rowdate['dategroup']==2){
        $rowdate['dategroup'] = "กุมภาพันธ์";
    } elseif($rowdate['dategroup']==3){
        $rowdate['dategroup'] = "มีนาคม";
    } elseif($rowdate['dategroup']==4){
        $rowdate['dategroup'] = "เมษายน";
    } elseif($rowdate['dategroup']==5){
        $rowdate['dategroup'] = "พฤษภาคม";
    } elseif($rowdate['dategroup']==6){
        $rowdate['dategroup'] = "มิถุนายน";
    } elseif($rowdate['dategroup']==7){
        $rowdate['dategroup'] = "กรกฎาคม";
    } elseif($rowdate['dategroup']==8){
        $rowdate['dategroup'] = "สิงหาคม";
    } elseif($rowdate['dategroup']==9){
        $rowdate['dategroup'] = "กันยายน";
    } elseif($rowdate['dategroup']==10){
        $rowdate['dategroup'] = "ตุลาคม";
    } elseif($rowdate['dategroup']==11){
        $rowdate['dategroup'] = "พฤศจิกายน";
    } elseif($rowdate['dategroup']==12){
        $rowdate['dategroup'] = "ธันวาคม";
    }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
  <body style="font-family: garuda">
  <p style="text-align:center">
    <h3 style="text-align:center">
        <?php if($_GET['details']=='year'){ ?>
            รายงานยอดขายร้านฟาร์มสวยประจำปี <?php echo $rowdate['dategroup']+543 ?>
        <?php } elseif($_GET['details']=='month') { ?>
            รายงานยอดขายร้านฟาร์มสวยประจำเดือน <?php echo $rowdate['dategroup']; ?>
        <?php } ?>
    </h3>
  </p>
      <table width="100%" style="line-height:28px;">
        <thead>
            <tr bgcolor="skyblue">
                <th>ลำดับ</th>
                <th><?php if($_GET['details']=='month') { echo "วันที่"; } else { echo"เดือน";}?></th>
                <th>ราคารวมเฉลี่ย</th>
            </tr>
        </thead>
        <tbody>
        <?php 
        if($_GET['details']=='month'){
            $sql2 = $pdo->query(" SELECT SUM(sumtotal) AS sumavg,tbl_order.*,DATE_FORMAT(dateOrder,'%d') AS dateOrder,DATE_FORMAT(dateOrder,'%d') AS dategroup FROM tbl_order WHERE DATE_FORMAT(dateOrder,'%m') = DATE_FORMAT(NOW(),'%m') AND status='yes' GROUP BY dategroup ORDER BY dategroup DESC ") ;
        } elseif($_GET['details']=='year'){
            $sql2 = $pdo->query(" SELECT SUM(sumtotal) AS sumavg,tbl_order.*,DATE_FORMAT(dateOrder,'%d') AS dateOrder,DATE_FORMAT(dateOrder,'%m') AS dategroup FROM tbl_order WHERE DATE_FORMAT(dateOrder,'%y') = DATE_FORMAT(NOW(),'%y') AND status='yes' GROUP BY dategroup  ORDER BY dategroup DESC ") ;
        }
        $number = 1;
        while($rs_order=$sql2->fetch(PDO::FETCH_ASSOC)){
            if($_GET['details']=='year'){
                if($rs_order['dategroup']==1){
                    $rs_order['dategroup'] = "มกราคม";
                } elseif($rs_order['dategroup']==2){
                    $rs_order['dategroup'] = "กุมภาพันธ์";
                } elseif($rs_order['dategroup']==3){
                    $rs_order['dategroup'] = "มีนาคม";
                } elseif($rs_order['dategroup']==4){
                    $rs_order['dategroup'] = "เมษายน";
                } elseif($rs_order['dategroup']==5){
                    $rs_order['dategroup'] = "พฤษภาคม";
                } elseif($rs_order['dategroup']==6){
                    $rs_order['dategroup'] = "มิถุนายน";
                } elseif($rs_order['dategroup']==7){
                    $rs_order['dategroup'] = "กรกฎาคม";
                } elseif($rs_order['dategroup']==8){
                    $rs_order['dategroup'] = "สิงหาคม";
                } elseif($rs_order['dategroup']==9){
                    $rs_order['dategroup'] = "กันยายน";
                } elseif($rs_order['dategroup']==10){
                    $rs_order['dategroup'] = "ตุลาคม";
                } elseif($rs_order['dategroup']==11){
                    $rs_order['dategroup'] = "พฤศจิกายน";
                } elseif($rs_order['dategroup']==12){
                    $rs_order['dategroup'] = "ธันวาคม";
                }
            }
        ?>
            <tr>
                <td align="center"><?php echo $number; ?></td>
                <td width="60%" align="center"><?php if($_GET['details']=='year'){ echo $rs_order['dategroup']; } else { echo $rs_order['dateOrder']." ".$rowdate['dategroup'];} ?></td>
                <td align="right"><?php echo number_format($rs_order['sumavg'],2); ?></td>
            </tr>
            
        <?php 
            $number+=1;
            $sumavg+=$rs_order['sumavg'];
            } 
        ?>
            <tr bgcolor="skyblue">
                <th colspan="2" align="right">ราคารวมสุทธิ</th>
                <th align="right"><?php echo number_format($sumavg,2); ?></th>
            </tr>
        </tbody>
      </table>
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