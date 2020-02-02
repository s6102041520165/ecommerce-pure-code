<?php require_once 'condb.php' ?>
<?php 
if(isset($_GET['cart']) && isset($_GET['line']) && $_GET['cart'] == 'remove' ){
    $line = $_GET['line'];
    $checkqty = $_SESSION['qty'][$line];//ตรวจสอบจำนวนชิ้นของสินค้า
    $_SESSION['countCart'] -= $checkqty;

    unset($_SESSION['proID'][$line]);
    unset($_SESSION['qty'][$line]);
    
    if($_SESSION['countCart']<=0){
        unset($_SESSION['countCart']);
    }
    echo "<script>window.history.back();</script>";
} else if(isset($_GET['cart']) && $_GET['cart'] == 'update' ){
    for($i=0;$i<=(int)$_SESSION['intline'];$i++){
        if($_SESSION['proID'][$i]!=NULL){
            $_SESSION['qty'][$i] = $_POST['qty'.$i];
            $_SESSION['countCart'] = $_SESSION['countCart'] - $_POST['qty'.$i];
            if($_SESSION['countCart']<=0){
                unset($_SESSION['countCart']);
            }
        }
    }
    echo "<script>window.history.back();</script>";
}
?>
