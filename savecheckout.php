<?php 
require_once 'condb.php';
require_once dirname(__FILE__).'/omise-php/lib/Omise.php';
define('OMISE_PUBLIC_KEY', 'pkey_test_5eavs1d5xv4lfvr0jhv');

define('OMISE_SECRET_KEY', 'skey_test_5eav79cpmje29c2x6j5');
//skey_test_5cdmd9zxvv9hoyyynlh 

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
}else{
    try {
        $charge = OmiseCharge::create(array(
            'amount' => $_POST['sumtotal']*100,
            'currency' => 'thb',
            'card' => $_POST['omiseToken'],
        ));
    } catch (OmiseUsedTokenException $e){
        echo "ข้อผิดพลาดของ Token.";
    }

    if($charge['status']=='successful'){
        $query = $pdo->query("INSERT INTO `tbl_order`(`username`, `payoption`,`status`, `dateOrder`, `proTotal`, `tax`, `sumtotal`,`showOrder`) 
        VALUES (
        '".$_POST['username']."',
        'card',
        'yes',
        NOW(),
        '".$_POST['prototal']."',
        '".$_POST['tax']."',
        '".$_POST['sumtotal']."','yes' ) ");

        $id = $pdo->lastInsertId();
        $query2 = $pdo->query("INSERT INTO `tbl_card`(`orderID`,`amount`, `datepay`) 
        VALUES ('".$id."','".$_POST['sumtotal']."',NOW() )");
        for($i=0;$i<=(int)$_SESSION['intline'];$i++){
            if($_SESSION['proID'][$i]!=""){
                $query = $pdo->query("INSERT INTO `tbl_order_detail`(`orderID`, `proID`, `qty`) 
                VALUES ('".$id."','".$_SESSION['proID'][$i]."','".$_SESSION['qty'][$i]."') ");

                $query2 = $pdo->query(" UPDATE tbl_product 
                SET proQty = proQty-'".$_SESSION['qty'][$i]."' 
                WHERE proID='".$_SESSION['proID'][$i]."' LIMIT 1 ");
            }
        }
        unset($_SESSION['intline']);
        unset($_SESSION['qty']);
        unset($_SESSION['proID']);
        unset($_SESSION['countCart']);
        header("Location: successfull.php");
    } else {
        header("Location: checkout.php?load=failed");
    }
}
?>