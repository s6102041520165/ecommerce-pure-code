<?php 
require_once '../condb.php';
if(isset($_GET['action']) && $_GET['action']=="add"){
    $ext = pathinfo($_FILES['profiles']['name'],PATHINFO_EXTENSION);
    $rand = rand(000000000,999999999);
    $name = "profiles".$rand.".".$ext;
    $tmp = $_FILES['profiles']['tmp_name'];
    if(!$tmp){
        $name = NULL;
    } else copy($tmp,"../image/".$name);
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    $password = password_hash($password,PASSWORD_DEFAULT);
    //$password = $pdo->quote($password);
    //var_dump($_POST);die();
    try{
    $update = $pdo->query(" INSERT INTO tbl_user (username, password, name, surname, profiles, email, tel, addr, locality, district, province, zipcode, level)
            VALUES ('".$username."',
            '$password',
            '".$_POST['name']."',
            '".$_POST['surname']."',
            '".$name."',
            '".$_POST['email']."',
            '".$_POST['tel']."',
            '".$_POST['addr']."',
            '".$_POST['locality']."',
            '".$_POST['district']."',
            '".$_POST['province']."',
            '".$_POST['zipcode']."',
            '".$_POST['level']."') ");
    } catch (PDOException $e){
        var_dump($e);die();
    }
    //var_dump($update);die();
    if($update){
        echo "<script>window.history.go(-2);</script>";
    } else {
        echo "<script>alert('ไม่สามารถเพิ่มข้อมูลได้');</script>";
        echo "<script>window.history.back();</script>";
    }
} elseif (isset($_GET['action']) && $_GET['action']=="remove" && isset($_GET['username'])) {
    $update = $pdo->query(" DELETE FROM tbl_user where username = '".$_GET['username']."' ");
    echo "<script>window.history.back();</script>";
} elseif (isset($_GET['action']) && $_GET['action']=="edit" && isset($_POST['username'])){
    $ext = pathinfo($_FILES['profiles']['name'],PATHINFO_EXTENSION);
    $rand = rand(000000000,999999999);
    $name = "profiles".$rand.".".$ext;
    $tmp = $_FILES['profiles']['tmp_name'];
    if(!$tmp){
        $name = $_POST['noselect'];
    } 
    copy($tmp,"../image/".$name);

    $update = $pdo->query(" UPDATE tbl_user SET
            name = '".$_POST['name']."',
            surname = '".$_POST['surname']."',
            profiles = '".$name."',
            email = '".$_POST['email']."',
            tel = '".$_POST['tel']."',
            addr = '".$_POST['addr']."',
            locality = '".$_POST['locality']."',
            district = '".$_POST['district']."',
            province = '".$_POST['province']."',
            zipcode = '".$_POST['zipcode']."',
            level = '".$_POST['level']."' WHERE username = '".$_POST['username']."' ");
    if($update){
        echo "<script>window.history.go(-2);</script>";
    } else {
        echo "<script>alert('ไม่สามารถแก้ไขข้อมูลได้');</script>";
        echo "<script>window.history.back();</script>";
    }    
}
?>
<meta charset="utf-8" />