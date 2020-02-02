<?php 
require_once '../condb.php';
if(isset($_GET['action']) && $_GET['action']=="edit"){
    $update = $pdo->query(" UPDATE tbl_store SET
            name = '".$_POST['name']."',
            surname = '".$_POST['surname']."',
            email = '".$_POST['email']."',
            tel = '".$_POST['tel']."',
            addr = '".$_POST['addr']."',
            locality = '".$_POST['locality']."',
            district = '".$_POST['district']."',
            province = '".$_POST['province']."',
            zipcode = '".$_POST['zipcode']."'
            WHERE 1 ");
    if($update){
        echo "<script>window.history.go(-1);</script>";
    } else {
        echo "<script>alert('ไม่สามารถแก้ไขข้อมูลได้');</script>";
        echo "<script>window.history.back();</script>";
    }    
}
?>
<meta charset="utf-8" />