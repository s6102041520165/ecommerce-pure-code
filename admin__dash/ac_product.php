<?php 
require_once '../condb.php';
if(isset($_GET['action']) && $_GET['action']=="add"){
    $ext = pathinfo($_FILES['proPic']['name'],PATHINFO_EXTENSION);
    $rand = rand(000000000,999999999);
    $name = "product".$rand.".".$ext;
    $tmp = $_FILES['proPic']['tmp_name'];
    if(!$tmp){
        $name = NULL;
    } 
    move_uploaded_file($tmp,"../image/".$name);
    $update = $pdo->query(" INSERT INTO tbl_product (`proName`, `proPic`, `proDetails`, `proQty`, `proPrice`, `proDate`, `UnitName`, `catgID`)
            VALUES ('".$_POST['proName']."', 
            '".$name."',
            '".$_POST['proDetails']."',
            '".$_POST['proQty']."',
            '".$_POST['proPrice']."',
            NOW(),
            '".$_POST['UnitName']."', 
            '".$_POST['catgID']."'
            ) ") ;
    $id = $pdo->lastInsertId();
    if($_FILES['proPicName']['tmp_name']){
        for($i=0;$i<count($_FILES['proPicName']['tmp_name']);$i++){
            $picname = $_FILES['proPicName']['name'];
            $ext2 = pathinfo($picname[$i],PATHINFO_EXTENSION);
            $name2 = "product_".$rand."_".$i.".".$ext2;
            $tmp2 = $_FILES['proPicName']['tmp_name'];
            if($tmp2[$i]!=NULL){
                move_uploaded_file($tmp2[$i],"../image/".$name2);
                $update2 = $pdo->query(" INSERT INTO tbl_pic_product (proPicName,proID)
                        VALUES ('".$name2."','".$id."') ");
            }
        }
    }
    if($update){
        echo "<script>window.history.go(-2);</script>";
    } else {
        echo "<script>alert('ไม่สามารถเพิ่มข้อมูลได้');</script>";
        echo "<script>window.history.back();</script>";
    }
} elseif (isset($_GET['action']) && $_GET['action']=="remove" && isset($_GET['proID'])) {
    $update = $pdo->query(" DELETE FROM tbl_product where proID = '".$_GET['proID']."' ");
    echo "<script>window.history.back();</script>";
} elseif (isset($_GET['action']) && $_GET['action']=="edit" && isset($_POST['proID'])){
    $ext = pathinfo($_FILES['proPic']['name'],PATHINFO_EXTENSION);
    $rand = rand(000000000,999999999);
    $name = "product".$rand.".".$ext;
    $tmp = $_FILES['proPic']['tmp_name'];
    if(!$tmp){
        $name = $_POST['noselect'];
    } 
    move_uploaded_file($tmp,"../image/".$name);
    $update = $pdo->query(" UPDATE tbl_product SET
            proName = '".$_POST['proName']."', 
            proPic = '".$name."',
            proDetails = '".$_POST['proDetails']."',
            proQty = '".$_POST['proQty']."',
            proPrice = '".$_POST['proPrice']."',
            proDate = NOW(),
            UnitName = '".$_POST['UnitName']."', 
            catgID = '".$_POST['catgID']."'
            WHERE proID = '".$_POST['proID']."' ");
    if(isset($_FILES['proPicName']['tmp_name'])){
        for($i=0;$i<count($_FILES['proPicName']['tmp_name']);$i++){
            $picname = $_FILES['proPicName']['name'];
            $ext2 = pathinfo($picname[$i],PATHINFO_EXTENSION);
            $name2 = "product_".$rand."_".$i.".".$ext2;
            $tmp2 = $_FILES['proPicName']['tmp_name'];
            if($tmp2[$i]!=NULL){
                move_uploaded_file($tmp2[$i],"../image/".$name2);
                $update2 = $pdo->query(" INSERT INTO tbl_pic_product (proPicName,proID)
                         VALUES ('".$name2."','".$_POST['proID']."') ");
            }
            
        }
    }
    if($update){
        echo "<script>window.history.go(-2);</script>";
    } else {
        echo "<script>alert('ไม่สามารถแก้ไขข้อมูลได้');</script>";
        echo "<script>window.history.back();</script>";
    }    
} elseif (isset($_GET['action']) && $_GET['action']=="remove_pic" && isset($_GET['proPicID'])){
    $update = $pdo->query(" DELETE FROM tbl_pic_product WHERE proPicID='".$_GET['proPicID']."' ");
    @unlink("../image/".$_GET['proPicName']);
    echo "<script>window.history.back();</script>";
}
?>
<meta charset="utf-8" />