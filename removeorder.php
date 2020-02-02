<?php 
require_once 'condb.php';
$update = $pdo->query(" UPDATE tbl_order SET showOrder = 'no' WHERE orderID='".$_GET['orderID']."' ");
echo "<script>window.history.back();</script>";
?>