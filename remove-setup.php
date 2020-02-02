<?php 
require_once 'condb.php';
if($pdo){
    array_map('unlink', glob("installation/*"));
    rmdir('installation');
    header("Location: index.php");
} else {
    echo "Cannot romoved file";
}
?>