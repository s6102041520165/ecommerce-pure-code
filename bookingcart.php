<?php 
require_once 'condb.php';
if(!isset($_SESSION['intline'])){
    $_SESSION['intline'] = 0;
    $_SESSION['proID'][0] = $_GET['proID'];
    $_SESSION['qty'][0] = 1;
    $_SESSION['countCart'] = 1;
} else {
    $key = array_search($_GET['proID'],$_SESSION['proID']);
    if((string)$key!=null){
        $_SESSION['qty'][$key] = $_SESSION['qty'][$key]+1;
        $_SESSION['countCart'] += 1;
    } else {
        $_SESSION['intline'] = $_SESSION['intline']+1;
        $newline = $_SESSION['intline'];
        $_SESSION['proID'][$newline] = $_GET['proID'];
        $_SESSION['qty'][$newline] = 1;
        $_SESSION['countCart'] += 1;
    }
}
echo "<script>window.history.back()</script>";
?>