<?php 
require_once 'condb.php';


if(isset($_GET['pay']) && $_GET['pay']=='skip'){
    try{
        $query = $pdo->query("INSERT INTO `tbl_order`(`username`, `payoption`,`status`, `dateOrder`, `proTotal`, `tax`, `sumtotal`, `showOrder`) 
        VALUES (
        '".htmlspecialchars($_POST['username'])."',
        'bank',
        'no',
        NOW(),
        '".htmlspecialchars($_POST['prototal'])."',
        '".htmlspecialchars($_POST['tax'])."',
        '".htmlspecialchars($_POST['sumtotal'])."',
        'yes' ) ");
        
        $id = $pdo->lastInsertId();

    } catch(PDOExecption $e) {die();}
    
    for($i=0;$i<=(int)$_SESSION['intline'];$i++){
        if($_SESSION['proID'][$i]!=""){
            $query = $pdo->query("INSERT INTO `tbl_order_detail`(`orderID`, `proID`, `qty`) 
            VALUES ('".$id."','".$_SESSION['proID'][$i]."','".$_SESSION['qty'][$i]."') ");
        }
    }
    unset($_SESSION['intline']);
    unset($_SESSION['qty']);
    unset($_SESSION['proID']);
    unset($_SESSION['countCart']);
    header("Location: successfull.php");
}