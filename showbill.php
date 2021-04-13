<?php require_once 'header.php' ?>
<?php require_once 'sidebar.php' ?>


<div class="col-md-9 col-lg-9">
<br>
    <div class="card border-info">
        <div class="card-header bg-info text-white">
            <span class="fa fa-shopping-cart"></span> ใบสั่งซื้อ
        </div>
        <div class="card-body">
            
            <iframe src="bill.php?orderID=<?php echo $_GET['orderID']; ?>" frameborder="0" style="height:29.7cm;width:100%"></iframe>
        </div>
    </div> 
</div>
<?php require_once 'footer.php' ?>