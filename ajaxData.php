
<?php require_once 'condb.php' ?>
<?php 
    $sql = $pdo->query(" SELECT * from tbl_order WHERE curtime()>date_add(dateOrder,interval 2 day) AND status = 'no' ");
    $numrow = $sql->rowCount();
    if($numrow>0)
    {
        while($rs_order = $sql->fetch(PDO::FETCH_ASSOC))
        {
            $del = $pdo->query("UPDATE tbl_order SET showOrder = 'no' WHERE orderID='".$rs_order['orderID']."' ");
            $sql2 = $pdo->query(" SELECT * FROM tbl_order_detail WHERE orderID = '".$rs_order['orderID']."' ");
            while($rs_detail = $sql2->fetch(PDO::FETCH_ASSOC)) {
                $update = $pdo->query(" DELETE FROM tbl_order_detail WHERE detailID='".$rs_detail['detailID']."' ");
            }
        }
    }
?>
