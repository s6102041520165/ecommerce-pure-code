<?php 
session_start();

unset($_SESSION['web']);
echo "<script>window.history.back();</script>";
?>