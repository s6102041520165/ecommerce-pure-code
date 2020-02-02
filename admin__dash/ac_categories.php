<?php 
require_once '../condb.php';
if(isset($_GET['action']) && $_GET['action']=="add"){
    $update = $pdo->query(" INSERT INTO tbl_categories (`catgName`)
            VALUES ('".$_POST['catgName']."') ");
    if($update){
        echo "<script>window.history.go(-2);</script>";
    } else {
        echo "<script>alert('ไม่สามารถเพิ่มข้อมูลได้');</script>";
        echo "<script>window.history.back();</script>";
    }
} elseif (isset($_GET['action']) && $_GET['action']=="remove" && isset($_GET['catgID'])) {
    $update = $pdo->query(" DELETE FROM tbl_categories where catgID = '".$_GET['catgID']."' ");
    echo "<script>window.history.back();</script>";
} elseif (isset($_GET['action']) && $_GET['action']=="edit" && isset($_POST['catgID'])){
    $update = $pdo->query(" UPDATE tbl_categories SET
            catgName = '".$_POST['catgName']."'
            WHERE catgID = '".$_POST['catgID']."' ");
    if($update){
        echo "<script>window.history.go(-2);</script>";
    } else {
        echo "<script>alert('ไม่สามารถแก้ไขข้อมูลได้');</script>";
        echo "<script>window.history.back();</script>";
    }    
}
?>
<meta charset="utf-8" />